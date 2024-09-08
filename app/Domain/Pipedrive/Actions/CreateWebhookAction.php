<?php

namespace App\Domain\Pipedrive\Actions;

use App\Domain\Pipedrive\Trait\PipedriveRequestTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\URL;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateWebhookAction
{
    use AsAction;
    use PipedriveRequestTrait;

    public function handle(Command $command): void
    {
        $url = URL::signedRoute('webhook');

        $data = $this->postRequest('webhooks', [
            'subscription_url' => $url,
            'event_action' => '*',
            'event_object' => 'deal',
        ]);

        if ($data->successful()) {
            $command->info('Webhook created successfully');
        } else {
            $command->error('Failed to create webhook');
        }
    }
}
