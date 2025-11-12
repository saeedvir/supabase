# Supabase Laravel Package Usage Guide

This guide explains how to use the Supabase Laravel Package to integrate Supabase services into your Laravel applications.

## Table of Contents
- [Installation](#installation)
- [Configuration](#configuration)
- [Basic Usage](#basic-usage)
- [Auth Service](#auth-service)
- [Database Service](#database-service)
- [Storage Service](#storage-service)
- [Realtime Service](#realtime-service)
- [Error Handling](#error-handling)

## Installation

Install the package via Composer:

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

## Basic Usage

The package provides a facade for easy access to all Supabase services:

```php
use Saeedvir\Supabase\Facades\Supabase;

// Get information about the Supabase connection
$info = Supabase::info();

// Access individual services
$users = Supabase::db()->select('users');
$authResult = Supabase::auth()->signIn('user@example.com', 'password');
```

## Auth Service

The Auth service handles user authentication and management.

### Sign Up

```php
$result = Supabase::auth()->signUp('user@example.com', 'password', [
    'full_name' => 'John Doe'
]);
```

### Sign In

```php
$result = Supabase::auth()->signIn('user@example.com', 'password');
```

### Get User

```php
$user = Supabase::auth()->getUser($accessToken);
```

### Update User

```php
$result = Supabase::auth()->updateUser($accessToken, [
    'full_name' => 'New Name'
]);
```

### Sign Out

```php
$result = Supabase::auth()->signOut($accessToken);
```

### Reset Password

```php
$result = Supabase::auth()->resetPassword('user@example.com');
```

## Database Service

The Database service provides methods for working with your Supabase database.

### Select Data

```php
// Select all columns
$users = Supabase::db()->select('users');

// Select specific columns
$users = Supabase::db()->select('users', 'id,name,email');

// Select with filters
$activeUsers = Supabase::db()->select('users', '*', [
    'active' => true
]);

// Select with complex filters
$users = Supabase::db()->select('users', '*', [
    'age' => [25, 30, 35] // IN query
], [
    'limit' => 10,
    'offset' => 0,
    'order' => 'created_at.desc',
    'operators' => [
        'age' => 'gte' // Use >= operator
    ]
]);
```

### Insert Data

```php
// Insert single record
$result = Supabase::db()->insert('users', [
    'name' => 'John Doe',
    'email' => 'john@example.com'
]);

// Insert with upsert
$result = Supabase::db()->insert('users', [
    'id' => 1,
    'name' => 'John Doe',
    'email' => 'john@example.com'
], true); // upsert = true
```

### Update Data

```php
$result = Supabase::db()->update('users', [
    'id' => 1
], [
    'name' => 'Jane Doe'
]);
```

### Delete Data

```php
$result = Supabase::db()->delete('users', [
    'active' => false
]);
```

### RPC Functions

```php
$result = Supabase::db()->rpc('get_user_count', [
    'active' => true
]);
```

## Storage Service

The Storage service handles file operations.

### Upload Files

```php
// Upload from file path
$result = Supabase::storage()->upload('avatars', 'user1.png', '/path/to/local/file.png');

// Upload with options
$result = Supabase::storage()->upload('avatars', 'user1.png', '/path/to/local/file.png', [
    'cacheControl' => '3600',
    'upsert' => true
]);

// Upload content directly
$result = Supabase::storage()->uploadContent(
    'avatars', 
    'user1.png', 
    $content, 
    'image/png'
);
```

### File Operations

```php
// Move file
$result = Supabase::storage()->move('avatars', 'user1.png', 'avatars/user1-new.png');

// Copy file
$result = Supabase::storage()->copy('avatars', 'user1.png', 'avatars/user1-copy.png');

// Delete files
$result = Supabase::storage()->delete('avatars', ['user1.png', 'user2.png']);
```

### URLs

```php
// Public URL
$url = Supabase::storage()->publicUrl('avatars', 'user1.png');

// Authenticated URL
$url = Supabase::storage()->authenticatedUrl('avatars', 'user1.png');

// Signed URL (for private files)
$result = Supabase::storage()->createSignedUrl('avatars', 'user1.png', 3600);
```

### List Objects

```php
$objects = Supabase::storage()->listObjects('avatars', 'user/', [
    'limit' => 10,
    'offset' => 0
]);
```

## Realtime Service

The Realtime service helps with WebSocket connections.

### Channel URL

```php
$url = Supabase::realtime()->channelUrl('public', 'users');
```

### Client JavaScript

```php
$js = Supabase::realtime()->clientJsSnippet('users');
```

## Error Handling

All service methods return an array. Check for the `error` key to determine if an error occurred:

```php
$result = Supabase::db()->select('users');

if (isset($result['error'])) {
    // Handle error
    echo "Error: " . $result['message'];
} else {
    // Process successful result
    foreach ($result as $user) {
        echo $user['name'];
    }
}
```