<?php

namespace App\Filament\Resources\WorkExperiences\Pages;

use App\Filament\Resources\WorkExperiences\WorkExperienceResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateWorkExperience extends CreateRecord
{
    protected static string $resource = WorkExperienceResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Work experience saved!')
            ->body('Great job, ' . auth()->user()->name . '! Your experience at ' . $this->record->company . ' has been added to your profile.');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
