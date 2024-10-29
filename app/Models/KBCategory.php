<?php

namespace App\Models;

use App\Models\Traits\Sluggable;
use App\Models\Traits\Paginatable;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KBCategory extends Model
{
    use HasEagerLimit;
    use HasFactory;
    use Paginatable;
    use Sluggable;

    public $with = ['parent:id,name,slug'];

    protected $fillable = ['name', 'title', 'slug', 'description', 'k_b_category_id', 'order_no', 'private', 'active'];

    public function children()
    {
        return $this->hasMany(self::class, 'k_b_category_id');
    }

    public function knowledgeBase()
    {
        return $this->belongsToMany(KnowledgeBase::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'k_b_category_id');
    }

    public function scopeActive($query)
    {
        $query->where('active', 1);
    }

    public function scopeMain($query)
    {
        $query->whereNull('k_b_category_id');
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
        $allCategories = KBCategory::query()
            ->withCount('knowledgeBase as total')->orderBy('order_no', 'asc')->orderBy('name', 'asc')
            ->when(! $all, fn ($q) => $q->public()->active())->get($columns);
        $categories = $allCategories->whereNull('k_b_category_id');
        self::makeTree($categories, $allCategories);

        return $categories;
    }

    private static function makeTree($categories, $allCategories)
    {
        foreach ($categories as $category) {
            $category->children = $allCategories->where('k_b_category_id', $category->id)->values();
            if ($category->children->isNotEmpty()) {
                $category->setRelation('children', $category->children);
                self::makeTree($category->children, $allCategories);
            }
        }
    }
}
