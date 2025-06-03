<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MailtrapService
{
    protected string $token;
    protected int $inboxId;
    protected string $host;

    public function __construct()
    {
        $this->token = config('services.mailtrap.token');
        $this->inboxId = (int) config('services.mailtrap.inbox_id');
        $this->host = config('services.mailtrap.host');
    }

    /**
     * Fetch all messages from Mailtrap inbox
     *
     * @return array
     */
    public function fetchInboxMessages(): array
    {
        $url = "https://{$this->host}/api/v1/inboxes/{$this->inboxId}/messages";

        $response = Http::withHeaders([
            'Api-Token' => $this->token,
        ])->get($url);

        if ($response->ok()) {
            return $response->json();
        }

        // Log error details for debugging
        Log::error('Mailtrap API error', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        return [];
    }


    
}
