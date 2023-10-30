<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserLocationsResource extends JsonResource
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
            "id" => $this->id,
            'user_code' => $this->user_code,
            'position' => $this->getPosition($this->current_gps),
            'name' => $this->pluckFirstName($this->user->name),
        ];
    }
    public function getPosition($current_gps)
    {
        $myArray = explode(',', $current_gps);
        $position = [
            'lat' => (float) $myArray[0],
            'lng' => (float) $myArray[1],
        ];
        return $position;
    }
    public function pluckFirstName($name)
    {
        $nameParts = explode(' ', $name);
        return $nameParts[0];
    }
}
