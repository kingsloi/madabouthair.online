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
     * Post images
     * @var array
     */
    private $images = [];

    /**
     * Image template for outputting gallery images
     * @param  array $image Array of image src, dimensions, and alt text
     * @return string
     */
    private function imageTemplate($image)
    {
        return '<div class="c-gallery-item">' .
                    '<a href="'. $image['src'] .'" itemprop="contentUrl" data-size="'. $image['width'] .'x'. $image['height'] .'" class="c-gallery-item__inner js-gallery__link">' .
                        '<figure class="o-image">' .
                            '<img class="o-image__media" src="'. $image['src'] .'" alt="'. $image['alt'] .'" />' .
                        '</figure>' .
                    '</a>' .
                '</div>';
    }

    /**
     * Build 'item' templates e.g. DIY post
     * @param  string $content
     * @return string
     */
    private function buildListTemplate($content)
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $listItems = $dom->getElementsByTagName('li');

        foreach ($listItems as $id => $list) {
            $image = $list->getElementsByTagName('img');
            if ($image->length) {
                $list->setAttribute('class', 'item--has-image');
            }
        }

        return $dom->saveHTML();
    }

    /**
     * Wrap images with extra markup for JS gallery
     * @param  string $content
     * @return string
     */
    private function wrapImages($content)
    {
        $dom  = new \DOMDocument();
        @$dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $id => $image) {
            $node = $dom->createElement("div");
            $node->setAttribute('class', 'c-gallery-list__item js-gallery__item');
            $frag = $dom->createDocumentFragment();
            $frag->appendXML($this->imageTemplate($this->images[$id]));
            $node->appendChild($frag);
            $image->parentNode->replaceChild($node, $image);
        }

        return $dom->saveHTML();
    }

    /**
     * Remove <img> from content
     * @param  string $content
     * @return string
     */
    private function removeImagesFromPost($content)
    {
        $imgRegex = '/<img[^>]*src="([^"]*)[^>]*>/i';
        return preg_replace($imgRegex, '', $content);
    }

    /**
     * Remove bad/empty html tags from content
     * @param  string $content
     * @return string
     */
    private function removeBadHtmlFromPost($content)
    {
        $emptyParagraphsRegex = '/<(\w+)\b(?:\s+[\w\-.:]+(?:\s*=\s*(?:"[^"]*"|"[^"]*"|[\w\-.:]+))?)*\s*\/?>\s*<\/\1\s*>/';
        return preg_replace($emptyParagraphsRegex, '', $content);
    }

    /**
     * Build array of images, check if exists, extract resolution
     * @param  string $content
     * @return string
     */
    private function buildImages($content)
    {
        $images = [];
        $dom  = new \DOMDocument();
        $dom->loadHTML($content);
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

        return $images;
    }

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
        $images = [];

        if ($tag) {
            $tag = Tag::whereTag($tag)->firstOrFail();
        }

        if (! $post->is_published && ! Auth::check()) {
            return redirect()->route('canvas.blog.post.index');
        }

        // Build array of images
        $contentHtml = $post->content_html;
        $images = $this->images = $this->buildImages($contentHtml);

        // Remove images for gallery posts
        if ($post->tags()->whereIn('tag', ['gallery'])->exists()) {
            $contentHtml = $this->removeImagesFromPost($contentHtml);
        } else {
            $contentHtml = $this->wrapImages($contentHtml);
        }

        // Remove emtpy paragraph tags
        $contentHtml = $this->removeBadHtmlFromPost($contentHtml);

        // Tag specific
        if ($post->tags()->where('tag', 'weddings')->exists()) {
            $layout = 'canvas::frontend.blog.wedding';
        } else if ($post->tags()->where('tag', 'photoshoots')->exists()) {
            $layout = 'canvas::frontend.blog.photoshoot';
        } else if ($post->tags()->where('tag', 'diy')->exists()) {
            $contentHtml = $this->buildListTemplate($contentHtml);
            $layout = 'canvas::frontend.blog.diy';
        } else {
            $layout = $post->layout;
        }

        // Re-assign content
        $post->content_html = $contentHtml;

        return view($layout, compact('post', 'tag', 'slug', 'title', 'user', 'css', 'js', 'socialHeaderIconsUser', 'images'));
    }
}
