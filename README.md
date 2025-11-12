# Supabase Laravel Package

A comprehensive Laravel package for integrating with Supabase services including Auth, Database, Storage, and Realtime.

- [Chat with AI for "saeedvir/supabase" package](https://context7.com/saeedvir/supabase?tab=chat)

## Installation

You can install the package via composer:

```bash
composer require saeedvir/supabase
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --provider="Saeedvir\Supabase\SupabaseServiceProvider" --tag="supabase-config"
```

Add your Supabase credentials to your `.env` file:

```env
SUPABASE_URL=https://your-project.supabase.co
SUPABASE_KEY=your-supabase-public-key
SUPABASE_SECRET=your-supabase-secret-key
```

## Get URL & KEY
- go to [supabase Dashboard](https://supabase.com/dashboard)
- select your project
- go to "Project Settings"
- go to "Data API"
- copy "Project URL" as "SUPABASE_URL"
- go to "API KEY"
- copy "service_role" secret key as "SUPABASE_KEY"
- then ```php artisan config:clear```

## Usage

### Using the Facade

```php
use Saeedvir\Supabase\Facades\Supabase;

// Database operations
$users = Supabase::db()->select('users', '*', ['active' => true]);

// Auth operations
$result = Supabase::auth()->signIn('user@example.com', 'password');

// Storage operations
$result = Supabase::storage()->upload('avatars', 'user-avatar.png', '/path/to/local/file.png');

// Realtime operations
$url = Supabase::realtime()->channelUrl('public', 'users');
```

### Using the Service Directly

```php
use Saeedvir\Supabase\Services\SupabaseService;

$supabase = new SupabaseService();

// Database operations
$users = $supabase->db->select('users', '*', ['active' => true]);

// Auth operations
$result = $supabase->auth->signIn('user@example.com', 'password');
```

## Features

### Auth Service

- User signup and signin
- Password reset
- User management
- Session management

### Database Service

- Select, insert, update, delete operations
- Filtering and ordering
- RPC function calls

### Storage Service

- File upload and download
- File management (move, copy, delete)
- Signed URLs for private files
- Public and authenticated URLs

### Realtime Service

- WebSocket channel URLs
- Client connection helpers
- JavaScript snippets for frontend integration

## Configuration Options

You can customize the package behavior by modifying the `config/supabase.php` file:

- Enable/disable specific services
- Configure HTTP client settings (timeout, retries)
- Set API keys and secrets

## Requirements

- PHP ^8.0
- Laravel ^11.0|^12.0
- GuzzleHTTP ^7.0

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
