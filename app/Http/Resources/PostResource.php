<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\WebsiteResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'website_id' => $this->website_id,
            'website' => new WebsiteResource($this->website),
            'createdAd' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updatedAt' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
        ];
    }
}
