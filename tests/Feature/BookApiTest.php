<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_books(): void
    {
        Book::create([
            'title' => 'Buku Pertama',
            'description' => 'Deskripsi pertama',
            'status' => 1,
        ]);

        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
                 ->assertJsonCount(1);
    }

    public function test_can_create_book_with_validation(): void
    {
        $payload = [
            'title' => 'Pemrograman Web Laravel',
            'description' => 'Panduan dasar membangun aplikasi web dengan Laravel',
            'status' => 1,
        ];

        $response = $this->postJson('/api/books', $payload);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'title' => 'Pemrograman Web Laravel',
                     'status' => true,
                 ]);

        $this->assertDatabaseHas('books', [
            'title' => 'Pemrograman Web Laravel',
        ]);
    }

    public function test_create_book_validation_fails_without_title(): void
    {
        $payload = [
            'description' => 'Tanpa judul',
            'status' => 1,
        ];

        $response = $this->postJson('/api/books', $payload);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['title']);
    }

    public function test_can_show_single_book(): void
    {
        $book = Book::create([
            'title' => 'Buku Detail',
            'description' => 'Deskripsi',
            'status' => 1,
        ]);

        $response = $this->getJson('/api/books/' . $book->id);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'id' => $book->id,
                     'title' => 'Buku Detail',
                 ]);
    }

    public function test_can_update_book(): void
    {
        $book = Book::create([
            'title' => 'Buku Update',
            'description' => 'Deskripsi awal',
            'status' => 1,
        ]);

        $response = $this->putJson('/api/books/' . $book->id, [
            'status' => 0,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'status' => false,
                 ]);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'status' => 0,
        ]);
    }

    public function test_can_delete_book(): void
    {
        $book = Book::create([
            'title' => 'Buku Hapus',
            'description' => 'Deskripsi',
            'status' => 1,
        ]);

        $response = $this->deleteJson('/api/books/' . $book->id);

        $response->assertStatus(200)
                 ->assertExactJson([
                     'message' => 'Book deleted',
                 ]);

        $this->assertDatabaseMissing('books', [
            'id' => $book->id,
        ]);
    }
}
