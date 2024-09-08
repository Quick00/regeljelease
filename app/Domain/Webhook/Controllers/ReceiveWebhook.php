<?php

namespace App\Domain\Webhook\Controllers;

use App\Domain\Pipedrive\Actions\ReceiveWebhookAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;

class ReceiveWebhook extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->all();
        if (!Arr::exists($data, 'current')) {
            return response()
                ->json(['message' => 'Invalid request'], 400);
        }

        if (!Arr::exists($data, 'previous')) {
            return response()
                ->json(['message' => 'Invalid request'], 400);
        }

        $meta = Arr::get($data, 'meta', []);
        $dealId = Arr::get($meta, 'id');

        if (empty($dealId)) {
            return response()
                ->json(['message' => 'Invalid request'], 400);
        }

        ReceiveWebhookAction::run($data);

        return response()
            ->json(['success' => true]);
    }
}
