<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostRequest;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(): View
    {
        return view('admin.posts.index', [
            'posts' => Post::query()->with('author')->latest('id')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.posts.create', [
            'post' => new Post,
        ]);
    }

    public function store(PostRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['author_id'] = $request->user()->id;
        $data['is_featured'] = $request->boolean('is_featured');
        $data['featured_image'] = $this->storeImage($request);

        $post = Post::create($data);

        return redirect()
            ->route('admin.posts.edit', $post)
            ->with('status', 'Post created.');
    }

    public function edit(Post $post): View
    {
        return view('admin.posts.edit', [
            'post' => $post,
        ]);
    }

    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        $data = $request->validated();
        $data['is_featured'] = $request->boolean('is_featured');
        $data['featured_image'] = $this->storeImage($request, $post->featured_image);

        $post->update($data);

        return redirect()
            ->route('admin.posts.edit', $post)
            ->with('status', 'Post updated.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('status', 'Post moved to the trash.');
    }

    private function storeImage(PostRequest $request, ?string $existing = null): ?string
    {
        if (! $request->hasFile('featured_image')) {
            return $existing;
        }

        $path = $request->file('featured_image')->store('posts', 'public');

        if ($existing) {
            Storage::disk('public')->delete($existing);
        }

        return $path;
    }
}
