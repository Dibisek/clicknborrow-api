<?php

namespace App\Listeners;

use App\Events\ReservationStatusChange;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Reservation;
use App\Notifications\StatusChanged;

class SendReservationStatusChangeNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ReservationStatusChange $event): void
    {
        $event->user->notify(new StatusChanged($event->reservation, $event->user));
    }
}
