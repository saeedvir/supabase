<?php

namespace Saeedvir\Supabase\Tests;

use PHPUnit\Framework\TestCase;
use Saeedvir\Supabase\Services\SupabaseService;
use Saeedvir\Supabase\Services\SupabaseClient;

class SupabaseServiceTest extends TestCase
{
    public function test_can_instantiate_supabase_service()
    {
        $service = new SupabaseService();
        
        $this->assertInstanceOf(SupabaseService::class, $service);
    }
    
    public function test_supabase_service_has_client()
    {
        $service = new SupabaseService();
        
        $this->assertInstanceOf(SupabaseClient::class, $service->getClient());
    }
    
    public function test_supabase_service_has_database_service()
    {
        $service = new SupabaseService();
        
        if (config('supabase.services.database', true)) {
            $this->assertNotNull($service->db);
        } else {
            $this->assertNull($service->db);
        }
    }
    
    public function test_supabase_service_has_auth_service()
    {
        $service = new SupabaseService();
        
        if (config('supabase.services.auth', true)) {
            $this->assertNotNull($service->auth);
        } else {
            $this->assertNull($service->auth);
        }
    }
    
    public function test_supabase_service_has_storage_service()
    {
        $service = new SupabaseService();
        
        if (config('supabase.services.storage', true)) {
            $this->assertNotNull($service->storage);
        } else {
            $this->assertNull($service->storage);
        }
    }
    
    public function test_supabase_service_has_realtime_service()
    {
        $service = new SupabaseService();
        
        if (config('supabase.services.realtime', true)) {
            $this->assertNotNull($service->realtime);
        } else {
            $this->assertNull($service->realtime);
        }
    }
    
    public function test_supabase_service_info_method()
    {
        $service = new SupabaseService();
        $info = $service->info();
        
        $this->assertIsArray($info);
        $this->assertArrayHasKey('url', $info);
        $this->assertArrayHasKey('connected', $info);
        $this->assertArrayHasKey('services', $info);
    }
}