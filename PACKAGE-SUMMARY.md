# Supabase Laravel Package - Package Summary

## Overview

This package provides a comprehensive integration between Laravel and Supabase services, allowing Laravel developers to easily leverage Supabase's powerful backend capabilities including authentication, database operations, file storage, and real-time subscriptions.

## Package Structure

```
supabase/
├── config/
│   └── supabase.php              # Configuration file
├── src/
│   ├── Services/                 # Core service classes
│   │   ├── SupabaseClient.php    # HTTP client for Supabase API
│   │   ├── AuthService.php       # Authentication service
│   │   ├── DatabaseService.php   # Database operations service
│   │   ├── StorageService.php    # File storage service
│   │   ├── RealtimeService.php   # Real-time subscriptions service
│   │   └── SupabaseService.php   # Main service facade
│   ├── Facades/
│   │   └── Supabase.php          # Laravel facade
│   └── SupabaseServiceProvider.php # Service provider
├── examples/
│   ├── basic-usage.php           # Basic usage examples
│   ├── routes-example.php        # Example routes
│   └── SupabaseExampleController.php # Example controller
├── docs/
│   ├── INSTALLATION.md           # Installation guide
│   └── USAGE.md                  # Usage documentation
├── composer.json                 # Composer configuration
├── README.md                     # Main documentation
├── CHANGELOG.md                  # Version history
└── LICENSE                       # License information
```

## Key Features

### 1. Authentication Service
- User signup and signin
- Password reset functionality
- User profile management
- Session handling
- Token refresh

### 2. Database Service
- CRUD operations (Create, Read, Update, Delete)
- Advanced querying with filters and operators
- Pagination and ordering
- RPC function execution

### 3. Storage Service
- File upload from path or content
- File management (move, copy, delete)
- Public and authenticated URLs
- Signed URLs for private files
- File listing capabilities

### 4. Realtime Service
- WebSocket channel URL generation
- Client connection helpers
- JavaScript integration snippets

## Installation

```bash
composer require saeedvir/supabase
```

## Configuration

Add to your `.env` file:
```env
SUPABASE_URL=https://your-project.supabase.co
SUPABASE_KEY=your-supabase-public-key
SUPABASE_SECRET=your-supabase-secret-key
```

## Usage

### Using the Facade
```php
use Saeedvir\Supabase\Facades\Supabase;

// Database operations
$users = Supabase::db()->select('users');

// Auth operations
$result = Supabase::auth()->signIn('user@example.com', 'password');

// Storage operations
$result = Supabase::storage()->upload('avatars', 'user.png', '/path/to/file.png');
```

### Using the Service Directly
```php
use Saeedvir\Supabase\Services\SupabaseService;

$supabase = new SupabaseService();
$users = $supabase->db->select('users');
```

## Requirements

- PHP ^8.0
- Laravel ^11.0|^12.0
- GuzzleHTTP ^7.0

## License

MIT License - see [LICENSE](LICENSE) file for details.

## Support

For issues and feature requests, please use the GitHub repository issues page.