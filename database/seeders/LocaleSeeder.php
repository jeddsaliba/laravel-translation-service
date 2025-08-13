<?php

namespace Database\Seeders;

use App\Models\Locale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Locale::factory()->createMany([
            [
                'code' => 'en',
                'name' => 'English',
                'direction' => 'LTR',
            ],
            [
                'code' => 'es',
                'name' => 'Spanish',
                'direction' => 'LTR',
            ],
            [
                'code' => 'ru',
                'name' => 'Russian',
                'direction' => 'LTR',
            ],
        ]);
    }
}
