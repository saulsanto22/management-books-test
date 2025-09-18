<?php

namespace Tests\Feature;

use App\Mail\BookBorrowedMail;
use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class LoanTest extends TestCase
{
    // use RefreshDatabase;

    public function test_user_can_borrow_book()
    {
        Mail::fake();
        $user = User::factory()->create();
        $book = Book::factory()->create(['stock' => 3]);

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/loans', ['book_id' => $book->id])
            ->assertStatus(201)
            ->assertJsonFragment(['message' => 'Book borrowed']);

        $this->assertDatabaseHas('book_loans', [
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'stock' => 2,
        ]);

        Mail::assertSent(BookBorrowedMail::class);
    }

    public function test_user_cannot_borrow_out_of_stock()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['stock' => 0]);

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/loans', ['book_id' => $book->id])
            ->assertStatus(400)
            ->assertJsonFragment(['message' => 'Book out of stock']);

        $this->assertDatabaseMissing('book_loans', [
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);
    }

    public function test_user_can_list_their_loans(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test_token')->plainTextToken;

        $book1 = Book::factory()->create(['stock' => 5]);
        $book2 = Book::factory()->create(['stock' => 5]);

        // Buat 2 pinjaman lewat pivot
        $user->loans()->attach($book1->id, ['borrowed_at' => now()]);
        $user->loans()->attach($book2->id, ['borrowed_at' => now()]);

        $response = $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson('/api/loans');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [[
                    'id',
                    'title',
                    'author',
                    'stock',
                    'published_year',
                    'isbn',
                    // optional: pivot fields
                ]],
            ]);

        $this->assertCount(2, $response->json('data'));
    }
}
