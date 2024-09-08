<?php

namespace App\Domain\Pipedrive\Actions;

use App\Domain\Pipedrive\Pipedrive;
use App\Domain\Pipedrive\Trait\PipedriveRequestTrait;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateDealStageAction
{
    use AsAction;
    use PipedriveRequestTrait;

    public function handle(int $dealId, int $currentStageId, int $dealValue): void
    {
        $newStageId = $this->getNewStageId($dealValue);
        if ($currentStageId === $newStageId) {
            return;
        }

        $this->putRequest(sprintf('deals/%d', $dealId), [
            Pipedrive::DEAL_STAGE_ID => $newStageId
        ]);

        $this->postRequest('notes', [
            Pipedrive::NOTE_DEAL_ID => $dealId,
            Pipedrive::NOTE_CONTENT => sprintf(
                'Deal stage updated from %s to %s',
                Pipedrive::STAGE_NAMES[$currentStageId],
                Pipedrive::STAGE_NAMES[$newStageId]
            )
        ]);
    }

    private function getNewStageId(int $dealValue): int
    {
        if ($dealValue <= 0) {
            return Pipedrive::STAGE_INCOMING_DEAL;
        }

        if ($dealValue < 50) {
            return Pipedrive::STAGE_LOW_VALUE;
        }

        return Pipedrive::STAGE_HIGH_VALUE;
    }
}
