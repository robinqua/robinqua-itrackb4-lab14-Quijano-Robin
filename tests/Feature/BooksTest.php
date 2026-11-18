<?php

namespace Tests\Feature;

use App\Models\Book;
use Database\Seeders\BookSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BooksTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(BookSeeder::class);
    }

    public function test_home_page_explains_the_app_and_links_to_the_book_collection(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('A place to discover your next favorite book')
            ->assertSee('Explore the collection')
            ->assertSee('Books in the collection:')
            ->assertSee('Genres represented by books:')
            ->assertSee('20')
            ->assertSee('12')
            ->assertSee('img/robin-quijano.jpg')
            ->assertSee('Quijano Library')
            ->assertSee('>Home</a>', false)
            ->assertDontSee('My Awesome Site')
            ->assertSee(route('books.index'));
    }

    public function test_book_list_displays_the_collection_count(): void
    {
        $this->get(route('books.index'))
            ->assertOk()
            ->assertSee('Books in collection:')
            ->assertSee('20')
            ->assertSee('Noli Me Tangere');
    }

    public function test_seeder_can_run_again_without_creating_duplicate_books(): void
    {
        $this->seed(BookSeeder::class);

        $this->assertDatabaseCount('books', 20);
        $this->assertSame(12, Book::query()->distinct()->count('genre'));
    }

    public function test_search_and_filters_can_be_applied_together(): void
    {
        $this->get(route('books.index', [
            'search' => 'Martian',
            'author' => 'Andy Weir',
            'pages' => 384,
        ]))
            ->assertOk()
            ->assertSee('The Martian')
            ->assertDontSee('Dune');
    }

    public function test_unknown_sort_values_fall_back_to_a_working_order(): void
    {
        $this->get(route('books.index', ['sort' => 'not-a-column']))
            ->assertOk()
            ->assertSee('Noli Me Tangere')
            ->assertSee('page=2');
    }

    public function test_search_pagination_preserves_the_search_term(): void
    {
        $this->get(route('books.index', ['search' => 'The']))
            ->assertOk()
            ->assertSee('search=The')
            ->assertSee('page=2');
    }

    public function test_a_book_can_be_added_and_the_collection_count_increases(): void
    {
        $this->post(route('books.store'), [
            'isbn' => '978-1-23456-789-0',
            'title' => 'A Newly Added Book',
            'genre' => 'Biography',
            'author' => 'A New Author',
            'pages' => 123,
        ])
            ->assertRedirect(route('books.index'))
            ->assertSessionHas('success', 'Book added successfully.');

        $this->assertDatabaseCount('books', 21);
        $this->assertDatabaseHas('books', ['title' => 'A Newly Added Book']);

        $this->get(route('books.index'))
            ->assertOk()
            ->assertSee('Books in collection:')
            ->assertSee('21');

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Books in the collection:')
            ->assertSee('21')
            ->assertSee('Genres represented by books:')
            ->assertSee('13');
    }

    public function test_invalid_book_is_not_saved(): void
    {
        $this->from(route('books.create'))
            ->post(route('books.store'), [])
            ->assertRedirect(route('books.create'))
            ->assertSessionHasErrors(['isbn', 'title', 'genre', 'author', 'pages']);

        $this->assertDatabaseCount('books', 20);
    }

    public function test_book_detail_keeps_the_all_books_navigation_link_current(): void
    {
        $book = Book::query()->firstOrFail();

        $this->get(route('books.show', $book))
            ->assertOk()
            ->assertSee($book->title)
            ->assertSee('aria-current="page"', false)
            ->assertSee('class="nav-link active" aria-current="page">', false);
    }

    public function test_deleting_a_last_book_by_an_author_is_forbidden(): void
    {
        $book = Book::query()->where('author', 'Andy Weir')->firstOrFail();

        $this->delete(route('books.destroy', $book))
            ->assertForbidden();

        $this->assertDatabaseHas('books', ['id' => $book->id]);
    }
}
