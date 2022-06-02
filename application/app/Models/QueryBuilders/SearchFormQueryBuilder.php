<?php

namespace App\Models\QueryBuilders;

use ElasticScoutDriverPlus\Builders\QueryBuilderInterface;

final class SearchFormQueryBuilder implements QueryBuilderInterface
{
    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function buildQuery(): array
    {
        return [
            'match' => [
                'name' => [
                    'query' => $this->name,
                    'fuzziness' => 'AUTO'
                ]
            ]
        ];
    }
}
