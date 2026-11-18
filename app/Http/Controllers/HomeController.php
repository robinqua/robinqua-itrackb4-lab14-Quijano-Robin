<?php

namespace App\Http\Controllers;

use App\Models\Book;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'bookCount' => Book::count(),
            'genreCount' => Book::query()
                ->whereNotNull('genre')
                ->distinct()
                ->count('genre'),
        ]);
    }
}
