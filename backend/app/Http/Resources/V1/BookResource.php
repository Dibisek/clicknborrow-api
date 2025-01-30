<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author->name,
            'publicationDate' => $this->publication_date,
            'description' => $this->description,
            'pageCount' => $this->page_count,
            'categories' => $this->categories->pluck('category_name'),
            'reservations' => ReservationResource::collection($this->whenLoaded('reservations')),
        ];
    }
}
