<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.home_banner_images', []);
        $this->migrator->add('general.about_banner_images', []);
    }

    public function down(): void
    {
        $this->migrator->delete('general.home_banner_images');
        $this->migrator->delete('general.about_banner_images');
    }
};
