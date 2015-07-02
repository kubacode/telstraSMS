# telstraSMS

telstraSMS is a PHP package for the [Telstra SMS API](https://dev.telstra.com/content/sms-api-0).

The author is not affiliated with Telstra and Telstra is not involved in the development of this package in any way.

## Install

Via Composer

``` bash
$ composer require kubacode/telstrasms
```

## Laravel Configuration

telstraSMS has optional support for Laravel and comes with a Service Provider and Facades for easy integration. The vendor/autoload.php is included by Laravel, so you don't have to require or autoload manually. Just see the instructions below.

After you have installed telstraSMS, open your Laravel config file config/app.php and add the following lines.

In the $providers array add the service providers for this package.

``` php
kubacode\telstraSMS\SMSServiceProvider::class,
```

Add the facade of this package to the $aliases array.

``` php
'SMS' => kubacode\telstraSMS\SMSFacade::class,
```

Now the SMS Class will be auto-loaded by Laravel.

You also need to supply your API Key & API Secret in your .env environment file.

```
SMS_API_KEY=clientKey
SMS_API_SECRET=clientSecret
```

## Usage

``` php
$clientKey = 'clientKey';
$clientSecret = 'clientSecret';
$to = '0400000000';
$body = 'SMS Message'
$message = new kubacode\telstraSMS\telstraSMS($clientKey, $clientSecret);
$message->send($td, $body);
```

## Laravel Usage

``` php
// usage inside a laravel route
Route::get('/', function()
{
    $message = SMS::send('0400000000', 'Test SMS');

    return $message->messageId;
});
```

## Credits

- [Jacob Piers-Blundell](https://github.com/kubacode)
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-contributors]: ../../contributors