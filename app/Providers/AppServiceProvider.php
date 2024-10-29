<?php

namespace App\Providers;

use App\Models\Tag;
use App\Models\User;
use App\Models\Thread;
use App\Models\Category;
use App\Models\KBCategory;
use App\Models\FaqCategory;
use App\Mail\EmailVerification;
use App\Models\ArticleCategory;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        app()->useLangPath(base_path('lang'));

        try {
            $settings = [];
            if (env('APP_INSTALLED')) {
                $settings = site_config();
                Model::preventLazyLoading(! $this->app->isProduction());
                Gate::before(fn ($user) => $user->hasRole('super') ? true : null);
                if (($settings['captcha_provider'] ?? null) && ($settings['captcha_site_key'] ?? null) && ($settings['captcha_secret_key'] ?? null)) {
                    config(['captcha.sitekey' => $settings['captcha_site_key']]);
                    config(['captcha.secret' => $settings['captcha_secret_key']]);
                }

                $this->app['validator']->extend('localCaptcha', function ($attribute, $value, $parameters) {
                    return config('captcha.disable') || ($value && captcha_check($value));
                });

                View::composer('components.navigation-menu', function ($view) {
                    $view->with('threads_require_review', auth()->user()?->can('review') ? Thread::flagged()->count() : null);
                    $view->with('threads_require_approval', auth()->user()?->can('approve-threads') ? Thread::notApproved()->count() : null);
                });

                View::composer('*', function ($view) use ($settings) {
                    $view->with('settings', $settings);
                    $view->with('logged_in_user', auth()->user());
                });

                View::composer([
                    'layouts.public',
                    'livewire.forum.form',
                    'livewire.category.list',
                    'components.thread-actions',
                    'components.navigation-menu',
                ], function ($view) {
                    $view->with('categoriesMenu', cache()->remember('categoriesMenu', 60, fn () => Category::tree(['id', 'slug', 'name', 'category_id', 'view_group', 'create_group'])));
                });

                if ($settings['tags_cloud'] ?? null) {
                    View::composer(['layouts.public'], function ($view) {
                        $view->with('tagsCloud', cache()->remember('tagsCloud', 60, fn () => Tag::select(['id', 'name'])->withCount('threads')->having('threads_count', '>=', 1)->get()));
                    });
                }

                View::composer([
                    'layouts.public',
                    'components.navigation-menu',
                ], function ($view) {
                    $view->with('unreadCount', cache()->remember('user_notifications', 60, fn () => auth()->user()?->unreadNotifications()->count()));
                    $view->with('articleCategoriesMenu', request()->routeIs('articles.*') ? cache()->remember('articleCategoriesMenu', 60, fn () => ArticleCategory::tree(['id', 'name', 'slug', 'article_category_id'])) : []);
                    $view->with('faqCategoriesMenu', request()->routeIs('faqs.*') ? cache()->remember('faqCategoriesMenu', 60, fn () => FaqCategory::tree(['id', 'name', 'slug', 'faq_category_id'])) : []);
                    $view->with('kbCategoriesMenu', request()->routeIs('knowledgebase.*') ? cache()->remember('kbCategoriesMenu', 60, fn () => KBCategory::tree(['id', 'name', 'slug', 'k_b_category_id'])) : []);
                    $view->with(
                        'top_users',
                        cache()->remember(
                            'top_users',
                            60, // 1 minute
                            fn () => User::withCount([
                                'replies' => fn ($q) => $q->whereBetween('created_at', [now()->subDays(7), now()]),
                            ])->having('replies_count', '>=', 5)->orderBy('replies_count', 'desc')->take(5)->get()
                        )
                    );
                    $view->with(
                        'trending_threads',
                        cache()->remember(
                            'trending_threads',
                            60, // 1 minute
                            fn () => Thread::select(['title', 'user_id', 'slug', 'views', 'description'])
                                ->approved()->withCount([
                                    'replies',
                                    'replies as last_week' => fn ($q) => $q->whereBetween('created_at', [now()->subDays(7), now()]),
                                ])->having('last_week', '>=', 5)->orderBy('last_week', 'desc')->take(5)->get()
                        )
                    );
                });

                VerifyEmail::toMailUsing(function ($notifiable) {
                    $verifyUrl = url()->temporarySignedRoute(
                        'verification.verify',
                        \Illuminate\Support\Carbon::now()->addMinutes(config('auth.verification.expire', 60)),
                        [
                            'id'   => $notifiable->getKey(),
                            'hash' => sha1($notifiable->getEmailForVerification()),
                        ]
                    );

                    return new EmailVerification($verifyUrl, $notifiable);
                });
            } else {
                View::composer('*', function ($view) use ($settings) {
                    $view->with('settings', $settings);
                    $view->with('logged_in_user', auth()->user());
                });
            }
        } catch (\Exception $e) {
        }
    }

    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
        }
    }
}
