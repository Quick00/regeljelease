<?php

namespace App\Domain\Webhook\Controllers;

use App\Domain\Pipedrive\Actions\UpdatePayAfterValue;
use App\Domain\Pipedrive\Helpers\WebhookDiffHelper;
use App\Domain\Pipedrive\Pipedrive;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;

class ReceiveWebhook extends Controller
{
    public function __invoke(Request $request): void
    {
        $data = $request->all();
        if (!Arr::exists($data, 'current')) {
            throw new Exception('Invalid request');
        }

        if (!Arr::exists($data, 'previous')) {
            throw new Exception('Invalid request');
        }

        $meta = Arr::get($data, 'meta', []);
        $dealId = Arr::get($meta, 'id');

        if (empty($dealId)) {
            throw new Exception('Invalid request');
        }

        $previous = Arr::get($data, 'previous', []);
        $current = Arr::get($data, 'current', []);

        $diffHelper = WebhookDiffHelper::create($previous, $current);

        if (
            !$diffHelper->hasDealValueChanged() &&
            !$diffHelper->hasPayBeforeValueChanged()
        ) {
            return;
        }

        $dealValue = Arr::get($current, Pipedrive::DEAL_VALUE);
        $payBeforeValue = Arr::get($current, Pipedrive::PAY_BEFORE_VALUE);

        $newPayAfterValue = $dealValue - $payBeforeValue;

        UpdatePayAfterValue::run(
            $dealId,
            $newPayAfterValue
        );
    }
}
