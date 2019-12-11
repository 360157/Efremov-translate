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
        $translates = [
            'system::main.translation' => [
                'en' => 'translation',
                'uk' => 'переклад',
                'ru' => 'перевод',
            ],
            'system::main.langs' => [
                'en' => 'languages',
                'uk' => 'мови',
                'ru' => 'языки',
            ],
            'system::main.interface-trans' => [
                'en' => 'interface translations',
                'uk' => 'інтерфейсні переклади',
                'ru' => 'интерфейсные переводы',
            ],
            'system::main.system-trans' => [
                'en' => 'system translations',
                'uk' => 'системні переклади',
                'ru' => 'системные переводы',
            ],
            'system::main.main_page' => [
                'en' => 'system translations',
                'uk' => 'системні переклади',
                'ru' => 'системные переводы',
            ],
            'system::main.group' => [
                'en' => 'group',
                'uk' => 'група',
                'ru' => 'група',
            ],
        ];

        foreach ($translates as $key => $translate) {
            dd($translates);
        }
    }
}
