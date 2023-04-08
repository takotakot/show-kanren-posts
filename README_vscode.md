# config

If you use PHP intelephense:

Add below for wordpress suggestions:

```
"settings": {
		"intelephense.stubs": [
			"wordpress",
		],
```
Add below for wp-phpunit suggestions:

```
		"intelephense.environment.includePaths": [
			"vendor/wp-phpunit/wp-phpunit/includes/",
		],
```
