<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class TestContent extends JsonResource
{
    private $withParams;

    public function __construct($resource, $withParams = false)
    {
        $this->withParams = $withParams;
        $this->resource = $resource;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "question" => $this->question,
            // "desc" => $this->desc,
            "test_type" => $this->test_type,
            "created_at" => $this->created_at,
            "position" => json_decode($this->position, true),
            $this->mergeWhen($this->withParams === true,[
                "answer_option" => json_decode($this->answer_option, true),
            ]),
        ];
    }
}
