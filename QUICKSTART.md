# Quick Start Guide

Get up and running with the Supabase Laravel Package in minutes.

## Installation

```bash
composer require saeedvir/supabase
```

## Configuration

1. Publish the config file:
```bash
php artisan vendor:publish --provider="Saeedvir\Supabase\SupabaseServiceProvider" --tag="supabase-config"
```

2. Add your Supabase credentials to `.env`:
```env
SUPABASE_URL=https://your-project.supabase.co
SUPABASE_KEY=your-supabase-public-key
```

## Basic Usage

```php
use Saeedvir\Supabase\Facades\Supabase;

// Get all users
$users = Supabase::db()->select('users');

// Create a new user
$newUser = Supabase::db()->insert('users', [
    'name' => 'John Doe',
    'email' => 'john@example.com'
]);

// Sign in a user
$auth = Supabase::auth()->signIn('john@example.com', 'password');

// Upload a file
Supabase::storage()->upload('avatars', 'john.png', '/path/to/file.png');
```

That's it! You're now ready to use all Supabase services in your Laravel application.