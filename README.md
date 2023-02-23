## Introduction

This is my pet-project implementing basic Elasticsearch usage, using [babenkoivan/elastic-scout-driver-plus](https://github.com/babenkoivan/elastic-scout-driver-plus) package and CRUD SPA on vue-js. The search works on two fields of the article at once: title and body. Implemented correction of typos in the query and highlighting of the searched words in the search results.

## Requirements

Docker, Docker Compose

## installation

Register host on your local machine. Open <span style="color: #F8F8F8">/etc/hosts</span> file. Add parameter:

```
127.0.0.1	elasticusage.org
```

Type in terminal:

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
    APP_URL=http://elasticusage.org

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