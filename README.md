# Assets plugin for CakePHP

## Requirements

- CakePHP 3.x

## Installation

_[Manual]_

* Download and unzip the repo (see the download button somewhere on this git page)
* Copy the resulting folder into `plugins`
* Rename the folder you just copied to `Assets`

_[GIT Submodule]_

In your `app` directory type:

```shell
git submodule add -b master git://github.com/funayaki/assets.git plugins/Assets
git submodule init
git submodule update
```

_[GIT Clone]_

In your `plugins` directory type:

```shell
git clone -b master git://github.com/funayaki/assets.git Assets
```

### Enable plugin

In 3.0 you need to enable the plugin your `config/bootstrap.php` file:

```php
Plugin::load('Josegonzalez/Upload');
Plugin::load('Assets', ['bootstrap' => true, 'routes' => true, 'autoload' => true]);
```

### Running migrations

```shell
./bin/cake migrations migrate --plugin Assets
```

## Visit assets using browser

Visit `/admin/assets/assets/` using browser.
