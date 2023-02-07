<?php

namespace App\Models\QueryBuilders;

use ElasticScoutDriverPlus\Builders\QueryBuilderInterface;

final class ArticleFormQueryBuilder implements QueryBuilderInterface
{
    /**
     * @var string
     */
    private $input;

    public function __construct(string $input)
    {
        $this->input = $input;
    }

    public function title(string $title): self
    {
        $this->input = $title;
        return $this;
    }

    public function buildQuery(): array
    {
        return [
            'multi_match' => [
                'fields' => ["title^1.5", "body"],
                'query' => $this->input,
                'fuzziness' => 'AUTO',
            ]
        ];
    }
}
