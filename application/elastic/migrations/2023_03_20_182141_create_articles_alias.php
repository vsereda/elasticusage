<?php
declare(strict_types=1);

use ElasticAdapter\Indices\Mapping;
use ElasticAdapter\Indices\Settings;
use ElasticMigrations\Facades\Index;
use ElasticMigrations\MigrationInterface;

final class CreateArticlesAlias implements MigrationInterface
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        Index::putAlias('articles', 'articles_alias');
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Index::deleteAlias('articles', 'articles_alias');
    }
}
