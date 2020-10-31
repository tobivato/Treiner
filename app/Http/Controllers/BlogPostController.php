<?php

declare(strict_types=1);

namespace Treiner\Http\Controllers;

use Arr;
use Cloudder;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Log;
use Treiner\BlogPost;
use Treiner\Image;

class BlogPostController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Blog Post Controller
    |--------------------------------------------------------------------------
    |
    | This controller is meant for adding new posts to the blog system, displaying them all,
    | showing the form to create them, editing them and deleting them.
    |
    */

    public function __construct()
    {
        $this->authorizeResource(BlogPost::class, 'blog');
    }

    /**
     * Display all blog posts.
     */
    public function index(): \Illuminate\View\View
    {
        $blogs = BlogPost::orderByDesc('created_at')->paginate(9);

        return view('blogs.index', ['blogs' => $blogs]);
    }

    /**
     * Displays all blog posts
     * that belong to the user.
     */
    public function dashboard()
    {
        return view('dashboard.coach.blogs', ['blogs' => Auth::user()->blogposts]);
    }

    /**
     * Store a newly created post in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:110|string|unique:blog_posts,title',
            'excerpt' => 'required|max:255|string|min:20',
            'content' => 'required|max:65535|string',
            'image' => 'required|file|image|max:10000',
        ]);
                
        $blog = BlogPost::create([
            'title' => $request->input('title'),
            'excerpt' => $request->input('excerpt'),
            'content' => $request->input('content'),
            'image_id' => Cloudder::upload($request->file('image'))->getPublicId(),
            'coach_id' => Auth::user()->isAdmin() ? null : Auth::user()->coach->id,
        ]);

        return redirect(route('blogs.show', $blog->id));
    }

    /**
     * Display the specified post.
     */
    public function show(BlogPost $blog, string $slug = null)
    {
        if ($slug != $blog->slug) {
            return redirect()
                ->route('blogs.show', ['blog' => $blog, 'slug' => $blog->slug]);
        }

        return view('blogs.show', [
            'blog' => $blog,
            'link' => route('blogs.show', $blog->id),
            'source' => 'LinkedIn',
            'title' => $blog->excerpt,
        ]);
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(BlogPost $blog): \Illuminate\View\View
    {
        return view('blogs.edit', ['blog' => $blog]);
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, BlogPost $blog)
    {
        $request->validate([
            'title' => 'nullable|max:110|string',
            'excerpt' => 'nullable|max:255|string|min:20',
            'content' => 'nullable|max:65535|string',
            'image' => 'nullable|file|image|max:10000',
        ]);

        $blog->update([
            'title' => $request->input('title'),
            'excerpt' => $request->input('excerpt'),
            'content' => $request->input('content'),
        ]);

        if ($request->hasFile('image')) {
            $blog->image_id = Cloudder::upload($request->file('image'))->getPublicId();
            $blog->save();
        }

        return redirect(route('blogs.show', $blog->id))->with('message', 'Blog successfully updated.');
    }

    /**
     * Delete the specified post from storage.
     */
    public function destroy(BlogPost $blog)
    {
        $blog->delete();
        return redirect(route('blogs.index'));
    }
}
