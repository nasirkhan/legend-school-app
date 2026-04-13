<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ApiService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.backend.url'), '/');
    }

    /**
     * POST /api/v1/login
     *
     * @return array{token: string, user: array<string, mixed>}
     */
    public function login(string $email, string $password, string $deviceName): Response
    {
        return Http::post("{$this->baseUrl}/api/v1/login", [
            'email' => $email,
            'password' => $password,
            'device_name' => $deviceName,
        ]);
    }

    /**
     * DELETE /api/v1/logout — revokes the current Sanctum token.
     */
    public function logout(): Response
    {
        return $this->withToken()->delete("{$this->baseUrl}/api/v1/logout");
    }

    /**
     * GET /api/v1/users/profile/{username?}
     */
    public function getProfile(?string $username = null): Response
    {
        $url = "{$this->baseUrl}/api/v1/users/profile";

        if ($username !== null) {
            $url .= "/{$username}";
        }

        return $this->withToken()->get($url);
    }

    /**
     * PATCH /api/v1/users/profile
     *
     * @param  array<string, mixed>  $data
     */
    public function updateProfile(array $data): Response
    {
        return $this->withToken()->patch("{$this->baseUrl}/api/v1/users/profile", $data);
    }

    private function withToken(): \Illuminate\Http\Client\PendingRequest
    {
        return Http::withToken(session('api_token', ''))
            ->acceptJson();
    }
}
