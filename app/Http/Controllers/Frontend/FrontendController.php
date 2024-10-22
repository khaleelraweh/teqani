<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AboutInstatute;
use App\Models\Page;
use App\Models\Post;
use App\Models\Slider;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {

        $main_sliders = Slider::with('firstMedia')
            ->orderBy('published_on', 'desc')
            ->Active()
            ->take(
                8
            )
            ->get();

        $about_instatute = AboutInstatute::get()->first();
        $posts = Post::with('photos')->where('section', 1)->orderBy('created_at', 'ASC')->get();


        return view('frontend.index', compact('main_sliders', 'about_instatute', 'posts'));
    }


    public function pages($slug)
    {
        $page = Page::where('slug->' . app()->getLocale(), $slug)
            ->firstOrFail();


        // Retrieve the latest 3 posts from section 1, excluding the current post
        $latest_posts = Post::with('photos')
            ->where('section', 1)
            ->orderBy('created_at', 'ASC')
            ->take(3)
            ->get();

        return view('frontend.pages', compact('page', 'latest_posts'));
    }

    public function blog_list($slug = null)
    {
        return view('frontend.blog-list', compact('slug'));
    }

    public function blog_single($slug)
    {
        $post = Post::with('photos', 'tags')
            ->where('slug->' . app()->getLocale(), $slug)
            ->firstOrFail();


        // Retrieve the latest 3 posts from section 1, excluding the current post
        $latest_posts = Post::with('photos')
            ->where('section', 1)
            ->where('id', '!=', $post->id) // Exclude the current post
            ->orderBy('created_at', 'ASC')
            ->take(3)
            ->get();


        // Generate WhatsApp share URL
        $whatsappShareUrl = 'https://api.whatsapp.com/send?text=' . urlencode($post->name . ': ' . route('frontend.blog_single', $post->slug));

        return view('frontend.blog-single', compact('post', 'latest_posts',  'whatsappShareUrl'));
    }
}
