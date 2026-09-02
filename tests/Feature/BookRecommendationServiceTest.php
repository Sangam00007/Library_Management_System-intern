<?php

use App\Models\Author;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\User;
use App\Services\BookRecommendationService;
use Illuminate\Support\Facades\Cache;

beforeEach(function () {
    Cache::flush();
    $this->service = new BookRecommendationService;
});

it('prioritizes books matching user preferred categories', function () {
    $preferredCategory = Category::factory()->create();
    $otherCategory = Category::factory()->create();

    $matchingBook = Book::factory()->create(['category_id' => $preferredCategory->id]);
    $otherBook = Book::factory()->create(['category_id' => $otherCategory->id]);

    $user = User::factory()->create([
        'preferences' => [
            'categories' => [$preferredCategory->id],
            'authors' => [],
            'publishers' => [],
        ],
        'wizard_completed' => true,
    ]);

    $recommendations = $this->service->getRecommendationsForUser($user, 10);

    expect($recommendations->first()->id)->toBe($matchingBook->id);
});

it('prioritizes books matching user preferred authors', function () {
    $preferredAuthor = Author::factory()->create();
    $otherAuthor = Author::factory()->create();

    $matchingBook = Book::factory()->create(['author_id' => $preferredAuthor->id]);
    $otherBook = Book::factory()->create(['author_id' => $otherAuthor->id]);

    $user = User::factory()->create([
        'preferences' => [
            'categories' => [],
            'authors' => [$preferredAuthor->id],
            'publishers' => [],
        ],
        'wizard_completed' => true,
    ]);

    $recommendations = $this->service->getRecommendationsForUser($user, 10);

    expect($recommendations->first()->id)->toBe($matchingBook->id);
});

it('uses collaborative filtering to surface books borrowed by similar users', function () {
    $sharedBook = Book::factory()->create();
    $recommendedBook = Book::factory()->create();
    $unrelatedBook = Book::factory()->create();

    $currentUser = User::factory()->create([
        'preferences' => ['categories' => [], 'authors' => [], 'publishers' => []],
        'wizard_completed' => true,
    ]);

    $similarUser = User::factory()->create();

    // Both users borrowed the shared book
    Borrowing::factory()->create(['user_id' => $currentUser->id, 'book_id' => $sharedBook->id]);
    Borrowing::factory()->create(['user_id' => $similarUser->id, 'book_id' => $sharedBook->id]);

    // Similar user also borrowed the recommended book
    Borrowing::factory()->create(['user_id' => $similarUser->id, 'book_id' => $recommendedBook->id]);

    $recommendations = $this->service->getRecommendationsForUser($currentUser, 10);

    $recommendedIds = $recommendations->pluck('id')->toArray();

    // The recommended book should appear (collaborative signal)
    expect($recommendedIds)->toContain($recommendedBook->id);
    // The already-borrowed shared book should NOT appear
    expect($recommendedIds)->not->toContain($sharedBook->id);
});

it('excludes books the user has already borrowed', function () {
    $borrowedBook = Book::factory()->create();
    $unborrowed = Book::factory()->create();

    $user = User::factory()->create([
        'preferences' => ['categories' => [], 'authors' => [], 'publishers' => []],
        'wizard_completed' => true,
    ]);

    Borrowing::factory()->create(['user_id' => $user->id, 'book_id' => $borrowedBook->id]);

    $recommendations = $this->service->getRecommendationsForUser($user, 10);

    expect($recommendations->pluck('id')->toArray())->not->toContain($borrowedBook->id);
    expect($recommendations->pluck('id')->toArray())->toContain($unborrowed->id);
});

it('falls back to popularity-based recommendations for new users', function () {
    $popularBook = Book::factory()->create();
    $unpopularBook = Book::factory()->create();

    // Make one book popular by giving it many borrowings
    $borrowers = User::factory()->count(5)->create();
    foreach ($borrowers as $borrower) {
        Borrowing::factory()->create(['user_id' => $borrower->id, 'book_id' => $popularBook->id]);
    }

    // New user with no preferences and no history
    $newUser = User::factory()->create([
        'preferences' => null,
        'wizard_completed' => false,
    ]);

    $recommendations = $this->service->getRecommendationsForUser($newUser, 10);

    expect($recommendations)->not->toBeEmpty();
    // Popular book should be ranked higher
    expect($recommendations->first()->id)->toBe($popularBook->id);
});

it('returns similar books for a given book based on category and author', function () {
    $category = Category::factory()->create();
    $author = Author::factory()->create();

    $targetBook = Book::factory()->create([
        'category_id' => $category->id,
        'author_id' => $author->id,
    ]);

    $sameCategoryAndAuthor = Book::factory()->create([
        'category_id' => $category->id,
        'author_id' => $author->id,
    ]);

    $sameCategoryOnly = Book::factory()->create([
        'category_id' => $category->id,
    ]);

    $differentBook = Book::factory()->create();

    $similarBooks = $this->service->getRecommendationsForBook($targetBook, 10);
    $ids = $similarBooks->pluck('id')->toArray();

    // Same category + author should rank highest
    expect($ids[0])->toBe($sameCategoryAndAuthor->id);
    // Same category only should also appear
    expect($ids)->toContain($sameCategoryOnly->id);
});

it('does not include the target book in similar book recommendations', function () {
    $book = Book::factory()->create();
    Book::factory()->count(3)->create(['category_id' => $book->category_id]);

    $similar = $this->service->getRecommendationsForBook($book, 10);

    expect($similar->pluck('id')->toArray())->not->toContain($book->id);
});

it('invalidates cache when called', function () {
    $user = User::factory()->create([
        'preferences' => ['categories' => [], 'authors' => [], 'publishers' => []],
        'wizard_completed' => true,
    ]);

    Book::factory()->count(3)->create();

    // Prime the cache
    $this->service->getRecommendationsForUser($user, 12);
    expect(Cache::has("recommendations:user:{$user->id}:12"))->toBeTrue();

    // Invalidate
    $this->service->invalidateForUser($user);
    expect(Cache::has("recommendations:user:{$user->id}:12"))->toBeFalse();
});

it('attaches recommendation reasons to recommended books', function () {
    $category = Category::factory()->create(['name' => 'Science Fiction']);

    $book = Book::factory()->create(['category_id' => $category->id]);

    $user = User::factory()->create([
        'preferences' => [
            'categories' => [$category->id],
            'authors' => [],
            'publishers' => [],
        ],
        'wizard_completed' => true,
    ]);

    $recommendations = $this->service->getRecommendationsForUser($user, 10);

    $recommended = $recommendations->firstWhere('id', $book->id);
    expect($recommended)->not->toBeNull();
    expect($recommended->recommendation_reason)->toBe('Because you like Science Fiction');
});

it('returns the dashboard page with recommended books', function () {
    $user = User::factory()->create([
        'preferences' => ['categories' => [], 'authors' => [], 'publishers' => []],
        'wizard_completed' => true,
    ]);

    Book::factory()->count(3)->create();

    $response = $this->actingAs($user)->get(route('user.dashboard'));

    $response->assertStatus(200);
    $response->assertViewHas('recommendedBooks');
});

it('returns the book show page with similar books', function () {
    $book = Book::factory()->create();
    Book::factory()->count(3)->create(['category_id' => $book->category_id]);

    $user = User::factory()->create([
        'wizard_completed' => true,
    ]);

    $response = $this->actingAs($user)->get(route('user.books.show', $book));

    $response->assertStatus(200);
    $response->assertViewHas('similarBooks');
});
