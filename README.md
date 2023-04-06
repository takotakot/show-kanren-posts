# Show kanren posts

## Features

Translate `[kanren]` or `[kanren2]` shortcode into HTML.

## License

This software is provided under the GPL v2 or later.

## Development

```
composer install
cp -nr ./vendor/roots/bedrock/config ./bedrock/
cp -n ./vendor/roots/bedrock/web/index.php ./bedrock/web/index.php
cp -n ./vendor/roots/bedrock/web/wp-config.php ./bedrock/web/wp-config.php
cp -n ./vendor/roots/bedrock/web/app/mu-plugins/bedrock-autoloader.php ./bedrock/web/app/mu-plugins/bedrock-autoloader.php
cp -nr ./vendor/roots/bedrock/web/app/plugins ./bedrock/web/app/
cp -nr ./vendor/roots/bedrock/web/app/uploads ./bedrock/web/app/
```

Modify `docker_configs/.env.compose.develop` if needed.

```
cp -n ./docker_configs/.env.example ./bedrock/.env
cp -n ./docker_configs/.env.example.local ./bedrock/.env.local
```

```
docker compose -f docker-compose.yml --env-file=docker_configs/.env.compose.develop up -d
```
