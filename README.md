# Show kanren posts

## Features

Translate `[kanren]` or `[kanren2]` shortcode into HTML.

## License

This software is provided under the GPL v2 or later.

## Development

```
composer install
```


```
cp -n ./docker_configs/.env.example ./bedrock/.env
cp -n ./docker_configs/.env.local.example ./bedrock/.env.local
```
\* Modify `docker_configs/.env.compose.develop` if needed.

Prepare dummy information & Add defines below into testing.php.

```
cp -n ./bedrock/config/environments/development.php ./bedrock/config/environments/testing.php
---
// Connect container's DB from local for PHPUnit
Config::define('DB_HOST', '127.0.0.1');

// Required dummy info for PHPUnit
define( 'WP_TESTS_DOMAIN', 'example.org' );
define( 'WP_TESTS_EMAIL', 'admin@example.org' );
define( 'WP_TESTS_TITLE', 'Test Blog' );
define( 'WP_PHP_BINARY', 'php' );
---
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
