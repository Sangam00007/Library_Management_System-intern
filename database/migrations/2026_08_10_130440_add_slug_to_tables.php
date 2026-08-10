<?php

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = ['books', 'categories', 'authors', 'publishers'];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('slug')->nullable()->unique()->after('id');
            });
        }

        // Seed slugs for existing records
        $this->seedSlugs(Book::class);
        $this->seedSlugs(Category::class);
        $this->seedSlugs(Author::class);
        $this->seedSlugs(Publisher::class);
    }

    protected function seedSlugs($modelClass)
    {
        $records = $modelClass::all();
        foreach ($records as $record) {
            $record->generateSlug();
            $record->saveQuietly();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['books', 'categories', 'authors', 'publishers'];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
};
