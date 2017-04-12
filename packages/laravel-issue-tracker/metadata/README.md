#Laravel Issue Metadata

##Introduction
This metadata package can manage a `key => value` pairs to use your own metadata for you own application.
This is a standard <b>RESTfull</b> api.

## License
Laravel Issue Metadata is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

## Install

Via Composer

``` bash
$ composer require laravel-issue-tracker/metadata
```

### Configuration

After installing the Laravel Issue Metadata library, register the `LaravelIssueTracker\Metadata\MetadataServiceProviderr` in your `config/app.php` configuration file:

```php
'providers' => [
    // Other service providers...
    LaravelIssueTracker\Metadata\MetadataServiceProvider::class,
],
```

### Migration
Next you have to run the `artisan` migrate command to create the necessary database tables.
```php
php artisan migrate
```

## Usage

You can use the standard RESTful URLs to get the list of the metadata or add a new one to the database.
There are two type of metadata exists in the api. The first is `label` and the other one is `setting`.

You can use these URLs for the different functionalitites:

``` php
GET http://yourapplicationurl/api/v1/metadata
GET http://yourapplicationurl/api/v1/metadata/{id}
POST http://yourapplicationurl/api/v1/metadata/{id}
PUT http://yourapplicationurl/api/v1/metadata/{id}
DELETE http://yourapplicationurl/api/v1/metadata/{id}
```

## Security
If you discover any security related issues, please email :author_email instead of using the issue tracker.

## Credits

- [:author_name][link-author]
- [All Contributors][link-contributors]

[ico-version]: https://img.shields.io/packagist/v/:vendor/:package_name.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/:vendor/:package_name/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/:vendor/:package_name.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/:vendor/:package_name.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/:vendor/:package_name.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/:vendor/:package_name
[link-travis]: https://travis-ci.org/:vendor/:package_name
[link-scrutinizer]: https://scrutinizer-ci.com/g/:vendor/:package_name/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/:vendor/:package_name
[link-downloads]: https://packagist.org/packages/:vendor/:package_name
[link-author]: https://github.com/:author_username
[link-contributors]: ../../contributors
