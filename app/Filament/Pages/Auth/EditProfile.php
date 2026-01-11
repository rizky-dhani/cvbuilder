<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Notifications\Notification;

class EditProfile extends BaseEditProfile
{
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Profile successfully updated');
    }

    protected function getRedirectUrl(): string
    {
        return static::getUrl();
    }
}