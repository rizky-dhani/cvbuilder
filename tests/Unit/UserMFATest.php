<?php

use App\Models\User;
use Filament\Auth\MultiFactor\Email\Contracts\HasEmailAuthentication;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

test('user model implements has email authentication', function () {
    $user = User::factory()->create();

    expect($user)->toBeInstanceOf(HasEmailAuthentication::class);
    expect(method_exists($user, 'hasEmailAuthentication'))->toBeTrue();
});

test('user has_email_authentication attribute is accessible', function () {
    $user = User::factory()->create(['has_email_authentication' => true]);

    expect($user->has_email_authentication)->toBeTrue();
    expect($user->hasEmailAuthentication())->toBeTrue();
});
