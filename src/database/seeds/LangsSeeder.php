<?php
namespace Sashaef\TranslateProvider\Database\Seeder;

use Illuminate\Database\Seeder;
use Sashaef\TranslateProvider\Traits\LangsTrait;

class LangsSeeder extends Seeder
{
    use LangsTrait;

    private $langsIds;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $langs = [
             [
                 'index' => 'en',
                 'name' => 'English',
                 'flag' => 'en',
                 'is_active' => true,
             ],
             [
                 'index' => 'uk',
                 'name' => 'Ukrainian',
                 'flag' => 'ua',
                 'is_active' => true,
                 'is_default' => false
             ],
             [
                 'index' => 'ru',
                 'name' => 'Russian',
                 'flag' => 'ru',
                 'is_active' => true
             ],
        ];

        foreach ($langs as $lang) {

            self::postLang($lang['name'], $lang['index'], $lang['flag'], $lang['is_active']);
        }
    }
}
