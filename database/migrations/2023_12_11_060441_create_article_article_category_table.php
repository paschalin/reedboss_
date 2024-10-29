<?php

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->foreignIdFor(ArticleCategory::class)->nullable()->constrained();
        });

        Schema::create('article_article_category', function (Blueprint $table) {
            $table->foreignIdFor(Article::class)->constrained();
            $table->foreignIdFor(ArticleCategory::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropConstrainedForeignIdFor(ArticleCategory::class);
        });

        Schema::dropIfExists('article_article_category');
    }
};
