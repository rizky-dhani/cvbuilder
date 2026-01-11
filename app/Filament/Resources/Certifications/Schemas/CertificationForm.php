<?php

namespace App\Filament\Resources\Certifications\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CertificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('issuer')
                    ->required(),
                DatePicker::make('issue_date')
                    ->required(),
                DatePicker::make('expiry_date'),
                TextInput::make('url')
                    ->url()
                    ->default(null),
            ]);
    }
}