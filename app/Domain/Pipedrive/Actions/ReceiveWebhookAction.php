<?php

namespace App\Domain\Pipedrive\Actions;

use App\Domain\Pipedrive\Helpers\WebhookDiffHelper;
use App\Domain\Pipedrive\Pipedrive;
use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsAction;

class ReceiveWebhookAction
{
    use AsAction;

    public function handle(array $data): void
    {
        $previous = Arr::get($data, 'previous', []);
        $current = Arr::get($data, 'current', []);

        $meta = Arr::get($data, 'meta', []);
        $dealId = Arr::get($meta, 'id');

        $diffHelper = WebhookDiffHelper::create($previous, $current);

        if (!$diffHelper->hasDealValueChanged() && !$diffHelper->hasPayBeforeValueChanged()) {
            return;
        }

        $dealValue = Arr::get($current, Pipedrive::DEAL_VALUE, 0);
        $payBeforeValue = Arr::get($current, Pipedrive::PAY_BEFORE_VALUE, 0);

        if ($diffHelper->hasDealValueChanged()) {
            UpdateDealStageAction::run(
                $dealId,
                Arr::get($current, Pipedrive::DEAL_STAGE_ID, 0),
                $dealValue
            );
        }

        UpdatePayAfterValue::run(
            $dealId,
            $dealValue,
            $payBeforeValue
        );
    }
}
