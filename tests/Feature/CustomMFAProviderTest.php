<?php

use App\Auth\MultiFactor\CustomEmailAuthentication;
use Filament\Facades\Filament;
use Illuminate\Support\Collection;

test('admin panel uses custom email authentication provider', function () {
    $panel = Filament::getPanel('admin');
    $providers = $panel->getMultiFactorAuthenticationProviders();

    expect($providers)->toHaveKey('email_code');
    expect($providers['email_code'])->toBeInstanceOf(CustomEmailAuthentication::class);
});
