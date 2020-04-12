# laravel-concurrent-sessions

This Laravel package limits the number of concurrent sessions per user.

# Installation

Require package with Composer.

```sh
composer require den1n/laravel-concurrent-sessions
```

Publish migration file provided by the package.

```sh
php artisan vendor:publish --provider="Den1n\ConcurrentSessions\ServiceProvider"
```

Migrate database.

```sh
php artisan migrate
```

Append `VerifyLimit` middleware to the `web` group in your `App\Http\Kernel` class.

```php
class Kernel extends HttpKernel
{
    protected $middlewareGroups = [
        'web' => [
            \Den1n\ConcurrentSessions\Middleware\VerifyLimit::class,
        ],
    ];
}
```

Modify your `App\User` model.

```php
class User
{
    // Append attribute.
    protected $attributes = [
        'sessions' => '[]',
    ];

    // And these casts.
    protected $casts = [
        'sessions_limit' => 'integer',
        'sessions' => 'array',
    ];
}
```

# Usage

Your `users` table now has additional columns:

* `sessions_limit` holds maximum count of concurrent sessions for the user.
* `sessions` contains a list of user sessions ids.

Just set `sessions_limit` field to desired number of concurrent sessions and `VerifyLimit` middleware will limit concurrent sessions for this user.

## Contributing

1. Fork it.
2. Create your feature branch: `git checkout -b my-new-feature`.
3. Commit your changes: `git commit -am 'Add some feature'`.
4. Push to the branch: `git push origin my-new-feature`.
5. Submit a pull request.

## Support

If you require any support open an issue on this repository.

## License

MIT
