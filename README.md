# Assets plugin for CakePHP

## Requirements

- CakePHP 3.x

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require funayaki/assets:dev-master
```

### Enable plugin

In 3.0 you need to enable the plugin your `config/bootstrap.php` file:

```php
Plugin::load('Assets', ['bootstrap' => true, 'routes' => true, 'autoload' => true]);
```

### Running migrations

```shell
./bin/cake migrations migrate --plugin Assets
```

## Visit assets using browser

Visit `/admin/assets/assets/` using browser.
