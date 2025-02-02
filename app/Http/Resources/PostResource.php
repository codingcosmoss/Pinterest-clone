<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Like;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
          return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'title' => $this->title,
            'image' => $this->image,
            'description' => $this->description,
            'like_count' => Like::where('post_id', $this->id)->count(),
        ];
        // return parent::toArray($request);
    }
}
