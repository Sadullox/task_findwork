<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeTest extends JsonResource
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
            'id' => $this->id,
            'score' => $this->score,
            'test_count' => (double) $this->test_count,
            'employee' => json_decode($this->employee, true),
            'created_at' => $this->created_at,
            $this->mergeWhen($this->withParams === true,[
                "question" => $this->question?new EmployeeTestShowCollection($this->question):[],
            ]),
        ];
    }
}
