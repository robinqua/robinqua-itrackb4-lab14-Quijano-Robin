<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'isbn' => '9789712736000',
                'title' => 'Noli Me Tangere',
                'author' => 'Jose Rizal',
                'pages' => 400,
                'genre' => 'Filipino Literature',
            ],
            [
                'isbn' => '9789712736017',
                'title' => 'El Filibusterismo',
                'author' => 'Jose Rizal',
                'pages' => 350,
                'genre' => 'Filipino Literature',
            ],
            [
                'isbn' => '9789715080416',
                'title' => 'Florante at Laura',
                'author' => 'Francisco Balagtas',
                'pages' => 120,
                'genre' => 'Filipino Literature',
            ],
            [
                'isbn' => '9780156012195',
                'title' => 'The Little Prince',
                'author' => 'Antoine de Saint-Exupery',
                'pages' => 96,
                'genre' => "Children's Fiction",
            ],
            [
                'isbn' => '9789715081468',
                'title' => 'Ibong Adarna',
                'author' => 'Jose de la Cruz',
                'pages' => 150,
                'genre' => 'Filipino Literature',
            ],
            [
                'isbn' => '9780135957059',
                'title' => 'The Pragmatic Programmer',
                'author' => 'Andrew Hunt',
                'pages' => 352,
                'genre' => 'Software Engineering',
            ],
            [
                'isbn' => '9780201835953',
                'title' => 'The Mythical Man-Month',
                'author' => 'Frederick P. Brooks Jr.',
                'pages' => 336,
                'genre' => 'Software Engineering',
            ],
            [
                'isbn' => '9780262046305',
                'title' => 'Introduction to Algorithms',
                'author' => 'Thomas H. Cormen',
                'pages' => 1312,
                'genre' => 'Computer Science',
            ],
            [
                'isbn' => '9780465050659',
                'title' => 'The Design of Everyday Things',
                'author' => 'Don Norman',
                'pages' => 368,
                'genre' => 'Design',
            ],
            [
                'isbn' => '9780374533557',
                'title' => 'Thinking, Fast and Slow',
                'author' => 'Daniel Kahneman',
                'pages' => 512,
                'genre' => 'Psychology',
            ],
            [
                'isbn' => '9780201896831',
                'title' => 'The Art of Computer Programming',
                'author' => 'Donald Knuth',
                'pages' => 672,
                'genre' => 'Computer Science',
            ],
            [
                'isbn' => '9780198788607',
                'title' => 'The Selfish Gene',
                'author' => 'Richard Dawkins',
                'pages' => 544,
                'genre' => 'Biology',
            ],
            [
                'isbn' => '9780553380163',
                'title' => 'A Brief History of Time',
                'author' => 'Stephen Hawking',
                'pages' => 256,
                'genre' => 'Science',
            ],
            [
                'isbn' => '9780547928227',
                'title' => 'The Hobbit',
                'author' => 'J. R. R. Tolkien',
                'pages' => 320,
                'genre' => 'Fantasy',
            ],
            [
                'isbn' => '9780441172719',
                'title' => 'Dune',
                'author' => 'Frank Herbert',
                'pages' => 896,
                'genre' => 'Science Fiction',
            ],
            [
                'isbn' => '9780441478125',
                'title' => 'The Left Hand of Darkness',
                'author' => 'Ursula K. Le Guin',
                'pages' => 304,
                'genre' => 'Science Fiction',
            ],
            [
                'isbn' => '9780553418026',
                'title' => 'The Martian',
                'author' => 'Andy Weir',
                'pages' => 384,
                'genre' => 'Science Fiction',
            ],
            [
                'isbn' => '9780141439518',
                'title' => 'Pride and Prejudice',
                'author' => 'Jane Austen',
                'pages' => 480,
                'genre' => 'Romance',
            ],
            [
                'isbn' => '9780743273565',
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'pages' => 180,
                'genre' => 'Classic Fiction',
            ],
            [
                'isbn' => '9780061120084',
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'pages' => 336,
                'genre' => 'Classic Fiction',
            ],
        ];

        foreach ($books as $book) {
            Book::updateOrCreate(['isbn' => $book['isbn']], $book);
        }
    }
}