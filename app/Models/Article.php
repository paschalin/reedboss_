<?php

namespace App\Models;

use App\Models\Traits\Sluggable;
use Spatie\Searchable\Searchable;
use App\Models\Traits\Paginatable;
use Spatie\Searchable\SearchResult;
use App\Models\Traits\GroupPermission;
use App\Concerns\HasSchemalessAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model implements Searchable
{
    use GroupPermission;
    use HasFactory;
    use HasSchemalessAttributes;
    use Paginatable;
    use Sluggable;

    public $with = ['articleCategories:id,name,slug', 'user:id,name,username,profile_photo_path'];

    protected $fillable = ['title', 'slug', 'description', 'body', 'order_no', 'active', 'user_id', 'extra_attributes', 'image', 'group', 'article_category_id'];

    public function articleCategories()
    {
        return $this->belongsToMany(ArticleCategory::class);
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult($this, $this->title, route('articles.show', $this->slug));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    protected static function booted(): void
    {
        static::creating(function (Article $article) {
            $article->user_id = $article->user_id ?? auth()->id();
        });
    }
}
