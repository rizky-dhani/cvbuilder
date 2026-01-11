<?php

use App\Models\User;
use App\Filament\Pages\Auth\EditProfile;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    Filament::setCurrentPanel(Filament::getPanel('admin'));
});

test('profile page is accessible', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->get(EditProfile::getUrl())
        ->assertSuccessful();
});

test('profile page contains MFA settings', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test(EditProfile::class)
        ->assertSee('Two-factor authentication (2FA)')
        ->assertSee('Email verification codes');
});
