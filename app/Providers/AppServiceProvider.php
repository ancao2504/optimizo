<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

use Illuminate\Support\Facades\View;
use App\Models\Tool;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer('*', function ($view) {
            $locale = app()->getLocale();
            $localePrefix = $locale === 'en' ? '' : '/' . $locale;

            // Select category_id instead of legacy category string
            $tools = Tool::select('name', 'slug', 'category_id', 'is_active', 'url') // Added 'url'
                ->where('is_active', true)
                ->with(['categoryRelation']) // Eager load category
                ->get()
                ->map(function ($tool) use ($localePrefix) {
                    $categoryName = $tool->categoryRelation ? $tool->categoryRelation->slug : 'other';
                    // Prioritize H1 (h1) then Meta Title (name)
                    $toolName = __t($tool, 'h1') ?: __t($tool, 'name') ?: $tool->name;

                    // Fallback check: if __t returns the key string (starts with tools/)
                    if (str_starts_with($toolName, 'tools/')) {
                        $toolName = __t($tool, 'name') ?: $tool->name;
                    }

                    return [
                        'name' => $toolName,
                        'category' => $categoryName,
                        'url' => $localePrefix . $tool->url,
                    ];
                });

            $view->with('searchableTools', $tools);
        });
    }
}
