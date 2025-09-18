<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    // use RefreshDatabase;

    /**
     * Test authenticated user can create a book
     */
    public function test_authenticated_user_can_create_book(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/books', [
            'title' => 'New Book',
            'author' => 'John Doe',
            'stock' => 10,
            'published_year' => 2024,
            'isbn' => '1234567890',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.title', 'New Book')
            ->assertJsonPath('data.author', 'John Doe');
    }

    /**
     * Test cannot create book with invalid data
     */
    public function test_cannot_create_book_with_invalid_data(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/books', [
            'title' => '', // invalid
            'stock' => -5, // invalid
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'stock', 'author', 'published_year', 'isbn']);
    }

    /**
     * Test can list books with pagination
     */
    public function test_can_list_books_with_pagination(): void
    {
        $user = User::factory()->create();

        Book::factory()->count(15)->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/books');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data',
            ]);

    }
}
