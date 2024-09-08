<?php

namespace App\Domain\Pipedrive\Trait;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

trait PipedriveRequestTrait
{
    private function getHTTPClient(): PendingRequest
    {
        return Http::baseUrl('https://api.pipedrive.com/v1/')
            ->withHeaders([
                'x-api-token' => env('PIPEDRIVE_API_TOKEN'),
            ]);
    }

    public function getRequest(string $endpoint): Response
    {
        return $this->getHTTPClient()
            ->get($endpoint);
    }

    public function postRequest(string $endpoint, array $data): Response
    {
        return $this->getHTTPClient()
            ->asJson()
            ->post($endpoint, $data);
    }

    public function putRequest(string $endpoint, array $data): Response
    {
        return $this->getHTTPClient()
            ->asJson()
            ->put($endpoint, $data);
    }

    public function patchRequest(string $endpoint, array $data): Response
    {
        return $this->getHTTPClient()
            ->asJson()
            ->patch($endpoint, $data);
    }
}
