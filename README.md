## Yii2 IDE Helper Generator

### Install

Require this package with composer using the following command:

```
composer require mitirrli/yii2-ide-helper --dev
```

or add

```
"mitirrli/yii2-ide-helper": "*"
```

to the `require-dev` section of your `composer.json` file.

### Usage

After updating composer, add the component to the `components` array and `bootstrap` array in config file of console application:

```php
'bootstrap' => ['log', 'ideHelper'],
...
'components' => [
    'ideHelper' => [
      	'class' => 'Mitirrli\IdeHelper\IdeHelper',
    ],
  ...
],
```

Now you can generate ide helper file by command:

```
./yii ide-helper/generate
```

### Options

```php
'ideHelper' => [
    'class' => 'Mitirrli\IdeHelper\IdeHelper',
    'filename' => '_ide_helper',
    'rootDir' => dirname(__DIR__),
    'configFiles' => [
        'console/config/main.php',
        'console/config/main-local.php',
    ],
],
```

Default config files:

```php
protected $defaultConfigFiles = [
    'config/web.php',
    'config/main.php',
    'config/main-local.php',
    'common/config/main.php',
    'common/config/main-local.php',
    'frontend/config/main.php',
    'frontend/config/main-local.php',
    'backend/config/main.php',
    'backend/config/main-local.php',
];
```

