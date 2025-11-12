<?php

namespace Saeedvir\Supabase\Services;

class StorageService
{
    protected SupabaseClient $client;
    protected string $baseUrl;

    public function __construct(SupabaseClient $client)
    {
        $this->client = $client;
        $this->baseUrl = $client->getBaseUrl();
    }

    /**
     * Upload a file to a bucket
     *
     * @param string $bucket
     * @param string $path
     * @param string $filePath
     * @param array $options
     * @return array
     */
    public function upload(string $bucket, string $path, string $filePath, array $options = []): array
    {
        $fileContents = file_get_contents($filePath);
        $mimeType = mime_content_type($filePath);

        $headers = [
            'Content-Type' => $mimeType,
        ];

        // Add optional headers
        if (isset($options['cacheControl'])) {
            $headers['cache-control'] = $options['cacheControl'];
        }

        if (isset($options['upsert'])) {
            $headers['x-upsert'] = $options['upsert'] ? 'true' : 'false';
        }

        return $this->client->raw(
            'POST',
            "/storage/v1/object/{$bucket}/{$path}",
            $fileContents,
            $headers
        );
    }

    /**
     * Upload file content directly
     *
     * @param string $bucket
     * @param string $path
     * @param string $content
     * @param string $mimeType
     * @param array $options
     * @return array
     */
    public function uploadContent(string $bucket, string $path, string $content, string $mimeType, array $options = []): array
    {
        $headers = [
            'Content-Type' => $mimeType,
        ];

        // Add optional headers
        if (isset($options['cacheControl'])) {
            $headers['cache-control'] = $options['cacheControl'];
        }

        if (isset($options['upsert'])) {
            $headers['x-upsert'] = $options['upsert'] ? 'true' : 'false';
        }

        return $this->client->raw(
            'POST',
            "/storage/v1/object/{$bucket}/{$path}",
            $content,
            $headers
        );
    }

    /**
     * Move an existing file
     *
     * @param string $bucket
     * @param string $fromPath
     * @param string $toPath
     * @return array
     */
    public function move(string $bucket, string $fromPath, string $toPath): array
    {
        return $this->client->request('POST', "/storage/v1/object/move", [
            'json' => [
                'bucketId' => $bucket,
                'sourceKey' => $fromPath,
                'destinationKey' => $toPath,
            ],
        ]);
    }

    /**
     * Copy an existing file
     *
     * @param string $bucket
     * @param string $fromPath
     * @param string $toPath
     * @return array
     */
    public function copy(string $bucket, string $fromPath, string $toPath): array
    {
        return $this->client->request('POST', "/storage/v1/object/copy", [
            'json' => [
                'bucketId' => $bucket,
                'sourceKey' => $fromPath,
                'destinationKey' => $toPath,
            ],
        ]);
    }

    /**
     * Delete files from a bucket
     *
     * @param string $bucket
     * @param array $paths
     * @return array
     */
    public function delete(string $bucket, array $paths): array
    {
        return $this->client->request('DELETE', "/storage/v1/object/{$bucket}", [
            'json' => [
                'prefixes' => $paths,
            ],
        ]);
    }

    /**
     * Create a signed URL for private files
     *
     * @param string $bucket
     * @param string $path
     * @param int $expiresIn
     * @return array
     */
    public function createSignedUrl(string $bucket, string $path, int $expiresIn = 3600): array
    {
        return $this->client->request('POST', "/storage/v1/object/sign/{$bucket}/{$path}", [
            'json' => [
                'expiresIn' => $expiresIn,
            ],
        ]);
    }

    /**
     * Get the public URL for a file
     *
     * @param string $bucket
     * @param string $path
     * @return string
     */
    public function publicUrl(string $bucket, string $path): string
    {
        return "{$this->baseUrl}/storage/v1/object/public/{$bucket}/{$path}";
    }

    /**
     * Get the authenticated URL for a file
     *
     * @param string $bucket
     * @param string $path
     * @return string
     */
    public function authenticatedUrl(string $bucket, string $path): string
    {
        return "{$this->baseUrl}/storage/v1/object/authenticated/{$bucket}/{$path}";
    }

    /**
     * List objects in a bucket
     *
     * @param string $bucket
     * @param string $prefix
     * @param array $options
     * @return array
     */
    public function listObjects(string $bucket, string $prefix = '', array $options = []): array
    {
        $url = "/storage/v1/object/list/{$bucket}";

        $data = [
            'prefix' => $prefix,
        ];

        // Add optional parameters
        if (isset($options['limit'])) {
            $data['limit'] = $options['limit'];
        }

        if (isset($options['offset'])) {
            $data['offset'] = $options['offset'];
        }

        if (isset($options['sortBy'])) {
            $data['sortBy'] = $options['sortBy'];
        }

        return $this->client->request('POST', $url, [
            'json' => $data,
        ]);
    }
}