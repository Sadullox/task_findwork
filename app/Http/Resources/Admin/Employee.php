<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class Employee extends JsonResource
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
            'sur_name' => $this->sur_name,
            'given_names' => $this->given_names,
            'father_name' => $this->father_name,
            'position' => json_decode($this->position, true),
            'created_at' => $this->created_at
        ];
    }
}
