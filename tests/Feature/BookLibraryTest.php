<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookLibraryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library(){

        $response = $this->post('/books',[
            'title' => 'Cool Book Title',
            'author' => 'Charles Dickson',
        ]);

        $book = Book::first();

        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
    }

    /** @test */
    public function a_title_is_required(){

        $response = $this->post('/books',[
            'title' => '',
            'author' => 'Charles Dickson',
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function an_author_is_required(){

        $response = $this->post('/books',[
            'title' => 'Book title',
            'author' => '',
        ]);

        $response->assertSessionHasErrors('author');
    }

    /** @test */
    public function a_book_can_be_updated(){

        $this->post('/books',[
            'title' => 'Cool title',
            'author' => 'Victor',
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, [
            'title' => 'New Title',
            'author' => 'New Author',
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);

        $response->assertRedirect($book->fresh()->path());
    }

    /** @test  */
    public function a_book_can_be_deleted(){

        $this->post('/books',[
            'title' => 'Cool title',
            'author' => 'Victor',
        ]);

        $book = Book::first();

        $this->assertCount(1, Book::all());

        $response = $this->delete('/books/' . $book->id);

        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }
}
