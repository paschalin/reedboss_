<?php

namespace App\Models;

use App\Models\Traits\Sluggable;
use Spatie\Searchable\Searchable;
use App\Models\Traits\Paginatable;
use Spatie\Searchable\SearchResult;
use App\Concerns\HasSchemalessAttributes;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KnowledgeBase extends Model implements Searchable
{
    use HasEagerLimit;
    use HasFactory;
    use HasSchemalessAttributes;
    use Paginatable;
    use Sluggable;

    public $with = ['KBCategories:id,name,slug'];

    protected $fillable = ['title', 'slug', 'body', 'k_b_category_id', 'active', 'order_no', 'extra_attributes'];

    protected $table = 'knowledge_base';

    public function getSearchResult(): SearchResult
    {
        return new SearchResult($this, $this->title, route('knowledgebase.show', $this->slug));
    }

    public function KBCategories()
    {
        return $this->belongsToMany(KBCategory::class);
    }

    public function scopeActive($query)
    {
        $query->where('active', 1);
    }

    public function scopeSearch($query, $search)
    {
        $query->where('question', 'like', "%{$search}%")
            ->orWhere('answer', 'like', "%{$search}%")
            ->orWhereHas('categories', fn ($q) => $q->where('name', 'like', "%{$search}%"));
    }
}
