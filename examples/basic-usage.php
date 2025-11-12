<?php

/**
 * Basic Usage Examples for Supabase Laravel Package
 * 
 * This file demonstrates how to use the Supabase Laravel Package
 * in your Laravel applications.
 */

// 1. Using the Facade (recommended approach)
use Saeedvir\Supabase\Facades\Supabase;

// Get information about the Supabase connection
$info = Supabase::info();
print_r($info);

// Database operations
$users = Supabase::db()->select('users', '*', ['active' => true]);
print_r($users);

// Insert a new record
$newUser = Supabase::db()->insert('users', [
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'active' => true
]);
print_r($newUser);

// Auth operations
$authResult = Supabase::auth()->signIn('user@example.com', 'password');
print_r($authResult);

// Storage operations
$uploadResult = Supabase::storage()->upload('avatars', 'user-avatar.png', '/path/to/local/file.png');
print_r($uploadResult);

// Get public URL for a stored file
$publicUrl = Supabase::storage()->publicUrl('avatars', 'user-avatar.png');
echo $publicUrl;

// Realtime operations
$channelUrl = Supabase::realtime()->channelUrl('public', 'users');
echo $channelUrl;

// 2. Using the Service directly
use Saeedvir\Supabase\Services\SupabaseService;

$supabase = new SupabaseService();

// Database operations
$posts = $supabase->db->select('posts', 'id,title,content', [
    'published' => true
], [
    'limit' => 10,
    'order' => 'created_at.desc'
]);
print_r($posts);

// Update records
$updateResult = $supabase->db->update('users', ['id' => 1], [
    'last_login' => date('c')
]);
print_r($updateResult);

// Delete records
$deleteResult = $supabase->db->delete('users', ['active' => false]);
print_r($deleteResult);