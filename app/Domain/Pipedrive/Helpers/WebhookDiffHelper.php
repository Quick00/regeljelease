<?php

namespace App\Domain\Pipedrive\Helpers;

use App\Domain\Pipedrive\Pipedrive;
use Illuminate\Support\Arr;

class WebhookDiffHelper
{
    private array $diff;

    public function __construct(array $previous, array $current)
    {
        $diff = [];
        foreach ($current as $key => $value) {
            $previousValue = Arr::get($previous, $key);

            if ($previousValue !== $value) {
                $diff[$key] = $value;
            }
        }

        $this->diff = $diff;
    }

    public static function create(array $previous, array $current): self
    {
        return new self($previous, $current);
    }

    public function hasDealValueChanged(): bool
    {
        return Arr::exists($this->diff, Pipedrive::DEAL_VALUE);
    }

    public function hasPayBeforeValueChanged(): bool
    {
        return Arr::exists($this->diff, Pipedrive::PAY_BEFORE_VALUE);
    }
}
