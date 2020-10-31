<?php

namespace Treiner\Http\Controllers;

use Treiner\Comment;
use Illuminate\Http\Request;
use Treiner\Coach;
use Treiner\JobPost;
use Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Comment::class, 'comment');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'commentable_type' => 'required|in:Treiner\Coach,Treiner\JobPost',
            'commentable_id' => 'required|integer',
            'content' => 'required|string|max:5000',
        ]);

        if ($request->input('commentable_type' == 'Treiner\Coach')) {
            Coach::findOrFail($request->input('commentable_id'));
        }
        else {
            JobPost::findOrFail($request->input('commentable_id'));
        }

        Comment::create([
            'user_id' => Auth::user()->id,
            'commentable_type' => $request->input('commentable_type'),
            'commentable_id' => $request->input('commentable_id'),
            'content' => $request->input('content'),
        ]);

        return redirect()->back();
    }

    public function edit(Comment $comment)
    {
        return view('comments.edit', ['comment' => $comment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Treiner\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        $comment->update([
            'content' => $request->input('content'),
        ]);

        return redirect(route('home'))->with('message', 'Comment successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Treiner\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->back();
    }
}
