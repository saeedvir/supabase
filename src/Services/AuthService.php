<?php

namespace Saeedvir\Supabase\Services;

class AuthService
{
    protected SupabaseClient $client;

    public function __construct(SupabaseClient $client)
    {
        $this->client = $client;
    }

    /**
     * Sign up a new user
     *
     * @param string $email
     * @param string $password
     * @param array $userData
     * @return array
     */
    public function signUp(string $email, string $password, array $userData = []): array
    {
        $data = array_merge(compact('email', 'password'), $userData);

        return $this->client->request('POST', '/auth/v1/signup', [
            'json' => $data,
        ]);
    }

    /**
     * Sign in with email and password
     *
     * @param string $email
     * @param string $password
     * @return array
     */
    public function signIn(string $email, string $password): array
    {
        return $this->client->request('POST', '/auth/v1/token?grant_type=password', [
            'json' => compact('email', 'password'),
        ]);
    }

    /**
     * Sign in with a refresh token
     *
     * @param string $refreshToken
     * @return array
     */
    public function refresh(string $refreshToken): array
    {
        return $this->client->request('POST', '/auth/v1/token?grant_type=refresh_token', [
            'json' => [
                'refresh_token' => $refreshToken,
            ],
        ]);
    }

    /**
     * Get user details
     *
     * @param string $accessToken
     * @return array
     */
    public function getUser(string $accessToken): array
    {
        return $this->client->request('GET', '/auth/v1/user', [
            'headers' => [
                'Authorization' => "Bearer {$accessToken}",
            ],
        ]);
    }

    /**
     * Update user details
     *
     * @param string $accessToken
     * @param array $data
     * @return array
     */
    public function updateUser(string $accessToken, array $data): array
    {
        return $this->client->request('PUT', '/auth/v1/user', [
            'headers' => [
                'Authorization' => "Bearer {$accessToken}",
            ],
            'json' => $data,
        ]);
    }

    /**
     * Sign out user
     *
     * @param string $accessToken
     * @return array
     */
    public function signOut(string $accessToken): array
    {
        return $this->client->request('POST', '/auth/v1/logout', [
            'headers' => [
                'Authorization' => "Bearer {$accessToken}",
            ],
        ]);
    }

    /**
     * Send password reset email
     *
     * @param string $email
     * @return array
     */
    public function resetPassword(string $email): array
    {
        return $this->client->request('POST', '/auth/v1/recover', [
            'json' => compact('email'),
        ]);
    }

    /**
     * Invite a user by email
     *
     * @param string $email
     * @param string $accessToken
     * @return array
     */
    public function inviteUser(string $email, string $accessToken): array
    {
        return $this->client->request('POST', '/auth/v1/invite', [
            'headers' => [
                'Authorization' => "Bearer {$accessToken}",
            ],
            'json' => compact('email'),
        ]);
    }
}