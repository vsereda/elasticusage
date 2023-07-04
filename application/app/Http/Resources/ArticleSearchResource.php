<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleSearchResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $item = $this->resource;
        $content = $item->document()->content();

        $titleSnippet = $item->highlight()->snippets('title')->first();
        $bodySnippets = $item->highlight()->snippets('body')
            ->map(function ($item) {
                return $item . '...</br>';
            })->toArray();

        if ($titleSnippet) {
            $content['title'] = $titleSnippet;
        }
        $content['body_snippets'] = join('', $bodySnippets);
        $content['id'] = (string)($item->document()->id());

        return $content;
    }
}
