<?php

namespace App\Models\QueryBuilders;

use ElasticScoutDriverPlus\Builders\QueryBuilderInterface;

final class ArticlaFormQueryBuilder implements  QueryBuilderInterface
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
            'match' => [
                'title' => [
                    'query' => $this->input,
                    'fuzziness' => 'AUTO'
                ]
            ]
        ];
    }
}
