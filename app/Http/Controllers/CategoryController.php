<?php

namespace App\Http\Controllers;

use App\Models\Tool;

class CategoryController extends Controller
{
    public function youtube()
    {
        return $this->showCategory('youtube');
    }

    public function seo()
    {
        return $this->showCategory('seo');
    }

    public function utility()
    {
        return $this->showCategory('utility');
    }

    public function network()
    {
        return $this->showCategory('network');
    }

    public function image()
    {
        return $this->showCategory('image');
    }

    public function document()
    {
        return $this->showCategory('document');
    }

    public function time()
    {
        return $this->showCategory('time');
    }

    public function text()
    {
        return $this->showCategory('text');
    }

    public function development()
    {
        return $this->showCategory('development');
    }

    public function converters()
    {
        return $this->showCategory('converters');
    }

    public function spreadsheet()
    {
        return $this->showCategory('spreadsheet');
    }

    public function videoDownloader()
    {
        return $this->showCategory('video-downloader');
    }

    public function downloader()
    {
        return $this->showCategory('downloader');
    }

    private function showCategory($slug)
    {
        $category = \App\Models\Category::where('slug', $slug)->firstOrFail();

        // Fetch all active tools for this category
        $tools = $category->tools()->active()->orderBy('name', 'asc')->get();

        return view('categories.index', compact('category', 'tools'));
    }
}
