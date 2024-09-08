<?php

namespace App\Domain\Pipedrive;

class Pipedrive
{
    public const DEAL_VALUE = 'value';
    public const PAY_BEFORE_VALUE = 'abe5e7a3b992b7c3ff539cab747e65e5cd7ea4da';
    public const PAY_AFTER_VALUE = '210171ff329a4d3e90f48653eb7b1f4c813538ca';
    public const DEAL_STAGE_ID = 'stage_id';

    public const NOTE_DEAL_ID = 'deal_id';
    public const NOTE_CONTENT = 'content';

    public const STAGE_INCOMING_DEAL = 1;
    public const STAGE_LOW_VALUE = 7;
    public const STAGE_HIGH_VALUE = 8;

    public const STAGE_NAMES = [
        self::STAGE_INCOMING_DEAL => 'Binnenkomende deals',
        self::STAGE_LOW_VALUE => 'Lage waarde',
        self::STAGE_HIGH_VALUE => 'Hoge waarde',
    ];
}
