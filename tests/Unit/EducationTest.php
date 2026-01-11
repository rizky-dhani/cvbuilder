<?php

use App\Models\User;
use App\Models\Education;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

test('education belongs to a user', function () {
    $user = User::factory()->create();
    $education = Education::factory()->create(['user_id' => $user->id]);

    expect($education->user)->toBeInstanceOf(User::class);
    expect($education->user->id)->toBe($user->id);
});

test('education has fillable attributes', function () {
    $education = new Education();
    $fillable = [
        'user_id',
        'institution',
        'degree',
        'field_of_study',
        'start_date',
        'end_date',
        'description',
    ];

    expect($education->getFillable())->toEqual($fillable);
});

test('education casts dates', function () {
    $education = new Education();
    
    expect($education->getCasts())->toHaveKeys([
        'start_date',
        'end_date',
    ]);
    
    expect($education->getCasts()['start_date'])->toBe('date');
    expect($education->getCasts()['end_date'])->toBe('date');
});
