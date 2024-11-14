<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ForJawalyService
{
    public function sendSMS($phone, $message)
    {
        $headers = [
            "Accept: application/json",
            "Content-Type: application/json"
        ];

        $data = [
            "messages" => [
                [
                    "text" => $message,
                    "numbers" => [$phone],
                    "sender" => 'TechPack'  // يمكنك وضع الاسم مباشرةً لاختباره
                ]
            ]
        ];

        $response = Http::withHeaders($headers)
            ->baseUrl(config("services.forjawaly.base_url"))
            ->withBasicAuth(config("services.forjawaly.key"), config("services.forjawaly.secret"))
            ->post('account/area/sms/send', $data);

        return $response->json();
    }
}
