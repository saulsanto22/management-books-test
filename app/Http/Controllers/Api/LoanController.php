<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLoanRequest;
use App\Http\Resources\BookResource;
use App\Services\LoanService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LoanController extends Controller
{
    public function __construct(private LoanService $loanService) {}

    /**
     * @OA\Post(
     *     path="/api/loans",
     *     summary="Borrow a book",
     *     tags={"Loans"},
     *     security={{"sanctum": {}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"book_id"},
     *
     *             @OA\Property(property="book_id", type="integer", example=1)
     *         )
     *     ),
     *
     *     @OA\Response(response=201, description="Book borrowed successfully"),
     *     @OA\Response(response=422, description="Book out of stock")
     * )
     */
    public function store(StoreLoanRequest $request)
    {
        try {
            $book = $this->loanService->borrow($request->user(), $request->book_id);

            return ApiResponse::success(new BookResource($book), 'Book borrowed', 201);
        } catch (HttpException $e) {
            return ApiResponse::error($e->getMessage(), $e->getStatusCode());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/loans",
     *     summary="Get loans of the authenticated user",
     *     tags={"Loans"},
     *     security={{"sanctum": {}}},
     *
     *     @OA\Response(response=200, description="List of loans")
     * )
     */
    public function index(Request $request)
    {
        $loans = $this->loanService->getUserLoans($request->user()->id);

        return ApiResponse::success(BookResource::collection($loans), 'User loans');
    }
}
