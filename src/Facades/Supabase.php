<?php

namespace Saeedvir\Supabase\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Saeedvir\Supabase\Services\DatabaseService $db
 * @method static \Saeedvir\Supabase\Services\AuthService $auth
 * @method static \Saeedvir\Supabase\Services\StorageService $storage
 * @method static \Saeedvir\Supabase\Services\RealtimeService $realtime
 * @method static array info()
 * 
 * @see \Saeedvir\Supabase\Services\SupabaseService
 */
class Supabase extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'supabase';
    }
}