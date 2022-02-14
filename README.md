# BetterBlade
A port of Laravel 9's Blade::render functionality for previous versions

## Installation

Using composer:

```bash
composer require strakez/betterblade 
```

Then, to your `config/app.php` file:

- include the Service Provider
```php
BetterBlade\BetterBladeServiceProvider::class
```

- and then register the Facade
```php
'BetterBlade'   =>  BetterBlade\BetterBladeFacade::class,
```

## Usage

Use the registered Facade, `BetterBlade::render()` to render inline templates as strings.

```php
$inlineTemplate = "Hello {{ $place }}, hello {{ $otherPlace }}!";
$replacementVariables = [
    'place' => "World",
    'otherPlace' => "Universe"
];
BetterBlade::render($inlineTemplate, $replacementVariables);

// Hello World, hello Universe!
```