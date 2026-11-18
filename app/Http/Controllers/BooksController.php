<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class BooksController extends Controller
{
    public function index(Request $request)
    {
        $allBooks = Book::query();
        $searchInput = $request->query('search');
        $search = is_string($searchInput) ? trim($searchInput) : '';
        $pagesInput = $request->query('pages');
        $pages = is_scalar($pagesInput) ? (string) $pagesInput : null;
        $authorInput = $request->query('author');
        $author = is_string($authorInput) ? $authorInput : null;
        $genreInput = $request->query('genre');
        $genre = is_string($genreInput) ? $genreInput : null;
        $sortOptions = [
            'id' => 'ID',
            'title' => 'Title',
            'author' => 'Author',
            'pages' => 'Pages',
            'genre' => 'Genre',
        ];
        $sortInput = $request->query('sort', 'id');
        $sort = is_string($sortInput) ? $sortInput : 'id';
        $directionInput = $request->query('direction', 'asc');
        $direction = is_string($directionInput) ? strtolower($directionInput) : 'asc';

        if (!array_key_exists($sort, $sortOptions)) {
            $sort = 'id';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'asc';
        }

        $books = (clone $allBooks)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%")
                        ->orWhere('genre', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%");
                });
            })
            ->when($pages !== null && $pages !== '', fn ($query) => $query->where('pages', $pages))
            ->when($author !== null && $author !== '', fn ($query) => $query->where('author', $author))
            ->when($genre !== null && $genre !== '', fn ($query) => $query->where('genre', $genre))
            ->orderBy($sort, $direction)
            ->when($sort !== 'id', fn ($query) => $query->orderBy('id'))
            ->paginate(5);

        return view('books.index', [
            'books' => $books,
            'search' => $search,
            'pages' => $pages,
            'author' => $author,
            'genre' => $genre,
            'sort' => $sort,
            'direction' => $direction,
            'sortOptions' => $sortOptions,
            'pageOptions' => (clone $allBooks)->select('pages')->distinct()->orderBy('pages')->pluck('pages'),
            'authorOptions' => (clone $allBooks)->select('author')->distinct()->orderBy('author')->pluck('author'),
            'genreOptions' => (clone $allBooks)->whereNotNull('genre')->select('genre')->distinct()->orderBy('genre')->pluck('genre'),
            'bookCount' => (clone $allBooks)->count(),
        ]);
    }

    public function create()
    {
        return view('books.create', [
            'authors' => Book::query()->select('author')->distinct()->orderBy('author')->pluck('author'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'isbn' => ['required', 'string', 'max:32', Rule::unique('books', 'isbn')],
            'title' => ['required', 'string', 'max:255'],
            'genre' => ['required', 'string', 'max:100'],
            'author' => ['required', 'string', 'max:255'],
            'pages' => ['required', 'integer', 'min:1'],
        ]);

        $book = Book::create($validated);
        Log::info('Book saved', ['id' => $book->id]);

        return redirect()->route('books.index')->with('success', 'Book added successfully.');
    }

    public function show(Book $book)
    {
        return view('books.show', ['book' => $book]);
    }

    public function edit(Book $book)
    {
        return view('books.edit', [
            'book' => $book,
            'authors' => Book::query()->select('author')->distinct()->orderBy('author')->pluck('author'),
        ]);
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'isbn' => ['required', 'string', 'max:32', Rule::unique('books', 'isbn')->ignore($book->id)],
            'title' => ['required', 'string', 'max:255'],
            'genre' => ['required', 'string', 'max:100'],
            'author' => ['required', 'string', 'max:255'],
            'pages' => ['required', 'integer', 'min:1'],
        ]);

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        abort_if(Book::query()->where('author', $book->author)->count() === 1, 403);

        $book->delete();

        return redirect()->route('books.index');
    }

    public function featured()
    {
        return view('books.featured', [
            'featured' => Book::query()->findOrFail(1),
        ]);
    }
}
