<?php

use App\Models\User;
use App\Models\WorkExperience;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

test('work experience belongs to a user', function () {
    $user = User::factory()->create();
    $workExperience = WorkExperience::factory()->create(['user_id' => $user->id]);

    expect($workExperience->user)->toBeInstanceOf(User::class);
    expect($workExperience->user->id)->toBe($user->id);
});

test('work experience has fillable attributes', function () {
    $workExperience = new WorkExperience();
    $fillable = [
        'user_id',
        'company',
        'position',
        'location',
        'start_date',
        'end_date',
        'is_current',
        'description',
    ];

    expect($workExperience->getFillable())->toEqual($fillable);
});

test('work experience casts dates and boolean', function () {
    $workExperience = new WorkExperience();
    
    expect($workExperience->getCasts())->toHaveKeys([
        'start_date',
        'end_date',
        'is_current',
    ]);
    
    expect($workExperience->getCasts()['start_date'])->toBe('date');
    expect($workExperience->getCasts()['end_date'])->toBe('date');
    expect($workExperience->getCasts()['is_current'])->toBe('boolean');
});
