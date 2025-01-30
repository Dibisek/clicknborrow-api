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

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
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
        return new BookResource(Book::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
