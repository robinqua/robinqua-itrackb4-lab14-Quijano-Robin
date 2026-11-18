@extends('layouts.app')

@section('title', 'My Book List')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="mb-1">My Book List</h1>
            <p class="mb-0"><strong>Books in collection:</strong> <span data-testid="book-count">{{ $bookCount }}</span></p>
        </div>
        @auth
            <a href="{{ route('books.create') }}" class="btn btn-primary">+ Add Book</a>
        @endauth
    </div>

    <form method="GET" action="{{ route('books.index') }}" class="row g-2 align-items-end mb-4">
        <div class="col-md-4">
            <label for="search" class="form-label">Search books</label>
            <input id="search" name="search" type="search" value="{{ $search }}" class="form-control"
                   placeholder="Title, author, or ISBN">
        </div>
        <div class="col-md-2">
            <label for="author" class="form-label">Author</label>
            <select id="author" name="author" class="form-select">
                <option value="">All authors</option>
                @foreach ($authorOptions as $authorOption)
                    <option value="{{ $authorOption }}" @selected((string) $author === (string) $authorOption)>
                        {{ $authorOption }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label for="pages" class="form-label">Pages</label>
            <select id="pages" name="pages" class="form-select">
                <option value="">Any length</option>
                @foreach ($pageOptions as $pageOption)
                    <option value="{{ $pageOption }}" @selected((string) $pages === (string) $pageOption)>
                        {{ $pageOption }} pages
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label for="genre" class="form-label">Genre</label>
            <select id="genre" name="genre" class="form-select">
                <option value="">All genres</option>
                @foreach ($genreOptions as $genreOption)
                    <option value="{{ $genreOption }}" @selected($genre === $genreOption)>{{ $genreOption }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label for="sort" class="form-label">Sort by</label>
            <select id="sort" name="sort" class="form-select">
                @foreach ($sortOptions as $sortKey => $sortLabel)
                    <option value="{{ $sortKey }}" @selected($sort === $sortKey)>{{ $sortLabel }}</option>
                @endforeach
            </select>
        </div>
        <input type="hidden" name="direction" value="{{ $direction }}">
        <div class="col-md-1 d-grid">
            <button type="submit" class="btn btn-primary">Go</button>
        </div>
        <div class="col-12">
            <a href="{{ route('books.index') }}" class="btn btn-link px-0">Clear search and filters</a>
        </div>
    </form>

    <p class="text-muted">
        Showing {{ $books->firstItem() ?? 0 }}–{{ $books->lastItem() ?? 0 }}
        of {{ $books->total() }} matching books.
    </p>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">ISBN</th>
                    <th scope="col">Title</th>
                    <th scope="col">Author</th>
                    <th scope="col">Genre</th>
                    <th scope="col">Pages</th>
                    @auth
                        <th scope="col">Actions</th>
                    @endauth
                </tr>
            </thead>
            <tbody>
                @forelse ($books as $book)
                    <tr>
                        <td>{{ $books->firstItem() + $loop->index }}</td>
                        <td>{{ $book->id }}</td>
                        <td><a href="{{ route('books.show', $book) }}">{{ $book->isbn }}</a></td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->genre ?? 'Uncategorized' }}</td>
                        <td>
                            @if ($book->pages >= 300)
                                <strong>{{ $book->pages }} (Long Read)</strong>
                            @else
                                {{ $book->pages }}
                            @endif
                        </td>
                        @auth
                            <td>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('books.edit', $book) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('books.destroy', $book) }}" method="POST"
                                          onsubmit="return confirm('Delete this record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        @endauth
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ Auth::check() ? 8 : 7 }}">No books match this search and these filters.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $books->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
@endsection
