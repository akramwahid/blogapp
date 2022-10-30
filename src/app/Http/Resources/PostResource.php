<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'body_html' => nl2br($this->body),
            'image' => $this->image,
            'author' => new AuthorResource($this->author),
            //'comments' => CommentResource::collection($this->comments),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,

        ];
    }
}
