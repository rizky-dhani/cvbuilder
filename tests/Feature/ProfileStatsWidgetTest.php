<?php

use App\Models\User;
use App\Models\WorkExperience;
use App\Models\Education;
use App\Models\Skill;
use App\Models\Certification;
use App\Filament\Widgets\ProfileStats;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('dashboard profile stats widget displays correct counts', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    WorkExperience::factory()->count(3)->create(['user_id' => $user->id]);
    Education::factory()->count(2)->create(['user_id' => $user->id]);
    Skill::factory()->count(5)->create(['user_id' => $user->id]);
    Certification::factory()->count(1)->create(['user_id' => $user->id]);

    Livewire::test(ProfileStats::class)
        ->assertSee('3')
        ->assertSee('2')
        ->assertSee('5')
        ->assertSee('1');
});
