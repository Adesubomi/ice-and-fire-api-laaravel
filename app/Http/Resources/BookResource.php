<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'isbn' => $this->isbn,
            'authors' => $this->authors,
            'number_of_pages' => $this->number_of_pages,
            'publisher' => $this->publisher,
            'country' => $this->country,
            'release_date' => $this->release_date,
        ];
    }
}
