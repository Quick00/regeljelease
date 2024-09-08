<?php

namespace App\Console\Commands;

use App\Domain\Pipedrive\Actions\CreateWebhookAction;
use Illuminate\Console\Command;

class SetupWebhook extends Command
{
    protected $signature = 'setup:webhook';

    protected $description = 'This command will setup the webhook for Pipedrive';

    public function handle(): void
    {
        CreateWebhookAction::run($this);
    }
}
