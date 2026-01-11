<?php

use App\Models\User;
use App\Models\Education;
use App\Filament\Resources\Education\EducationResource;
use App\Filament\Resources\Education\Pages\ListEducation;
use App\Filament\Resources\Education\Pages\CreateEducation;
use Filament\Actions\DeleteAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('can render education list page', function () {
    Livewire::test(ListEducation::class)
        ->assertSuccessful();
});

test('can list only own education records', function () {
    $ownEducation = Education::factory()->create(['user_id' => $this->user->id]);
    $otherUser = User::factory()->create();
    $otherEducation = Education::factory()->create(['user_id' => $otherUser->id]);

    Livewire::test(ListEducation::class)
        ->assertCanSeeTableRecords([$ownEducation])
        ->assertCanNotSeeTableRecords([$otherEducation]);
});

test('can create education record', function () {
    $newData = Education::factory()->make();

    Livewire::test(CreateEducation::class)
        ->set('data.institution', $newData->institution)
        ->set('data.degree', $newData->degree)
        ->set('data.field_of_study', $newData->field_of_study)
        ->set('data.start_date', $newData->start_date->format('Y-m-d'))
        ->set('data.end_date', $newData->end_date?->format('Y-m-d'))
        ->set('data.description', $newData->description)
        ->call('create')
        ->assertHasNoFormErrors()
        ->assertNotified('Education successfully created');

    $this->assertDatabaseHas('education', [
        'user_id' => $this->user->id,
        'institution' => $newData->institution,
        'degree' => $newData->degree,
    ]);
});

test('can delete education record', function () {
    $education = Education::factory()->create(['user_id' => $this->user->id]);

    Livewire::test(ListEducation::class)
        ->callTableAction(DeleteAction::class, $education)
        ->assertNotified('Education successfully deleted');

    $this->assertModelMissing($education);
});
