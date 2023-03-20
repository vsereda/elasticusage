<?php
declare(strict_types=1);

use ElasticAdapter\Indices\Mapping;
use ElasticAdapter\Indices\Settings;
use ElasticMigrations\Facades\Index;
use ElasticMigrations\MigrationInterface;

final class CreateArticlesIndex implements MigrationInterface
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        $mapping = [
            'properties' => [
                'title' => [
                    'type' => 'text',
                    'analyzer' => 'title_analyzer',
                    'search_analyzer' => 'title_search_analyzer',
                ],
                'body' => [
                    'type' => 'text',
                    'analyzer' => 'body_analyzer',
                    'search_analyzer' => 'body_search_analyzer',
                ],
            ]
        ];

        $settings = [
            'analysis' => [
                'analyzer' => [
                    'title_analyzer' => [
                        'type' => 'custom',
                        'char_filter' => [
                            'html_strip'
                        ],
                        'tokenizer' => 'standard',
                        'filter' => [
                            "lowercase",
                        ]
                    ],
                    'title_search_analyzer' => [
                        'type' => 'custom',
                        'char_filter' => [
                            'html_strip'
                        ],
                        'tokenizer' => 'standard',
                        'filter' => [
                            "lowercase",
                            "synonym_filter",
                            "english_stop"
                        ]
                    ],
                    'body_analyzer' => [
                        'type' => 'custom',
                        'char_filter' => [
                            'html_strip'
                        ],
                        'tokenizer' => 'standard',
                        'filter' => [
                            "lowercase",
                        ]
                    ],
                    'body_search_analyzer' => [
                        'type' => 'custom',
                        'char_filter' => [
                            'html_strip'
                        ],
                        'tokenizer' => 'standard',
                        'filter' => [
                            "lowercase",
                            "synonym_filter",
                            "english_stop"
                        ]
                    ],
                ],
                'filter' => [
                    "english_stop" => [
                        'type' => 'stop',
                        'stopwords' => '_english_'
                    ],
                    'synonym_filter' => [
                        'type' => 'synonym',
                        'synonyms_path' => 'synonyms.txt',
                    ],
                ]
            ],
        ];

        Index::createRaw('articles', $mapping, $settings);
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Index::dropIfExists('articles');
    }
}
