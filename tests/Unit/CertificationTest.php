<?php

use App\Models\User;
use App\Models\Certification;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

test('certification belongs to a user', function () {
    $user = User::factory()->create();
    $certification = Certification::factory()->create(['user_id' => $user->id]);

    expect($certification->user)->toBeInstanceOf(User::class);
    expect($certification->user->id)->toBe($user->id);
});

test('certification has fillable attributes', function () {
    $certification = new Certification();
    $fillable = [
        'user_id',
        'name',
        'issuer',
        'issue_date',
        'expiry_date',
        'url',
    ];

    expect($certification->getFillable())->toEqual($fillable);
});

test('certification casts dates', function () {
    $certification = new Certification();
    
    expect($certification->getCasts())->toHaveKeys([
        'issue_date',
        'expiry_date',
    ]);
    
    expect($certification->getCasts()['issue_date'])->toBe('date');
    expect($certification->getCasts()['expiry_date'])->toBe('date');
});
