<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'type' => $this->type,
            'status' => $this->status,
            'type_name' => $this->type_name,
            'status_name' => $this->status_name,
            'date' => $this->date,
            'total' => $this->total,
            'provider' => new ProviderResource($this->provider),
            'store' => new StoreResource($this->store),
            'user' => new UserResource($this->user),
            'products' => new ProductCollection($this->products)
        ];
    }
}
