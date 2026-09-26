<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use Filament\Pages\SettingsPage;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;


class Settings extends SettingsPage
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog';

    protected static string|\UnitEnum|null $navigationGroup = 'Admin';

    protected static ?string $navigationLabel = 'Settings';

    protected static ?int $navigationSort = 3;

    protected static string $settings = GeneralSettings::class;

    public function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('global_discount')
            ->label('Global discount ')
            ->required(),

            TextInput::make('min_order_value')
            ->label('Min order value')
            ->required(),

            TextInput::make('starting_year')
            ->label('diwali sales starting year')
            ->required(),

            TextInput::make('company_name')
            ->label('Company Name')
            ->required(),

            TextInput::make('company_address')
            ->label('Company Address')
            ->required(),

            TextInput::make('mobile_number_1')
            ->label('Mobile Number 1')
            ->required(),

            TextInput::make('mobile_number_2')
            ->label('Mobile Number 2')
            ->required(),

            TextInput::make('company_email')
            ->label('Email Address')
            ->email(),

            Textarea::make('marquee_content')
            ->label('Marquee Content')
            ->required()
            ->maxLength(455),

        ]);
    }
}