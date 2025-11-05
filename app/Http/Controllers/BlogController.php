<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        // For now return a simple view. You can later populate with posts from a model.
        return view('blog.index');
    }
}
