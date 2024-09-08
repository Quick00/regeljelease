<?php

use App\Domain\Webhook\Controllers\ReceiveWebhook;
use Illuminate\Support\Facades\Route;

Route::middleware('signed')->group(function () {
    Route::name('webhook')
        ->post('webhook', ReceiveWebhook::class);
});
