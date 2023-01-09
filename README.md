добавим в /etc/hosts:
<p style="color: #F8F8F8; font-weight: bold;">  127.0.0.1	elasticusage.org</p>

execute:
<p style="color: #F8F8F8; font-weight: bold;"> cp application/.env.example application/.env </p>

Set <b>.env</b> values:

    APP_NAME=MY
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=db_name
    DB_USERNAME=db_username
    DB_PASSWORD=db_password
	APP_URL=https://elasticusage.org

    ELASTIC_HOST=es:9200
    SCOUT_DRIVER=elastic

<p style="color: #F8F8F8;">
The default operating system limits on mmap counts is likely to be too low, which may result in out of memory exceptions.
To set this value permanently, update the <b><a href="https://www.elastic.co/guide/en/elasticsearch/reference/7.17/vm-max-map-count.html">vm.max_map_count</a></b> setting in <b>/etc/sysctl.conf</b>: 
<b>vm.max_map_count=262144</b>
</p>

<p style="color: #F8F8F8; font-weight: bold;">
docker-compose  --env-file ./application/.env up  -d --build
</p>

enter into application container:
<p style="color: #F8F8F8; font-weight: bold;">
docker exec -it elasticusage-app bash
</p>

<p style="color: #F8F8F8; font-weight: bold;">
composer install
</p>

<p style="color: #F8F8F8; font-weight: bold;">
php artisan key:generate
</p>

<p style="color: #F8F8F8; font-weight: bold;">
php artisan migrate
</p>
<p style="color: #F8F8F8; font-weight: bold;">
php artisan elastic:migrate
</p>
<p style="color: #F8F8F8; font-weight: bold;">
php artisan db:seed
</p>
<p style="color: #F8F8F8; font-weight: bold;">
php artisan scout:import "App\Models\User"
</p>
<p style="color: #F8F8F8; font-weight: bold;">
php artisan scout:import "App\Models\Article"
</p>
