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

test('can update profile and redirects to profile page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test(EditProfile::class)
        ->set('data.name', 'Updated Name')
        ->set('data.email', 'updated@example.com')
        ->set('data.currentPassword', 'password')
        ->call('save')
        ->assertHasNoFormErrors()
        ->assertNotified('Profile successfully updated')
        ->assertRedirect(EditProfile::getUrl());

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
    ]);
});
