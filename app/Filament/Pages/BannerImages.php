<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use Filament\Forms\Components\FileUpload;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Schema;

class BannerImages extends SettingsPage
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    protected static string|\UnitEnum|null $navigationGroup = 'Admin';

    protected static ?string $navigationLabel = 'Banner Images';

    protected static ?string $title = 'Banner Images';

    protected static ?int $navigationSort = 4;

    protected static string $settings = GeneralSettings::class;

    public function form(Schema $schema): Schema
    {
        return $schema->schema([
            FileUpload::make('home_banner_images')
                ->label('Home Banner Images')
                ->helperText('Upload one or more images. Multiple images show as a slider on the home page.')
                ->image()
                ->multiple()
                ->reorderable()
                ->appendFiles()
                ->disk('public')
                ->directory('banners/home')
                ->visibility('public')
                ->imagePreviewHeight('120')
                ->panelLayout('grid'),

            FileUpload::make('about_banner_images')
                ->label('About Banner Images')
                ->helperText('Upload one or more images. Multiple images show as a slider on the about page.')
                ->image()
                ->multiple()
                ->reorderable()
                ->appendFiles()
                ->disk('public')
                ->directory('banners/about')
                ->visibility('public')
                ->imagePreviewHeight('120')
                ->panelLayout('grid'),
        ]);
    }
}
