<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'created_date' => $this->created_date,
            'completed_date' => $this->completed_date,
            'origin_store' => new StoreResource($this->origin_store),
            'destination_store' => new StoreResource($this->destination_store),
            'user_created' => new UserResource($this->user_created),
            'user_completed' => new UserResource($this->user_completed),
            'products' => new ProductCollection($this->products)
        ];
    }
}
