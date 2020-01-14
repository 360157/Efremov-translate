<?php
namespace Sashaef\TranslateProvider\Database\Seeder;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            LangsSeeder::class,
            TransSeeder::class,
        ]);
    }
}
