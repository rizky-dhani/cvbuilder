<?php

namespace App\Auth\MultiFactor;

use Closure;
use Filament\Auth\MultiFactor\Email\EmailAuthentication;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\OneTimeCodeInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class CustomEmailAuthentication extends EmailAuthentication
{
    public const TRUSTED_DEVICE_COOKIE_PREFIX = 'filament_mfa_trusted_';

    public function isEnabled(Authenticatable $user): bool
    {
        if (! parent::isEnabled($user)) {
            return false;
        }

        if ($this->isDeviceTrusted($user)) {
            return false;
        }

        return true;
    }

    protected function isDeviceTrusted(Authenticatable $user): bool
    {
        $cookieName = self::TRUSTED_DEVICE_COOKIE_PREFIX . md5($user->getAuthIdentifier());
        $cookieValue = Cookie::get($cookieName);

        if (! $cookieValue) {
            return false;
        }

        try {
            $decrypted = Crypt::decrypt($cookieValue);
            return $decrypted === $user->getAuthIdentifier();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getChallengeFormComponents(Authenticatable $user): array
    {
        return [
            OneTimeCodeInput::make('code')
                ->label(__('filament-panels::auth/multi-factor/email/provider.login_form.code.label'))
                ->validationAttribute('code')
                ->belowContent(Action::make('resend')
                    ->label(__('filament-panels::auth/multi-factor/email/provider.login_form.code.actions.resend.label'))
                    ->link()
                    ->action(function () use ($user): void {
                        if (! $this->sendCode($user)) {
                            Notification::make()
                                ->title(__('filament-panels::auth/multi-factor/email/provider.login_form.code.actions.resend.notifications.throttled.title'))
                                ->danger()
                                ->send();

                            return;
                        }

                        Notification::make()
                            ->title(__('filament-panels::auth/multi-factor/email/provider.login_form.code.actions.resend.notifications.resent.title'))
                            ->success()
                            ->send();
                    }))
                ->required()
                ->rule(function (Get $get) use ($user): Closure {
                    return function (string $attribute, $value, Closure $fail) use ($get, $user): void {
                        if ($this->verifyCode($value)) {
                            if ($get('remember_device')) {
                                $this->trustDevice($user);
                            }
                            return;
                        }

                        $fail(__('filament-panels::auth/multi-factor/email/provider.login_form.code.messages.invalid'));
                    };
                }),
            Checkbox::make('remember_device')
                ->label('Remember this device for 90 days'),
        ];
    }

    protected function trustDevice(Authenticatable $user): void
    {
        $cookieName = self::TRUSTED_DEVICE_COOKIE_PREFIX . md5($user->getAuthIdentifier());
        $cookieValue = Crypt::encrypt($user->getAuthIdentifier());

        Cookie::queue($cookieName, $cookieValue, 90 * 24 * 60); // 90 days in minutes
    }
}
