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
use App\Events\ReservationStatusChange;
use Illuminate\Support\Facades\Gate;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Gate::authorize('viewAny', Reservation::class);

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
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request)
    {
        Gate::authorize('create', Reservation::class);

        return new ReservationResource(Reservation::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        // Gate::authorize('view', $reservation);

        return new ReservationResource($reservation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        Gate::authorize('update', $reservation);

        $reservation->update($request->all());
        // Check if the status has been updated, then trigger an event
        if ($request->status) {
            event(new ReservationStatusChange($reservation, $reservation->user));
        }
        return new ReservationResource($reservation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        Gate::authorize('delete', $reservation);
        
        $reservation->delete();
        return response()->json(['message' => 'Reservation deleted'], 204);
    }
}
