<?php

namespace App\Filament\Resources\Certifications\Pages;

use App\Filament\Resources\Certifications\CertificationResource;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditCertification extends EditRecord
{
    protected static string $resource = CertificationResource::class;

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Certification successfully updated');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->successNotificationTitle('Certification successfully deleted'),
        ];
    }
}