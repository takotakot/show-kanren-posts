# Show kanren posts

## Features

Translate `[kanren]` or `[kanren2]` shortcode into HTML.

## License

This software is provided under the GPL v2 or later.

## Development

```
composer install
```

Modify `docker_configs/.env.compose.develop` if needed.

```
cp -n ./docker_configs/.env.example ./bedrock/.env
cp -n ./docker_configs/.env.example.local ./bedrock/.env.local
```

```
docker compose -f docker-compose.yml --env-file=docker_configs/.env.compose.develop up -d
```

### Unit testing

```
git --git-dir= apply application_php.patch
```

If there are some update with autoload's run:

```
composer dump-autoload
```

Run tests

```
# ./vendor/bin/phpunit
composer test
```
