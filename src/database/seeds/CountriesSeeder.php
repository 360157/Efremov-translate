<?php
namespace Sashaef\TranslateProvider\Database\Seeder;

use Illuminate\Database\Seeder;
use Sashaef\TranslateProvider\Traits\CountriesTrait;

class CountriesSeeder extends Seeder
{
    use CountriesTrait;

    private $langsIds;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $countries = include_once (__DIR__ . '/../data/countries.php');

        foreach ($countries as $code => $name) {

            self::postLang($code, $name);
        }
    }
}
