<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {

        $this->migrator->add('general.global_discount', 90);
        $this->migrator->add('general.min_order_value', 2000);
        $this->migrator->add('general.starting_year', 2026);
        $this->migrator->add('general.company_name', 'ManirajCrackers');
        $this->migrator->add('general.company_address', '4/320, Sivakasi to  kazhugumalai main road naduvappatti. 627713 ');
        $this->migrator->add('general.mobile_number_1', 9976739559);
        $this->migrator->add('general.mobile_number_2', 8248128425);
        
    }
};
