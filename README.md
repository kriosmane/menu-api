
# Menu API


[![Latest Version on Packagist](https://img.shields.io/packagist/v/:vendor_slug/:package_slug.svg?style=flat-square)](https://packagist.org/packages/:vendor_slug/:package_slug)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/:vendor_slug/:package_slug/run-tests?label=tests)](https://github.com/:vendor_slug/:package_slug/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/:vendor_slug/:package_slug/Check%20&%20fix%20styling?label=code%20style)](https://github.com/:vendor_slug/:package_slug/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/:vendor_slug/:package_slug.svg?style=flat-square)](https://packagist.org/packages/:vendor_slug/:package_slug)

Simple Laravel REST API project with Test-Driven Development


## Installation


1. Run the command below to install:

```bash
composer install
```

2. Copy `.env` file

```bash
cp .env.example .env
```

3. In file `.env` set database

```bash
...
DB_DATABASE=db_name
DB_USERNAME=db_username
DB_PASSWORD=db_password
...
```

4. Migrate database

```bash
php artisan migrate
```

5. Set encryption key

```bash
php artisan key:generate
```

6. Install passport

```bash
php artisan passport:install
```

7. Generate API documentation

```bash
php artisan l5-swagger:generate
```

### Access API documentation

1. Run the command below to start the server:

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

2. Visit this page [http://127.0.0.1:8000/api/documentation](http://127.0.0.1:8000/api/documentation) to access the API Documentation


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.


## Credits

- [kriosmane](https://github.com/kriosmane)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.