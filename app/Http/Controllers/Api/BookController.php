<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct(private BookService $bookService) {}

    /**
     * @OA\Get(
     *     path="/api/books",
     *     summary="Get list of books with pagination & filters",
     *     tags={"Books"},
     *     security={{"sanctum": {}}},
     *
     *     @OA\Parameter(name="q", in="query", description="Search keyword", @OA\Schema(type="string")),
     *     @OA\Parameter(name="author", in="query", description="Filter by author", @OA\Schema(type="string")),
     *     @OA\Parameter(name="year", in="query", description="Filter by published year", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="per_page", in="query", description="Items per page", @OA\Schema(type="integer", example=10)),
     *
     *     @OA\Response(response=200, description="List of books")
     * )
     */
    public function index(Request $request)
    {
        $filters = $request->only(['q', 'author', 'year']);
        $perPage = (int) $request->query('per_page', 10);

        $books = $this->bookService->paginate($filters, $perPage);

        return ApiResponse::paginated(BookResource::collection($books), 'Book list');
    }

    /**
     * @OA\Get(
     *     path="/api/books/{id}",
     *     summary="Get details of a book",
     *     tags={"Books"},
     *     security={{"sanctum": {}}},
     *
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *
     *     @OA\Response(response=200, description="Book detail"),
     *     @OA\Response(response=404, description="Book not found")
     * )
     */
    public function show(int $id)
    {
        $book = $this->bookService->findOrFail($id);

        return ApiResponse::success(new BookResource($book), 'Book detail');
    }

    /**
     * @OA\Post(
     *     path="/api/books",
     *     summary="Create a new book",
     *     tags={"Books"},
     *     security={{"sanctum": {}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"title","author","published_year","isbn","stock"},
     *
     *             @OA\Property(property="title", type="string", example="Clean Code"),
     *             @OA\Property(property="author", type="string", example="Robert C. Martin"),
     *             @OA\Property(property="published_year", type="integer", example=2008),
     *             @OA\Property(property="isbn", type="string", example="978-0132350884"),
     *             @OA\Property(property="stock", type="integer", example=10)
     *         )
     *     ),
     *
     *     @OA\Response(response=201, description="Book created successfully"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(StoreBookRequest $request)
    {
        $book = $this->bookService->create($request->validated());

        return ApiResponse::success(new BookResource($book), 'Book created', 201);
    }

    /**
     * @OA\Put(
     *     path="/api/books/{id}",
     *     summary="Update an existing book",
     *     tags={"Books"},
     *     security={{"sanctum": {}}},
     *
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="title", type="string", example="Updated Title"),
     *             @OA\Property(property="author", type="string", example="Updated Author"),
     *             @OA\Property(property="published_year", type="integer", example=2010),
     *             @OA\Property(property="isbn", type="string", example="978-0132350884"),
     *             @OA\Property(property="stock", type="integer", example=5)
     *         )
     *     ),
     *
     *     @OA\Response(response=200, description="Book updated"),
     *     @OA\Response(response=404, description="Book not found")
     * )
     */
    public function update(UpdateBookRequest $request, int $id)
    {
        $book = $this->bookService->update($id, $request->validated());

        return ApiResponse::success(new BookResource($book), 'Book updated');
    }

    /**
     * @OA\Delete(
     *     path="/api/books/{id}",
     *     summary="Delete a book",
     *     tags={"Books"},
     *     security={{"sanctum": {}}},
     *
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *
     *     @OA\Response(response=204, description="Book deleted"),
     *     @OA\Response(response=404, description="Book not found")
     * )
     */
    public function destroy(int $id)
    {
        $this->bookService->delete($id);

        return ApiResponse::success(null, 'Book deleted', 204);
    }
}
