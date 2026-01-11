<?php

use App\Models\User;
use App\Models\WorkExperience;
use App\Filament\Resources\WorkExperiences\WorkExperienceResource;
use App\Filament\Resources\WorkExperiences\Pages\ListWorkExperiences;
use App\Filament\Resources\WorkExperiences\Pages\CreateWorkExperience;
use Filament\Actions\DeleteAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('can render work experience list page', function () {
    Livewire::test(ListWorkExperiences::class)
        ->assertSuccessful();
});

test('can list only own work experiences', function () {
    $ownWorkExperience = WorkExperience::factory()->create(['user_id' => $this->user->id]);
    $otherUser = User::factory()->create();
    $otherWorkExperience = WorkExperience::factory()->create(['user_id' => $otherUser->id]);

    Livewire::test(ListWorkExperiences::class)
        ->assertCanSeeTableRecords([$ownWorkExperience])
        ->assertCanNotSeeTableRecords([$otherWorkExperience]);
});

test('can create work experience', function () {
    $newData = WorkExperience::factory()->make();

    Livewire::test(CreateWorkExperience::class)
        ->set('data.company', $newData->company)
        ->set('data.position', $newData->position)
        ->set('data.location', $newData->location)
        ->set('data.start_date', $newData->start_date->format('Y-m-d'))
        ->set('data.end_date', $newData->end_date?->format('Y-m-d'))
        ->set('data.is_current', $newData->is_current)
        ->set('data.description', $newData->description)
        ->call('create')
        ->assertHasNoFormErrors()
        ->assertNotified('Work experience successfully created')
        ->assertRedirect(WorkExperienceResource::getUrl('index'));

    $this->assertDatabaseHas(WorkExperience::class, [
        'user_id' => $this->user->id,
        'company' => $newData->company,
        'position' => $newData->position,
    ]);
});

test('can delete work experience', function () {
    $workExperience = WorkExperience::factory()->create(['user_id' => $this->user->id]);

    Livewire::test(ListWorkExperiences::class)
        ->callTableAction(DeleteAction::class, $workExperience)
        ->assertNotified('Work experience successfully deleted');

    $this->assertModelMissing($workExperience);
});