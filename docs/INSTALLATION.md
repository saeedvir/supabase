# Installation Guide

This guide explains how to install and set up the Supabase Laravel Package.

## Requirements

- PHP 8.0 or higher
- Laravel 11.0 or higher
- Composer
- A Supabase account and project

## Installation Steps

### 1. Install the Package

Install the package via Composer:

```bash
composer require saeedvir/supabase
```

### 2. Publish Configuration

Publish the configuration file to customize the package settings:

```bash
php artisan vendor:publish --provider="Saeedvir\Supabase\SupabaseServiceProvider" --tag="supabase-config"
```

This will create a `config/supabase.php` file in your application.

### 3. Configure Environment Variables

Add your Supabase credentials to your `.env` file:

```env
SUPABASE_URL=https://your-project.supabase.co
SUPABASE_KEY=your-supabase-public-key
SUPABASE_SECRET=your-supabase-secret-key
```

You can find these values in your Supabase project dashboard:
- `SUPABASE_URL`: Your Supabase project URL
- `SUPABASE_KEY`: Your Supabase public API key (anon key)
- `SUPABASE_SECRET`: Your Supabase service role key (for server-side operations)

### 4. Configure the Package (Optional)

You can customize the package behavior by modifying the `config/supabase.php` file:

```php
return [
    'url' => env('SUPABASE_URL', ''),
    'key' => env('SUPABASE_KEY', ''),
    'secret' => env('SUPABASE_SECRET', ''),

    'services' => [
        'auth' => true,
        'database' => true,
        'storage' => true,
        'realtime' => true,
    ],

    'http' => [
        'timeout' => 30,
        'retries' => 3,
    ],
];
```

### 5. Register the Service Provider (Laravel < 11)

If you're using Laravel < 11, you may need to manually register the service provider in `config/app.php`:

```php
'providers' => [
    // Other service providers...
    Saeedvir\Supabase\SupabaseServiceProvider::class,
];
```

### 6. Register the Facade (Optional, Laravel < 11)

If you want to use the facade and are using Laravel < 11, add it to the aliases array in `config/app.php`:

```php
'aliases' => [
    // Other aliases...
    'Supabase' => Saeedvir\Supabase\Facades\Supabase::class,
];
```

## Testing the Installation

After installation, you can test the package by creating a simple route:

```php
// routes/web.php
use Saeedvir\Supabase\Facades\Supabase;

Route::get('/supabase-test', function () {
    $info = Supabase::info();
    return response()->json($info);
});
```

Visit `/supabase-test` in your browser to see the connection information.

## Troubleshooting

### Common Issues

1. **"Class 'Supabase' not found"**: Make sure you've imported the facade or are using the full namespace.

2. **Connection errors**: Verify your Supabase credentials in the `.env` file.

3. **CORS issues**: Make sure your Supabase project's URL is added to the allowed domains in your Supabase dashboard.

### Debugging

Enable logging in your Laravel application to see detailed error messages:

```php
// config/logging.php
'channels' => [
    'supabase' => [
        'driver' => 'single',
        'path' => storage_path('logs/supabase.log'),
        'level' => 'debug',
    ],
],
```

Then check `storage/logs/supabase.log` for any error messages.