<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
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
            'cart_id' => $this->cart_id,
            'article_id' => $this->article_id,
            'quantity' => $this->quantity,
            'price' => (float) $this->price,
            'total' => (float) $this->total,
            'options' => $this->options ?? [],
            'article' => $this->whenLoaded('article', function() {
                return [
                    'id' => $this->article->id,
                    'name' => $this->article->name,
                    'slug' => $this->article->slug,
                    'image' => $this->article->image ? asset('storage/' . $this->article->image) : null,
                    'price' => (float) $this->article->price,
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
