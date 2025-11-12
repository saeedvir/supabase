<?php

namespace Saeedvir\Supabase\Tests;

use PHPUnit\Framework\TestCase;
use Saeedvir\Supabase\Services\SupabaseClient;

class SupabaseClientTest extends TestCase
{
    public function test_can_instantiate_supabase_client()
    {
        $client = new SupabaseClient();
        
        $this->assertInstanceOf(SupabaseClient::class, $client);
    }
    
    public function test_supabase_client_has_base_url()
    {
        $client = new SupabaseClient();
        
        $this->assertIsString($client->getBaseUrl());
    }
    
    public function test_supabase_client_has_api_key()
    {
        $client = new SupabaseClient();
        
        $this->assertIsString($client->getApiKey());
    }
}