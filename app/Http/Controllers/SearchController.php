<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Tag;
use App\Models\User;
use App\Models\Thread;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\KnowledgeBase;
use Spatie\Searchable\Search;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        return (new Search())
            ->registerModel(Thread::class, ['title', 'description', 'body'])
            ->registerModel(KnowledgeBase::class, ['title', 'body'])
            ->registerModel(Article::class, ['title', 'body'])
            ->registerModel(Faq::class, ['question', 'answer'])
            ->limitAspectResults(10)
            ->search($request->input('query'));
    }

    public function tags(Request $request)
    {
        return Tag::where('name', 'like', "%{$request->input('search')}%")->limit(10)->get(['id', 'name']);
    }

    public function users(Request $request)
    {
        return User::search($request->input('search'))->limit(10)->get(['id', 'name', 'username']);
    }
}
