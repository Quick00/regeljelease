<?php

namespace App\Domain\Pipedrive\Actions;

use App\Domain\Pipedrive\Pipedrive;
use App\Domain\Pipedrive\Trait\PipedriveRequestTrait;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdatePayAfterValue
{
    use AsAction;
    use PipedriveRequestTrait;

    public function handle(int $dealId, int $newPayAfterValue): void
    {
        $this->putRequest(sprintf('deals/%d', $dealId), [
            Pipedrive::PAY_AFTER_VALUE => $newPayAfterValue,
        ]);
    }
}
