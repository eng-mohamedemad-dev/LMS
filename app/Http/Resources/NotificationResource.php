<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'title' => $this->data['title'] ?? null,
            'body' => $this->data['body'] ?? null,
            'image' => $this->data['image'] ? asset('storage/' . $this->data['image']) : null,
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
            'read_at' => $this->read_at ? Carbon::parse($this->read_at)->diffForHumans() : null,
        ];
    }
}
