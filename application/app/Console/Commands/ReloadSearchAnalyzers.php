<?php

namespace App\Console\Commands;

use Elasticsearch\Client;
use Illuminate\Console\Command;

class ReloadSearchAnalyzers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reload-search-analyzers {index}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reload index search analyzers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Client $client)
    {
        $indexName = $this->argument('index');
        $response = null;
        $reloadAnalyzersException = null;
        try {
            $response = $client->indices()->reloadSearchAnalyzers(['index' => $indexName]);
        } catch (\Exception $exception) {
            $reloadAnalyzersException = $exception;
        }

        $response2 = null;
        $clearCacheException = null;
        try {
            $response2 = $client->indices()->clearCache(['index' => $indexName]);
        } catch (\Exception $exception) {
            $clearCacheException = $exception;
        }

        if (null !== $reloadAnalyzersException) {
            $this->error('Reload search analyzers failed:');
            $this->line($reloadAnalyzersException->getMessage());
        } else {
            $this->info('Reload search analyzers:');
            $this->recursiveCollect($response, 1);
        }
        $this->newLine();

        if (null !== $clearCacheException) {
            $this->error('Index Cache clear failed:');
            $this->line($clearCacheException->getMessage());
        } else {
            $this->info('Index Cache clear:');
            $this->recursiveCollect($response2, 1);
        }
        $this->newLine();

        return 0;
    }
    protected function recursiveCollect(array $array, ?int $nesting = 0): void
    {
        $prefix = $this->getPrefix($nesting);

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if ((int)$key != (string)$key) {
                    $this->line($prefix . $key . ':');
                }
                $value = $this->recursiveCollect($value, $nesting + 1);
                $array[$key] = $value;
            } else {
                $this->line($prefix . (((int)$key == (string)$key) ? '-' : $key . ': ') . $value);
            }
        }
    }

    protected function getPrefix(int $nesting): string
    {
        $prefix = '';
        $tabSpace = '  ';
        for ($i = 0; $i < $nesting; $i++) {
            $prefix .= $tabSpace;
        }
        return $prefix;
    }
}
