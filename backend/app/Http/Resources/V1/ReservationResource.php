<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $status_names = [
            0 => 'Pending',
            1 => 'Approved',
            -1 => 'Rejected',
        ];

        return [
            'id' => $this->id,
            'user' => $this->user->firstname . ' ' . $this->user->lastname,
            'book' => $this->book->title,
            'startDate' => $this->start_date,
            'endDate' => $this->end_date,
            'status' => $status_names[$this->status] ?? 'Pending',
        ];
    }
}
