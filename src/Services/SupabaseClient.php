<?php

namespace Saeedvir\Supabase\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class SupabaseClient
{
    protected Client $client;
    protected string $baseUrl;
    protected string $apiKey;
    protected string $secretKey;
    protected int $timeout;
    protected int $retries;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('supabase.url'), '/');
        $this->apiKey = config('supabase.key');
        $this->secretKey = config('supabase.secret');
        $this->timeout = config('supabase.http.timeout', 30);
        $this->retries = config('supabase.http.retries', 3);

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => $this->timeout,
            'headers' => [
                'apikey' => $this->apiKey,
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Make a request to the Supabase API
     *
     * @param string $method
     * @param string $uri
     * @param array $options
     * @param int $retries
     * @return array
     */
    public function request(string $method, string $uri, array $options = [], int $retries = null): array
    {
        $retries = $retries ?? $this->retries;
        $attempt = 0;

        while ($attempt <= $retries) {
            try {
                $response = $this->client->request($method, $uri, $options);
                return json_decode($response->getBody()->getContents(), true);
            } catch (RequestException $e) {
                $attempt++;
                $code = $e->getResponse()?->getStatusCode();
                Log::warning("Supabase request failed: [{$code}] {$e->getMessage()}");

                // Don't retry on client errors (4xx)
                if ($attempt > $retries || ($code && $code < 500)) {
                    return [
                        'error' => true,
                        'status' => $code,
                        'message' => $e->getMessage(),
                        'response' => optional($e->getResponse())->getBody()->getContents(),
                    ];
                }

                // Exponential backoff
                sleep(pow(2, $attempt));
            }
        }

        return ['error' => true, 'message' => 'Max retries exceeded'];
    }

    /**
     * Make a raw request with custom body and headers
     *
     * @param string $method
     * @param string $uri
     * @param mixed $body
     * @param array $headers
     * @return array
     */
    public function raw(string $method, string $uri, $body, array $headers = []): array
    {
        return $this->request($method, $uri, [
            'body' => $body,
            'headers' => $headers + $this->client->getConfig('headers'),
        ]);
    }

    /**
     * Get the base URL
     *
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * Get the API key
     *
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }
}