<?php

use App\Models\User;
use App\Models\Skill;
use App\Filament\Resources\Skills\SkillResource;
use App\Filament\Resources\Skills\Pages\ListSkills;
use App\Filament\Resources\Skills\Pages\CreateSkill;
use Filament\Actions\DeleteAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('can render skill list page', function () {
    Livewire::test(ListSkills::class)
        ->assertSuccessful();
});

test('can list only own skills', function () {
    $ownSkill = Skill::factory()->create(['user_id' => $this->user->id]);
    $otherUser = User::factory()->create();
    $otherSkill = Skill::factory()->create(['user_id' => $otherUser->id]);

    Livewire::test(ListSkills::class)
        ->assertCanSeeTableRecords([$ownSkill])
        ->assertCanNotSeeTableRecords([$otherSkill]);
});

test('can create skill', function () {
    $newData = Skill::factory()->make();

    Livewire::test(CreateSkill::class)
        ->set('data.name', $newData->name)
        ->set('data.level', $newData->level)
        ->set('data.category', $newData->category)
        ->call('create')
        ->assertHasNoFormErrors()
        ->assertNotified('Skill successfully created')
        ->assertRedirect(SkillResource::getUrl('index'));

    $this->assertDatabaseHas('skills', [
        'user_id' => $this->user->id,
        'name' => $newData->name,
    ]);
});

test('can delete skill', function () {
    $skill = Skill::factory()->create(['user_id' => $this->user->id]);

    Livewire::test(ListSkills::class)
        ->callTableAction(DeleteAction::class, $skill)
        ->assertNotified('Skill successfully deleted');

    $this->assertModelMissing($skill);
});
