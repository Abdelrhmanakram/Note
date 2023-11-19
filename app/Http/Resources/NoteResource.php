<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "Note_Name"=>$this->title,
            "Note_Content"=>$this->content,
            "Note_User_Id"=>$this->user_id,
        ];
    }
}
