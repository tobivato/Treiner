<?php

namespace Treiner\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Treiner\Http\Controllers\Controller;

class BlogPostController extends Controller
{
    public function create() {
        return view('admin.blogs.create');
    }
}
