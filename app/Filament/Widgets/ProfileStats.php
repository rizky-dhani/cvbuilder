<?php

namespace App\Filament\Widgets;

use App\Models\Certification;
use App\Models\Education;
use App\Models\Skill;
use App\Models\WorkExperience;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProfileStats extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();

        return [
            Stat::make('Work Experiences', WorkExperience::where('user_id', $user->id)->count())
                ->description('Professional history entries')
                ->descriptionIcon('heroicon-m-briefcase'),
            Stat::make('Education', Education::where('user_id', $user->id)->count())
                ->description('Academic history entries')
                ->descriptionIcon('heroicon-m-academic-cap'),
            Stat::make('Skills', Skill::where('user_id', $user->id)->count())
                ->description('Total skills listed')
                ->descriptionIcon('heroicon-m-wrench-screwdriver'),
            Stat::make('Certifications', Certification::where('user_id', $user->id)->count())
                ->description('Professional credentials')
                ->descriptionIcon('heroicon-m-shield-check'),
        ];
    }
}