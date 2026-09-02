<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BookRecommendationService
{
    /**
     * Scoring weights for the hybrid recommendation algorithm.
     *
     * @var array{category: float, author: float, publisher: float, collaborative: float, popularity: float, recency: float}
     */
    private const WEIGHTS = [
        'category' => 0.30,
        'author' => 0.25,
        'publisher' => 0.10,
        'collaborative' => 0.20,
        'popularity' => 0.10,
        'recency' => 0.05,
    ];

    /** Cache duration in seconds (1 hour). */
    private const CACHE_TTL = 3600;

    /**
     * Get personalized book recommendations for a user.
     *
     * Uses a hybrid scoring approach combining content-based filtering
     * (preferences), collaborative filtering (borrowing patterns),
     * popularity, and recency signals.
     *
     * @return Collection<int, Book>
     */
    public function getRecommendationsForUser(User $user, int $limit = 12): Collection
    {
        $cacheKey = "recommendations:user:{$user->id}:{$limit}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($user, $limit) {
            return $this->computeUserRecommendations($user, $limit);
        });
    }

    /**
     * Get similar book recommendations for a specific book ("You May Also Like").
     *
     * @return Collection<int, Book>
     */
    public function getRecommendationsForBook(Book $book, int $limit = 6): Collection
    {
        $cacheKey = "recommendations:book:{$book->id}:{$limit}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($book, $limit) {
            return $this->computeBookRecommendations($book, $limit);
        });
    }

    /**
     * Invalidate recommendation cache for a specific user.
     */
    public function invalidateForUser(User $user): void
    {
        Cache::forget("recommendations:user:{$user->id}:12");
    }

    /**
     * Compute personalized recommendations from scratch.
     *
     * @return Collection<int, Book>
     */
    private function computeUserRecommendations(User $user, int $limit): Collection
    {
        $preferences = $user->preferences ?? [];
        $preferredCategories = $preferences['categories'] ?? [];
        $preferredAuthors = $preferences['authors'] ?? [];
        $preferredPublishers = $preferences['publishers'] ?? [];

        $userBorrowedBookIds = Borrowing::where('user_id', $user->id)
            ->pluck('book_id')
            ->unique()
            ->toArray();

        $collaborativeBookIds = $this->getCollaborativeBookIds($userBorrowedBookIds, $user->id);

        $maxBorrowCount = $this->getMaxBorrowCount();

        $candidateBooks = Book::with(['author', 'category', 'publisher'])
            ->whereNotIn('id', $userBorrowedBookIds)
            ->get();

        if ($candidateBooks->isEmpty()) {
            return $candidateBooks;
        }

        $scoredBooks = $candidateBooks->map(function (Book $book) use (
            $preferredCategories,
            $preferredAuthors,
            $preferredPublishers,
            $collaborativeBookIds,
            $maxBorrowCount,
        ) {
            $score = $this->calculateHybridScore(
                $book,
                $preferredCategories,
                $preferredAuthors,
                $preferredPublishers,
                $collaborativeBookIds,
                $maxBorrowCount,
            );

            $book->setAttribute('recommendation_score', round($score, 2));
            $book->setAttribute('recommendation_reason', $this->determineReason(
                $book,
                $preferredCategories,
                $preferredAuthors,
                $collaborativeBookIds,
            ));

            return $book;
        });

        return $scoredBooks
            ->sortByDesc('recommendation_score')
            ->take($limit)
            ->values();
    }

    /**
     * Compute similar books for a given book.
     *
     * @return Collection<int, Book>
     */
    private function computeBookRecommendations(Book $book, int $limit): Collection
    {
        $maxBorrowCount = $this->getMaxBorrowCount();

        $coBorrowedBookIds = $this->getCoBorrowedBookIds($book->id);

        $candidates = Book::with(['author', 'category', 'publisher'])
            ->where('id', '!=', $book->id)
            ->get();

        if ($candidates->isEmpty()) {
            return $candidates;
        }

        $scored = $candidates->map(function (Book $candidate) use ($book, $coBorrowedBookIds, $maxBorrowCount) {
            $score = 0.0;

            // Same category (40% weight for book-to-book similarity)
            if ($candidate->category_id && $candidate->category_id === $book->category_id) {
                $score += 40;
            }

            // Same author (30% weight)
            if ($candidate->author_id && $candidate->author_id === $book->author_id) {
                $score += 30;
            }

            // Same publisher (10% weight)
            if ($candidate->publisher_id && $candidate->publisher_id === $book->publisher_id) {
                $score += 10;
            }

            // Co-borrowed signal (15% weight)
            if (in_array($candidate->id, $coBorrowedBookIds)) {
                $score += 15;
            }

            // Popularity (5% weight)
            $score += $this->calculatePopularityScore($candidate, $maxBorrowCount) * 5;

            $candidate->setAttribute('recommendation_score', round($score, 2));

            return $candidate;
        });

        return $scored
            ->sortByDesc('recommendation_score')
            ->take($limit)
            ->values();
    }

    /**
     * Calculate the composite hybrid score for a candidate book.
     *
     * @param  list<int>  $preferredCategories
     * @param  list<int>  $preferredAuthors
     * @param  list<int>  $preferredPublishers
     * @param  list<int>  $collaborativeBookIds
     */
    private function calculateHybridScore(
        Book $book,
        array $preferredCategories,
        array $preferredAuthors,
        array $preferredPublishers,
        array $collaborativeBookIds,
        int $maxBorrowCount,
    ): float {
        $categoryScore = $this->calculateContentMatch($book->category_id, $preferredCategories);
        $authorScore = $this->calculateContentMatch($book->author_id, $preferredAuthors);
        $publisherScore = $this->calculateContentMatch($book->publisher_id, $preferredPublishers);
        $collaborativeScore = in_array($book->id, $collaborativeBookIds) ? 100.0 : 0.0;
        $popularityScore = $this->calculatePopularityScore($book, $maxBorrowCount) * 100;
        $recencyScore = $this->calculateRecencyScore($book);

        return ($categoryScore * self::WEIGHTS['category'])
            + ($authorScore * self::WEIGHTS['author'])
            + ($publisherScore * self::WEIGHTS['publisher'])
            + ($collaborativeScore * self::WEIGHTS['collaborative'])
            + ($popularityScore * self::WEIGHTS['popularity'])
            + ($recencyScore * self::WEIGHTS['recency']);
    }

    /**
     * Check if a book's attribute matches user preferences (returns 0 or 100).
     *
     * @param  list<int>  $preferredIds
     */
    private function calculateContentMatch(?int $attributeId, array $preferredIds): float
    {
        if (! $attributeId || empty($preferredIds)) {
            return 0.0;
        }

        return in_array($attributeId, $preferredIds) ? 100.0 : 0.0;
    }

    /**
     * Calculate a normalized popularity score based on borrowing count.
     */
    private function calculatePopularityScore(Book $book, int $maxBorrowCount): float
    {
        if ($maxBorrowCount <= 0) {
            return 0.0;
        }

        $borrowCount = $book->borrowings()->count();

        return $borrowCount / $maxBorrowCount;
    }

    /**
     * Calculate a recency score — newer books get higher scores.
     * Decays linearly over 1 year.
     */
    private function calculateRecencyScore(Book $book): float
    {
        $daysOld = $book->created_at->diffInDays(now());
        $maxDays = 365;

        if ($daysOld >= $maxDays) {
            return 0.0;
        }

        return (($maxDays - $daysOld) / $maxDays) * 100;
    }

    /**
     * Get book IDs recommended via collaborative filtering.
     *
     * Finds users who borrowed the same books, then collects
     * other books those users borrowed (item-item similarity).
     *
     * @param  list<int>  $userBorrowedBookIds
     * @return list<int>
     */
    private function getCollaborativeBookIds(array $userBorrowedBookIds, int $userId): array
    {
        if (empty($userBorrowedBookIds)) {
            return [];
        }

        // Find users who borrowed at least one of the same books
        $similarUserIds = Borrowing::whereIn('book_id', $userBorrowedBookIds)
            ->where('user_id', '!=', $userId)
            ->pluck('user_id')
            ->unique()
            ->toArray();

        if (empty($similarUserIds)) {
            return [];
        }

        // Get books those similar users also borrowed (excluding already-borrowed)
        return Borrowing::whereIn('user_id', $similarUserIds)
            ->whereNotIn('book_id', $userBorrowedBookIds)
            ->select('book_id', DB::raw('COUNT(*) as borrow_count'))
            ->groupBy('book_id')
            ->orderByDesc('borrow_count')
            ->limit(50)
            ->pluck('book_id')
            ->toArray();
    }

    /**
     * Get books co-borrowed with a specific book.
     *
     * @return list<int>
     */
    private function getCoBorrowedBookIds(int $bookId): array
    {
        $userIds = Borrowing::where('book_id', $bookId)
            ->pluck('user_id')
            ->unique()
            ->toArray();

        if (empty($userIds)) {
            return [];
        }

        return Borrowing::whereIn('user_id', $userIds)
            ->where('book_id', '!=', $bookId)
            ->select('book_id', DB::raw('COUNT(*) as borrow_count'))
            ->groupBy('book_id')
            ->orderByDesc('borrow_count')
            ->limit(20)
            ->pluck('book_id')
            ->toArray();
    }

    /**
     * Get the maximum borrow count across all books for normalization.
     */
    private function getMaxBorrowCount(): int
    {
        return (int) Borrowing::select('book_id', DB::raw('COUNT(*) as cnt'))
            ->groupBy('book_id')
            ->orderByDesc('cnt')
            ->value('cnt') ?? 0;
    }

    /**
     * Determine the primary reason for recommending a book.
     *
     * @param  list<int>  $preferredCategories
     * @param  list<int>  $preferredAuthors
     * @param  list<int>  $collaborativeBookIds
     */
    private function determineReason(
        Book $book,
        array $preferredCategories,
        array $preferredAuthors,
        array $collaborativeBookIds,
    ): string {
        if ($book->category_id && in_array($book->category_id, $preferredCategories) && $book->relationLoaded('category')) {
            return "Because you like {$book->category->name}";
        }

        if ($book->author_id && in_array($book->author_id, $preferredAuthors) && $book->relationLoaded('author')) {
            return "By {$book->author->name}, one of your favorites";
        }

        if (in_array($book->id, $collaborativeBookIds)) {
            return 'Readers like you enjoyed this';
        }

        $borrowCount = $book->borrowings()->count();
        if ($borrowCount > 0) {
            return 'Popular with readers';
        }

        return 'Recently added';
    }
}
