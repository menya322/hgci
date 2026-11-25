<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewsController extends Controller
{
    public function index(): View
    {
        $posts = Post::query()
            ->published()
            ->latest('published_at')
            ->paginate(9);

        return view('news.index', [
            'posts' => $posts,
        ]);
    }

    public function show(Post $post): View
    {
        if (! $post->published_at || $post->published_at->isFuture()) {
            throw new NotFoundHttpException;
        }

        $related = Post::query()
            ->published()
            ->whereKeyNot($post->getKey())
            ->where('category', $post->category)
            ->latest('published_at')
            ->limit(3)
            ->get();

        if ($related->count() < 3) {
            $fallback = Post::query()
                ->published()
                ->whereKeyNot($post->getKey());

            if ($related->isNotEmpty()) {
                $fallback->whereNotIn('id', $related->modelKeys());
            }

            $related = $related->merge(
                $fallback->latest('published_at')
                    ->limit(3 - $related->count())
                    ->get(),
            );
        }

        return view('news.show', [
            'post' => $post,
            'related' => $related,
        ]);
    }
}
