<?php
namespace Sashaef\TranslateProvider\Database\Seeder;

use Illuminate\Database\Seeder;
use Sashaef\TranslateProvider\Traits\{Groups, Translations};
use Sashaef\TranslateProvider\Models\Langs;

class DatabaseSeeder extends Seeder
{
    use Groups, Translations;

    private $langsIds;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $translates = [
             [
                'key' => 'system::main.translation',
                'description' => null,
                 'translates' => [
                     'en' => 'translation',
                     'uk' => 'переклад',
                     'ru' => 'перевод',
                 ]
            ],
            [
                'key' => 'system::main.langs',
                'description' => null,
                'translates' => [
                    'en' => 'languages',
                    'uk' => 'мови',
                    'ru' => 'языки',
                ]
            ],
            [
                'key' => 'system::main.interface-trans',
                'description' => null,
                'translates' => [
                    'en' => 'interface translations',
                    'uk' => 'інтерфейсні переклади',
                    'ru' => 'интерфейсные переводы',
                ]
            ],
            [
                'key' => 'system::main.system-trans',
                'description' => null,
                'translates' => [
                    'en' => 'system translations',
                    'uk' => 'системні переклади',
                    'ru' => 'системные переводы',
                ]
            ],
            [
                'key' => 'system::main.main_page',
                'description' => null,
                'translates' => [
                    'en' => 'main page',
                    'uk' => 'головна сторінка',
                    'ru' => 'главная страница',
                ]
            ],
            [
                'key' => 'system::main.group',
                'description' => null,
                'translates' => [
                    'en' => 'group',
                    'uk' => 'група',
                    'ru' => 'група',
                ]
            ],
            [
                'key' => 'system::main.id',
                'description' => null,
                'translates' => [
                    'en' => 'ID',
                    'uk' => 'ІД',
                    'ru' => 'ИД',
                ]
            ],
            [
                'key' => 'system::main.trans',
                'description' => null,
                'translates' => [
                    'en' => 'translated',
                    'uk' => 'перекладено',
                    'ru' => 'переведены',
                ]
            ],
            [
                'key' => 'system::main.not_trans',
                'description' => null,
                'translates' => [
                    'en' => 'not translated',
                    'uk' => 'не перекладено',
                    'ru' => 'не перекладено',
                ]
            ],
            [
                'key' => 'system::main.actions',
                'description' => null,
                'translates' => [
                    'en' => 'actions',
                    'uk' => 'дії',
                    'ru' => 'действия',
                ]
            ],
            [
                'key' => 'system::main.create',
                'description' => null,
                'translates' => [
                    'en' => 'create',
                    'uk' => 'створити',
                    'ru' => 'создать',
                ]
            ],
            [
                'key' => 'system::main.update',
                'description' => null,
                'translates' => [
                    'en' => 'update',
                    'uk' => 'оновити',
                    'ru' => 'обновить',
                ]
            ],
            [
                'key' => 'system::main.edit',
                'description' => null,
                'translates' => [
                    'en' => 'edit',
                    'uk' => 'редагувати',
                    'ru' => 'редактировать',
                ]
            ],
            [
                'key' => 'system::main.save',
                'description' => null,
                'translates' => [
                    'en' => 'save',
                    'uk' => 'зберегти',
                    'ru' => 'сохранить',
                ]
            ],
            [
                'key' => 'system::main.search',
                'description' => null,
                'translates' => [
                    'en' => 'search',
                    'uk' => 'пошук',
                    'ru' => 'поиск',
                ]
            ],
            [
                'key' => 'system::main.delete',
                'description' => null,
                'translates' => [
                    'en' => 'delete',
                    'uk' => 'видалити',
                    'ru' => 'удалить',
                ]
            ],
            [
                'key' => 'system::main.cancel',
                'description' => null,
                'translates' => [
                    'en' => 'cancel',
                    'uk' => 'скасувати',
                    'ru' => 'отменить',
                ]
            ],
            [
                'key' => 'system::main.index',
                'description' => null,
                'translates' => [
                    'en' => 'index',
                    'uk' => 'індекс',
                    'ru' => 'индекс',
                ]
            ],
            [
                'key' => 'system::main.key',
                'description' => null,
                'translates' => [
                    'en' => 'key',
                    'uk' => 'ключ',
                    'ru' => 'ключ',
                ]
            ],
            [
                'key' => 'system::main.name',
                'description' => null,
                'translates' => [
                    'en' => 'name',
                    'uk' => 'назва',
                    'ru' => 'название',
                ]
            ],
            [
                'key' => 'system::main.description',
                'description' => null,
                'translates' => [
                    'en' => 'description',
                    'uk' => 'опис',
                    'ru' => 'описание',
                ]
            ],
            [
                'key' => 'system::main.is_active',
                'description' => null,
                'translates' => [
                    'en' => 'active',
                    'uk' => 'активний',
                    'ru' => 'активен',
                ]
            ],
            [
                'key' => 'system::main.created_at',
                'description' => null,
                'translates' => [
                    'en' => 'created at',
                    'uk' => 'створено',
                    'ru' => 'создано',
                ]
            ],
            [
                'key' => 'system::main.updated_at',
                'description' => null,
                'translates' => [
                    'en' => 'updated at',
                    'uk' => 'оновлено',
                    'ru' => 'обновлено',
                ]
            ],
        ];

        $this->langsIds = $this->getLangIds();
        $statuses = $this->decodeTranslates([
            'en' => 2,
            'uk' => 2,
            'ru' => 2,
        ]);

        foreach ($translates as $translate) {
            $key = $this->decodeKey($translate['key']);
            $group = self::storeGroup('main', $key['type']);
            $translations = $this->decodeTranslates($translate['translates']);

            self::storeTranslation($group->type, $group->id, $key['name'], $translate['description'], $translations, $statuses);
        }
    }

    function decodeKey($key)
    {
        $key = explode('::', $key);
        $arr['type'] = $key[0];
        $key = explode('.', $key[1]);
        $arr['group'] = $key[0];
        $arr['name'] = $key[1];

        return $arr;
    }

    function decodeTranslates($translates)
    {
        $arr = [];
        foreach ($translates as $lang => $translate) {
            if (isset($this->langsIds[$lang])) {
                $arr[$this->langsIds[$lang]] = $translate;
            }
        }

        return $arr;
    }

    function getLangIds()
    {
        return Langs::all()->keyBy('index')->pluck('id', 'index');
    }
}
