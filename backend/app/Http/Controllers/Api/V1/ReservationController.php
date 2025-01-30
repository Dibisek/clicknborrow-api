<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreReservationRequest;
use App\Http\Requests\V1\UpdateReservationRequest;
use App\Models\Reservation;
use App\Http\Resources\V1\ReservationResource;
use App\Http\Resources\V1\ReservationCollection;
use Illuminate\Http\Request;
use App\Filters\V1\ReservationFilter;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new ReservationFilter();
        $filterItems = $filter->transform($request); // [['column', 'operator', 'value']])

        if (count($filterItems) == 0) {
            return new ReservationCollection(Reservation::paginate());
        } else {
            $books = Reservation::where($filterItems)->paginate();
            return new ReservationCollection($books->appends($request->query()));
        }

        Reservation::where($filterItems);

        return new ReservationCollection(Reservation::paginate());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        return new ReservationResource($reservation);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
