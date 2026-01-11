<?php

use App\Models\User;
use App\Auth\MultiFactor\CustomEmailAuthentication;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\OneTimeCodeInput;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('custom mfa provider challenge form includes remember me checkbox', function () {
    $user = User::factory()->create();
    $provider = new CustomEmailAuthentication();
    
    $components = $provider->getChallengeFormComponents($user);
    
    $checkbox = collect($components)->first(fn ($component) => $component instanceof Checkbox);
    
    expect($checkbox)->not->toBeNull();
    expect($checkbox->getLabel())->toBe('Remember this device for 90 days');
    expect($checkbox->getName())->toBe('remember_device');
});
