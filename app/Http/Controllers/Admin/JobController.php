<?php

namespace Treiner\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Treiner\Http\Controllers\Controller;
use Treiner\JobPost;

class JobController extends Controller
{
    public function index() {
        return view('admin.jobs.index', ['jobs' => JobPost::paginate(25)]);
    }

    public function show(JobPost $jobPost)
    {
        return view('admin.jobs.show', ['job' => $jobPost]);
    }
}
