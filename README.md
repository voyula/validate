# validate

[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]
[![Scrutinizer Quality Score][ico-scrutinizer]][link-scrutinizer]
[![Coverage Status][ico-coverage]][link-coverage]

[![Stable Version][ico-version]][link-version]
[![Total Downloads][ico-downloads]][link-downloads]
[![License][ico-license]][link-license]

PHP library for data format validation.

## Installation

Via [Composer](https://getcomposer.org/)

```bash
$ composer require voyula/validate
```

## Testing

Via [PHPUnit](https://phpunit.de/)

```bash
$ composer test
```

## Requires

- PHP 7.2.4 or newer.
- PHP-mbstring extension.

## Usage

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use Voyula\Validate\Validator;

$validator = new Validator;

$validator->addRules([
    ['username', 'Username', 'role:username|minLen:3|maxLen:15'],
    ['email', 'Email', 'email|maxLen:100'],
    ['password', 'Password', 'minLen:4|maxLen:25'],
    ['password_again', 'Password Again', 'same:password']
]);

$validator->addRule('postal_code', 'Postal Code', 'digit|len:5');
$validator->addRule('item_count', 'Item Count', 'numeric|minNum:5|maxNum:1000');

$data = [
    'username' => 'panther',
    'email' => 'panther@mail.com',
    'password' => 'panther123',
    'password_again' => 'panther123',
    'postal_code' => '43945',
    'item_count' => '572'
];

if ($validator->run($data)) {
    echo 'Validated!';
} else {
    print_r($validator->errors);
}

```

## Standards

- [PSR-1: Basic Coding Standard](https://www.php-fig.org/psr/psr-1/)
- [PSR-2: Coding Style Guide](https://www.php-fig.org/psr/psr-2/)
- [PSR-4: Autoloader](https://www.php-fig.org/psr/psr-4/)
- [Semantic Versioning 2.0.0](https://semver.org/)

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## Credits

- [voyula](https://github.com/voyula)
- [All Contributors](../../contributors)

## License

Licensed under the MIT License. See [License File](LICENSE.md) for more information.

[ico-travis]: https://img.shields.io/travis/voyula/validate/master.svg?longCache=true&style=flat-square
[ico-styleci]: https://github.styleci.io/repos/142753977/shield?branch=master
[ico-coverage]: https://img.shields.io/scrutinizer/coverage/g/voyula/validate.svg?longCache=true&style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/g/voyula/validate.svg?longCache=true&style=flat-square

[ico-version]: https://img.shields.io/packagist/v/voyula/validate.svg?longCache=true&style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/voyula/validate.svg?longCache=true&style=flat-square
[ico-license]: https://img.shields.io/packagist/l/voyula/validate.svg?longCache=true&style=flat-square


[link-travis]: https://travis-ci.org/voyula/validate
[link-styleci]: https://github.styleci.io/repos/142753977
[link-coverage]: https://scrutinizer-ci.com/g/voyula/validate
[link-scrutinizer]: https://scrutinizer-ci.com/g/voyula/validate

[link-version]: https://packagist.org/packages/voyula/validate
[link-downloads]: https://packagist.org/packages/voyula/validate
[link-license]: LICENSE.md
