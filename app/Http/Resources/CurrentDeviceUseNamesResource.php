<?php

namespace App\Http\Resources;

use App\Models\CheckIn;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrentDeviceUseNamesResource extends JsonResource
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
            "name" => $this->name,
            'user_code' => $this->user_code,
            "last_checking" => $this->getLastChecking($this->id),
        ];
    }
    public function getLastChecking($user_id)
    {
        return CheckIn::whereId($user_id)->orderBy("created_at", "desc")->pluck("time")->implode('');
    }
}
