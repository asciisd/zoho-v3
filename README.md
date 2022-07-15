# Laravel Zoho API V3 Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/asciisd/zoho-v3.svg?style=flat-square)](https://packagist.org/packages/asciisd/zoho-v3)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/asciisd/zoho-v3/run-tests?label=tests)](https://github.com/asciisd/zoho-v3/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/asciisd/zoho-v3/Check%20&%20fix%20styling?label=code%20style)](https://github.com/asciisd/zoho-v3/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/asciisd/zoho-v3.svg?style=flat-square)](https://packagist.org/packages/asciisd/zoho-v3)

This package used to integrate with the new Zoho V3 Api CRM

## Requirements

* PHP >= 7.2
* Laravel >= 8.*

## Registering a Zoho Client

Since Zoho CRM APIs are authenticated with OAuth2 standards, you should register your client app with Zoho. To register your app:

- Visit this page [https://api-console.zoho.com/](https://api-console.zoho.com)

- Click on `ADD CLIENT`.

- Choose a `Client Type`.

- Enter **Client Name**, **Client Domain** or **Homepage URL** and **Authorized Redirect URIs** then click `CREATE`.

- Your Client app would have been created and displayed by now.

- Select the created OAuth client.

- Generate grant token by providing the necessary scopes, time duration (the duration for which the generated token is valid) and Scope Description.

## Installation

You can install the package via `composer require`:

```bash
composer require asciisd/zoho-v3
```

You'll need to add the following variables to your .env file. Use the credentials previously obtained registering your application.

```dotenv
ZOHO_CLIENT_ID=
ZOHO_CLIENT_SECRET=
ZOHO_REDIRECT_URI=
ZOHO_CURRENT_USER_EMAIL=
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="zoho-v3-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="zoho-v3-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="zoho-v3-views"
```

## Usage

```php
$zoho = new Asciisd\Zoho();
echo $zoho->echoPhrase('Hello, Asciisd!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/asciisd/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [aemaddin](https://github.com/asciisd)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
