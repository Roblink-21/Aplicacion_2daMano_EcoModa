<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'name' => $this->getFullName(),
            'email' => $this->email,
            'nickname' => $this->username,
            'personal_phone' => $this->personal_phone,
            'home_phone' => $this->home_phone,
            'address' => $this->address,
            'score' => $this -> score,
        ];
    }
}