<?php

namespace App\Filament\Resources\WorkExperiences\Pages;

use App\Filament\Resources\WorkExperiences\WorkExperienceResource;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditWorkExperience extends EditRecord
{
    protected static string $resource = WorkExperienceResource::class;

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Work experience updated!')
            ->body(auth()->user()->name . ', your changes to the work experience at ' . $this->record->company . ' have been saved successfully.');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->successNotification(
                    fn (Notification $notification, $record): Notification => $notification
                        ->title('Work experience removed')
                        ->body('The work experience at ' . $record->company . ' has been removed, ' . auth()->user()->name . '.'),
                ),
        ];
    }
}
