## Introduction

This is my pet-project implementing basic Elasticsearch usage, using [babenkoivan/elastic-scout-driver-plus](https://github.com/babenkoivan/elastic-scout-driver-plus) package and CRUD SPA on vue-js. The search works on two fields of the article at once: title and body. Implemented correction of typos in the query, synonyms and highlighting of the searched words in the search results.

## Requirements

Docker, Docker Compose

## installation

```bash
cp application/.env.example application/.env
```

Set <b>.env</b> file values:

```dotenv
    APP_NAME=ElastickUsage
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=db_name
    DB_USERNAME=db_username
    DB_PASSWORD=db_password
    APP_URL=127.0.0.1

    ELASTIC_HOST=es:9200
    SCOUT_DRIVER=elastic
```

The default operating system limits on mmap counts is likely to be too low, which may result in out of memory exceptions.
To set this value permanently, update the [vm.max_map_count](https://www.elastic.co/guide/en/elasticsearch/reference/7.17/vm-max-map-count.html) setting in <span style="color: #F8F8F8;">/etc/sysctl.conf: 
</span>vm.max_map_count=262144

Then type:

```bash
docker-compose  --env-file ./application/.env up  -d --build
```

Enter into application container:

```bash
docker exec -it elasticusage-app bash
```

Update synonyms file application/elastic/synonyms.txt with your synonyms set

Next commands you will use in app container:

```bash
composer install && 
php artisan key:generate && 
php artisan migrate && 
php artisan elastic:migrate && 
php artisan db:seed && 
php artisan scout:import "App\Models\Article" && 
npm install && 
npm run dev
```

You can update your synonyms file and then run:

```bash
php artisan reload-search-analyzers articles
```