<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ElasticScoutDriverPlus\Searchable;
use App\Models\QueryBuilders\ArticleFormQueryBuilder;
use ElasticScoutDriverPlus\Builders\SearchRequestBuilder;
class Article extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'title',
        'body',
    ];

    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
        ];
    }

    public static function searchForm(string $input): SearchRequestBuilder
    {
        return new SearchRequestBuilder(new ArticleFormQueryBuilder($input), new static());
    }
}
