<?php

use App\Models\User;
use App\Models\Certification;
use App\Filament\Resources\Certifications\CertificationResource;
use App\Filament\Resources\Certifications\Pages\ListCertifications;
use App\Filament\Resources\Certifications\Pages\CreateCertification;
use Filament\Actions\DeleteAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('can render certification list page', function () {
    Livewire::test(ListCertifications::class)
        ->assertSuccessful();
});

test('can list only own certifications', function () {
    $ownCertification = Certification::factory()->create(['user_id' => $this->user->id]);
    $otherUser = User::factory()->create();
    $otherCertification = Certification::factory()->create(['user_id' => $otherUser->id]);

    Livewire::test(ListCertifications::class)
        ->assertCanSeeTableRecords([$ownCertification])
        ->assertCanNotSeeTableRecords([$otherCertification]);
});

test('can create certification', function () {
    $newData = Certification::factory()->make();

    Livewire::test(CreateCertification::class)
        ->set('data.name', $newData->name)
        ->set('data.issuer', $newData->issuer)
        ->set('data.issue_date', $newData->issue_date->format('Y-m-d'))
        ->set('data.expiry_date', $newData->expiry_date?->format('Y-m-d'))
        ->set('data.url', $newData->url)
        ->call('create')
        ->assertHasNoFormErrors()
        ->assertNotified('Certification successfully created');

    $this->assertDatabaseHas('certifications', [
        'user_id' => $this->user->id,
        'name' => $newData->name,
    ]);
});

test('can delete certification', function () {
    $certification = Certification::factory()->create(['user_id' => $this->user->id]);

    Livewire::test(ListCertifications::class)
        ->callTableAction(DeleteAction::class, $certification)
        ->assertNotified('Certification successfully deleted');

    $this->assertModelMissing($certification);
});
