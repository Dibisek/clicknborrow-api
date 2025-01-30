<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreBookRequest;
use App\Http\Requests\V1\UpdateBookRequest;
use App\Models\Book;
use App\Http\Resources\V1\BookResource;
use App\Http\Resources\V1\BookCollection;
use Illuminate\Http\Request;
use App\Filters\V1\BookFilter;
use Illuminate\Support\Facades\Gate;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Book::class);

        $filter = new BookFilter();
        $filterItems = $filter->transform($request); // [['column', 'operator', 'value']])
        
        $includeReservations = $request->query('includeReservations');

        $book = Book::where($filterItems);

        if ($includeReservations) {
            $book = $book->with('reservations');
        }

        return new BookCollection($book->paginate()->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        Gate::authorize('create', Book::class);
        

        $book = Book::create($request->except('category_ids'));
        $book->categories()->attach($request->category_ids);
        
        return new BookResource($book);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        Gate::authorize('view', $book);

        $includeReservations = request()->query('includeReservations');

        if ($includeReservations) {
            return new BookResource($book->loadMissing('reservations'));
        }

        return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        Gate::authorize('update', $book);

        $book->update($request->except('category_ids'));
        if ($request->category_ids) {
        $book->categories()->sync($request->category_ids);
        }

        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        Gate::authorize('delete', $book);
        
        $book->categories()->detach();
        if ($book->reservations()->count() > 0 || $book->reservations()->count() > 0) {
            return response()->json(['message' => 'Book has reservations'], 409);
        } else {
            $book->delete();
            return response()->json(['message' => 'Book deleted'], 204);
        }
    }
}
