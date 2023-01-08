добавим в /etc/hosts:
<p style="color: #F8F8F8; font-weight: bold;">  127.0.0.1	elasticusage.org</p>

выполним:
<p style="color: #F8F8F8; font-weight: bold;"> git clone [имя этого репозитоия] elasticusage.org </p>
<p style="color: #F8F8F8; font-weight: bold;"> cd elasticusage.org </p>
<p style="color: #F8F8F8; font-weight: bold;"> cp application/.env.example application/.env </p>

настроим содержимое .env:

    APP_NAME=MY
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=db_name
    DB_USERNAME=db_username
    DB_PASSWORD=db_password
	APP_URL=https://elasticusage.org

далее:
<p style="color: #F8F8F8;">
The default operating system limits on mmap counts is likely to be too low, which may result in out of memory exceptions.
To set this value permanently, update the <b><a href="https://www.elastic.co/guide/en/elasticsearch/reference/7.17/vm-max-map-count.html">vm.max_map_count</a></b> setting in <b>/etc/sysctl.conf</b>: 
<b>vm.max_map_count=262144</b>
</p>

<p style="color: #F8F8F8; font-weight: bold;">
docker-compose  --env-file ./application/.env up  -d --build
</p>

<p style="color: #F8F8F8; font-weight: bold;">
docker-compose exec app composer install
</p>

<p style="color: #F8F8F8; font-weight: bold;">
docker-compose exec app php artisan key:generate
</p>

далее вместо того чтобы каждый раз писать <span  style="color: #F8F8F8; font-weight: bold;">docker-compose exec app</span> можно использовать для входа в контейнер:
<p style="color: #F8F8F8; font-weight: bold;">
docker exec -it elasticusage-app bash
</p>

должены быть выполнены миграции и посев данных:
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
