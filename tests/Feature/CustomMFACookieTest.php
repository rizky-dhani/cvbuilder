<?php

namespace Tests\Feature;

use App\Models\User;
use App\Auth\MultiFactor\CustomEmailAuthentication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

uses(RefreshDatabase::class);

test('trustDevice queues a secure encrypted cookie', function () {
    $user = User::factory()->create();
    $provider = new CustomEmailAuthentication();
    
    $cookieName = CustomEmailAuthentication::TRUSTED_DEVICE_COOKIE_PREFIX . md5($user->getAuthIdentifier());
    
    // We use reflection to call protected methods for testing
    $reflection = new \ReflectionClass($provider);
    $trustDevice = $reflection->getMethod('trustDevice');
    $trustDevice->setAccessible(true);
    
    $trustDevice->invoke($provider, $user);
    
    // Check if cookie is queued
    $queuedCookies = Cookie::getQueuedCookies();
    $found = false;
    foreach ($queuedCookies as $cookie) {
        if ($cookie->getName() === $cookieName) {
            $found = true;
            expect($cookie->getValue())->not->toBeNull();
            expect($cookie->getExpiresTime())->toBeGreaterThan(now()->addDays(89)->timestamp);
            break;
        }
    }
    expect($found)->toBeTrue();
});

test('isDeviceTrusted returns true if valid cookie exists', function () {
    $user = User::factory()->create();
    $provider = new CustomEmailAuthentication();
    
    $cookieName = CustomEmailAuthentication::TRUSTED_DEVICE_COOKIE_PREFIX . md5($user->getAuthIdentifier());
    $cookieValue = Crypt::encrypt($user->getAuthIdentifier());
    
    // Set the cookie in the request
    request()->cookies->add([$cookieName => $cookieValue]);
    
    $reflection = new \ReflectionClass($provider);
    $isDeviceTrusted = $reflection->getMethod('isDeviceTrusted');
    $isDeviceTrusted->setAccessible(true);
    
    expect($isDeviceTrusted->invoke($provider, $user))->toBeTrue();
});

test('isEnabled returns false if device is trusted', function () {
    $user = User::factory()->create(['has_email_authentication' => true]);
    $provider = new CustomEmailAuthentication();
    
    $cookieName = CustomEmailAuthentication::TRUSTED_DEVICE_COOKIE_PREFIX . md5($user->getAuthIdentifier());
    $cookieValue = Crypt::encrypt($user->getAuthIdentifier());
    
    // Simulate trusted device
    request()->cookies->add([$cookieName => $cookieValue]);
    
    // If device is trusted, isEnabled should return false to bypass challenge
    expect($provider->isEnabled($user))->toBeFalse();
});