<?php

namespace App\Models;

use App\Models\Traits\Sluggable;
use Spatie\Searchable\Searchable;
use App\Models\Traits\Paginatable;
use Spatie\Searchable\SearchResult;
use App\Concerns\HasSchemalessAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model implements Searchable
{
    use HasFactory;
    use HasSchemalessAttributes;
    use Paginatable;
    use Sluggable;

    public static $slugFromColumn = 'question';

    public $with = ['faqCategories:id,name,slug'];

    protected $fillable = ['question', 'answer', 'slug', 'faq_category_id', 'active', 'order_no', 'extra_attributes'];

    public function faqCategories()
    {
        return $this->belongsToMany(FaqCategory::class);
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult($this, $this->question, route('faqs.show', $this->slug));
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
