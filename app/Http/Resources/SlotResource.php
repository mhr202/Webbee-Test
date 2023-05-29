<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class SlotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public static $wrap = 'slots';


    public function toArray($request)
    {
        return [
            'date' => $this->date,
            'day' => Carbon::parse($this->date)->format('l'),
            'capacity' => $this->capacity,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ];
    }

}
