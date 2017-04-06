<?php

namespace App\Http\Controllers\Frontend;

use Auth;
use Canvas\Models\Tag;
use Canvas\Models\Post;
use Canvas\Models\User;
use Canvas\Models\Settings;
use Illuminate\Http\Request;
use Canvas\Jobs\BlogIndexData;
use Canvas\Http\Controllers\Controller;

class BlogController extends Controller
{

    /**
     * Display a blog post page.
     *
     * @param $slug
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showPost($slug, Request $request)
    {
        $post = Post::with('tags')->whereSlug($slug)->firstOrFail();
        $socialHeaderIconsUser = User::where('id', Settings::socialHeaderIconsUserId())->first();
        $user = User::where('id', $post->user_id)->firstOrFail();
        $tag = $request->get('tag');
        $title = $post->title;
        $css = Settings::customCSS();
        $js = Settings::customJS();

        if ($tag) {
            $tag = Tag::whereTag($tag)->firstOrFail();
        }

        if (! $post->is_published && ! Auth::check()) {
            return redirect()->route('canvas.blog.post.index');
        }

        $images = [];
        $dom  = new \DOMDocument();
        $dom->loadHTML($post->content_html);
        $dom->preserveWhiteSpace = false;

        foreach ($dom->getElementsByTagName('img') as $id => $image) {
            $src = $image->getAttribute('src');

            if(!\file_exists(public_path() . $src)) {
                break;
            }

            $dimensions = \getimagesize(public_path() . $src);

            $images[$id] = [
                'src' => $src,
                'alt' => $image->getAttribute('alt'),
                'width' => $dimensions[0],
                'height' => $dimensions[1],
            ];
        }

        $content_html = $post->content_html;

        // Remove images for gallery posts
        if ($post->tags()->whereIn('tag', ['gallery'])->exists()) {
            $imgRegex = '/<img[^>]*src="([^"]*)[^>]*>/i';
            $content_html = preg_replace($imgRegex, '', $content_html);
        }

        // Remove emtpy paragraph tags
        $emptyParagraphsRegex = "/<p[^>]*><\\/p[^>]*>/";
        $content_html = preg_replace($emptyParagraphsRegex, '', $content_html);
        $post->content_html = $content_html;

        // Specific layouts
        if ($post->tags()->where('tag', 'weddings')->exists()) {
            $layout = 'canvas::frontend.blog.wedding';
        }else if ($post->tags()->where('tag', 'photoshoots')->exists()) {
            $layout = 'canvas::frontend.blog.photoshoot';
        } else {
            $layout = $post->layout;
        }
        return view($layout, compact('post', 'tag', 'slug', 'title', 'user', 'css', 'js', 'socialHeaderIconsUser', 'images'));
    }
}
