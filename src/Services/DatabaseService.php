<?php

namespace Saeedvir\Supabase\Services;

use Illuminate\Support\Arr;

class DatabaseService
{
    protected SupabaseClient $client;

    public function __construct(SupabaseClient $client)
    {
        $this->client = $client;
    }

    /**
     * Select data from a table
     *
     * @param string $table
     * @param string $select
     * @param array $filters
     * @param array $options
     * @return array
     */
    public function select(string $table, string $select = '*', array $filters = [], array $options = []): array
    {
        $url = "/rest/v1/{$table}?select=" . urlencode($select);

        // Add filters
        foreach ($filters as $key => $value) {
            if (is_array($value)) {
                // Handle array values for 'in' queries
                $values = implode(',', array_map(fn($v) => is_string($v) ? "'{$v}'" : $v, $value));
                $url .= "&{$key}=in.({$values})";
            } else {
                // Handle single values
                $operator = Arr::get($options, "operators.{$key}", 'eq');
                $url .= "&{$key}={$operator}.{$value}";
            }
        }

        // Add options
        if (isset($options['limit'])) {
            $url .= "&limit={$options['limit']}";
        }

        if (isset($options['offset'])) {
            $url .= "&offset={$options['offset']}";
        }

        if (isset($options['order'])) {
            $url .= "&order={$options['order']}";
        }

        return $this->client->request('GET', $url);
    }

    /**
     * Insert data into a table
     *
     * @param string $table
     * @param array $data
     * @param bool $upsert
     * @return array
     */
    public function insert(string $table, array $data, bool $upsert = false): array
    {
        $url = "/rest/v1/{$table}";

        if ($upsert) {
            $url .= "?upsert=true";
        }

        return $this->client->request('POST', $url, [
            'json' => $data,
        ]);
    }

    /**
     * Update data in a table
     *
     * @param string $table
     * @param array $filters
     * @param array $data
     * @return array
     */
    public function update(string $table, array $filters, array $data): array
    {
        $url = "/rest/v1/{$table}";

        // Build filter query
        $filterQuery = '';
        foreach ($filters as $key => $value) {
            $operator = is_array($value) ? 'in' : 'eq';
            if ($operator === 'in') {
                $values = implode(',', array_map(fn($v) => is_string($v) ? "'{$v}'" : $v, $value));
                $filterQuery .= "&{$key}=in.({$values})";
            } else {
                $filterQuery .= "&{$key}=eq.{$value}";
            }
        }

        if (!empty($filterQuery)) {
            $url .= '?' . ltrim($filterQuery, '&');
        }

        return $this->client->request('PATCH', $url, [
            'json' => $data,
        ]);
    }

    /**
     * Delete data from a table
     *
     * @param string $table
     * @param array $filters
     * @return array
     */
    public function delete(string $table, array $filters): array
    {
        $url = "/rest/v1/{$table}";

        // Build filter query
        $filterQuery = '';
        foreach ($filters as $key => $value) {
            $operator = is_array($value) ? 'in' : 'eq';
            if ($operator === 'in') {
                $values = implode(',', array_map(fn($v) => is_string($v) ? "'{$v}'" : $v, $value));
                $filterQuery .= "&{$key}=in.({$values})";
            } else {
                $filterQuery .= "&{$key}=eq.{$value}";
            }
        }

        if (!empty($filterQuery)) {
            $url .= '?' . ltrim($filterQuery, '&');
        }

        return $this->client->request('DELETE', $url);
    }

    /**
     * Execute a custom RPC function
     *
     * @param string $functionName
     * @param array $params
     * @return array
     */
    public function rpc(string $functionName, array $params = []): array
    {
        $url = "/rest/v1/rpc/{$functionName}";

        return $this->client->request('POST', $url, [
            'json' => $params,
        ]);
    }
}