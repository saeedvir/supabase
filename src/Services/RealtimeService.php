<?php

namespace Saeedvir\Supabase\Services;

class RealtimeService
{
    protected string $realtimeUrl;
    protected string $apiKey;
    protected string $projectId;

    public function __construct()
    {
        $this->realtimeUrl = str_replace('https://', 'wss://', rtrim(config('supabase.url'), '/')) . '/realtime/v1';
        $this->apiKey = config('supabase.key');
        $this->projectId = parse_url(config('supabase.url'), PHP_URL_HOST);
    }

    /**
     * Get the WebSocket URL for a specific table and schema
     *
     * @param string $schema
     * @param string $table
     * @return string
     */
    public function channelUrl(string $schema, string $table): string
    {
        return $this->realtimeUrl . "/{$schema}:{$table}";
    }

    /**
     * Prepare headers for client connection
     *
     * @return array
     */
    public function headers(): array
    {
        return [
            'apikey' => $this->apiKey,
            'Authorization' => "Bearer {$this->apiKey}",
        ];
    }

    /**
     * Example payload for subscribing to events
     *
     * @param string $event
     * @param string $schema
     * @param string $table
     * @return array
     */
    public function subscribePayload(string $event = 'INSERT', string $schema = 'public', string $table = 'products'): array
    {
        return [
            'type' => 'subscribe',
            'event' => $event, // INSERT, UPDATE, DELETE, *
            'schema' => $schema,
            'table' => $table,
        ];
    }

    /**
     * Return JS snippet for Livewire or Vue client
     *
     * @param string $table
     * @param string $schema
     * @return string
     */
    public function clientJsSnippet(string $table, string $schema = 'public'): string
    {
        return <<<JS
<script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js"></script>
<script>
const supabaseUrl = "{{ config('supabase.url') }}";
const supabaseKey = "{{ config('supabase.key') }}";
const supabase = supabase.createClient(supabaseUrl, supabaseKey);

supabase
  .channel('{$schema}:{$table}')
  .on('postgres_changes', { event: '*', schema: '{$schema}', table: '{$table}' }, payload => {
    console.log('Realtime event:', payload);
    // For Livewire, you can trigger a component update here
    // Livewire.emit('supabaseUpdated', payload);
  })
  .subscribe();
</script>
JS;
    }

    /**
     * Get the realtime URL
     *
     * @return string
     */
    public function getRealtimeUrl(): string
    {
        return $this->realtimeUrl;
    }
}