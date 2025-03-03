<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'user' => new UserResource($this->user), // Foydalanuvchi ma'lumotlari
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
