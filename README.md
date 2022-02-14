# BetterBlade
A port of Laravel 9's inline blade rendering functionality for use with previous versions of Laravel. Currently this only supports v8.0+, but I'm working towards supporting earlier versions. Stay tuned!

Please note that this is intended for those who are not ready to upgrade their projects to Laravel 9. However, if you have time and resources to, I recommend installing/upgrading to Laravel 9 over using this package. (There's more to offer!)

## Installation

Using composer:

```bash
composer require strakez/betterblade
```

## Setup/Discovery

The package setup should be autodiscovered after installation. If not, you can do one of the following steps:

### Setup via Script
Run the autodiscover script manually:

```bash
php artisan package:discover
```

### Setup via Config File
Manually include the following two lines in your `config/app.php` file:

- Under "Autoloaded Service Providers"
```php
BetterBlade\BetterBladeServiceProvider::class
```

- Under "Class Aliases"
```php
'BetterBlade'   =>  BetterBlade\BetterBladeFacade::class,
```

## Usage

Use the registered Facade, `BetterBlade::render()` to render inline templates as strings.

```php
$inlineTemplate = "Hello {{ $place }}. Wassup {{ $otherPlace }}!";
$replacementVariables = [
    'place' => "World",
    'otherPlace' => "Universe"
];
$string = BetterBlade::render($inlineTemplate, $replacementVariables);

echo $string;
// Hello World. Wassup Universe!
```

This follows the usage and functionality found in Laravel 9. For more on this, please visit https://laravel.com/docs/9.x/blade#rendering-inline-blade-templates.

## Experimental Usage

Theoretically, since BetterBlade extends Blade, it is possible to override the Blade facade with BetterBlade. To do this, comment out the default reference in the `config/app.php` file, and add the following:

```php
//'Blade' => Illuminate\Support\Facades\Blade::class,
'Blade' => BetterBlade\BetterBladeFacade::class,
```

Then, usage would be as follows:

```php
$string = Blade::render($inlineTemplate, $replacementVariables);
```

This method works to polyfill the inline render functionality to the existing facade, ideally reducing code changes for future migrations to Laravel 9+. However, until more extensive testing has been performed (I'm the cautious type) to rule out any unintended functionality, I refrain from endorsing this usage.