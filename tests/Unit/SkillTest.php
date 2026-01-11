<?php

use App\Models\User;
use App\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

test('skill belongs to a user', function () {
    $user = User::factory()->create();
    $skill = Skill::factory()->create(['user_id' => $user->id]);

    expect($skill->user)->toBeInstanceOf(User::class);
    expect($skill->user->id)->toBe($user->id);
});

test('skill has fillable attributes', function () {
    $skill = new Skill();
    $fillable = [
        'user_id',
        'name',
        'level',
        'category',
    ];

    expect($skill->getFillable())->toEqual($fillable);
});
