<?php

namespace Treiner\Http\Resources;

use Auth;
use Illuminate\Http\Resources\Json\JsonResource;
use Cloudder;

class Message extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user_id = Auth::id();
        $fromUser = $this->to_id != $user_id ? true : false;
        $image = $this->to_id != $user_id ? $this->to->image_id : $this->from->image_id;
        return [
            'id' => $this->id,
            'from_id' => intval($this->from_id),
            'to_id' => intval($this->to_id),
            'image' => $this->when(!$fromUser, Cloudder::secureShow($image)),
            'conversation_id' => $this->conversation_id,
            'content' => $this->content,
            'seen' => $this->seen,
            'is_from_current_user' => $fromUser,
            'created_at' => $this->created_at
        ];
    }
}
