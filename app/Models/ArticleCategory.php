<?php

namespace App\Models;

use App\Models\Traits\Sluggable;
use App\Models\Traits\Paginatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticleCategory extends Model
{
    use HasFactory;
    use Paginatable;
    use Sluggable;

    public $with = ['parent:id,name,slug'];

    protected $fillable = ['name', 'title', 'slug', 'description', 'article_category_id', 'order_no', 'private', 'active'];

    public function children()
    {
        return $this->hasMany(self::class, 'article_category_id');
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'article_category_id');
    }

    public function scopeActive($query)
    {
        $query->where('active', 1);
    }

    public function scopeMain($query)
    {
        $query->whereNull('article_category_id');
    }

    public function scopePrivate($query)
    {
        $query->where('private', 1);
    }

    public function scopePublic($query)
    {
        $query->whereNull('private')->orWhere('private', 0);
    }

    public static function tree($columns = null, $all = false)
    {
        $allCategories = ArticleCategory::query()->withCount('articles as total')
            ->orderBy('order_no', 'asc')->orderBy('name', 'asc')
            ->when(! $all, fn ($q) => $q->public()->active())->get($columns);
        $categories = $allCategories->whereNull('article_category_id');
        self::makeTree($categories, $allCategories);

        return $categories;
    }

    private static function makeTree($categories, $allCategories)
    {
        foreach ($categories as $category) {
            $category->children = $allCategories->where('article_category_id', $category->id)->values();
            if ($category->children->isNotEmpty()) {
                $category->setRelation('children', $category->children);
                self::makeTree($category->children, $allCategories);
            }
        }
    }
}
