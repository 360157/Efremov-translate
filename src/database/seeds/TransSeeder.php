<?php
namespace Sashaef\TranslateProvider\Database\Seeder;

use Illuminate\Database\Seeder;
use Sashaef\TranslateProvider\Traits\{GroupsTrait, TranslationsTrait};
use Sashaef\TranslateProvider\Models\Langs;

class TransSeeder extends Seeder
{
    use GroupsTrait, TranslationsTrait;

    private static $langsIds;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $translates = [
             [
                'key' => 'main.translation',
                'description' => null,
                 'translates' => [
                     'en' => 'translation',
                     'uk' => 'переклад',
                     'ru' => 'перевод',
                 ]
            ],
            [
                'key' => 'main.languages',
                'description' => null,
                'translates' => [
                    'en' => 'languages',
                    'uk' => 'мови',
                    'ru' => 'языки',
                ]
            ],
            [
                'key' => 'main.interface-trans',
                'description' => null,
                'translates' => [
                    'en' => 'interface translations',
                    'uk' => 'інтерфейсні переклади',
                    'ru' => 'интерфейсные переводы',
                ]
            ],
            [
                'key' => 'main.system-trans',
                'description' => null,
                'translates' => [
                    'en' => 'system translations',
                    'uk' => 'системні переклади',
                    'ru' => 'системные переводы',
                ]
            ],
            [
                'key' => 'main.main_page',
                'description' => null,
                'translates' => [
                    'en' => 'main page',
                    'uk' => 'головна сторінка',
                    'ru' => 'главная страница',
                ]
            ],
            [
                'key' => 'main.group',
                'description' => null,
                'translates' => [
                    'en' => 'group',
                    'uk' => 'група',
                    'ru' => 'група',
                ]
            ],
            [
                'key' => 'main.id',
                'description' => null,
                'translates' => [
                    'en' => 'ID',
                    'uk' => 'ІД',
                    'ru' => 'ИД',
                ]
            ],
            [
                'key' => 'main.trans',
                'description' => null,
                'translates' => [
                    'en' => 'translated',
                    'uk' => 'перекладено',
                    'ru' => 'переведены',
                ]
            ],
            [
                'key' => 'main.not_trans',
                'description' => null,
                'translates' => [
                    'en' => 'not translated',
                    'uk' => 'не перекладено',
                    'ru' => 'не перекладено',
                ]
            ],
            [
                'key' => 'main.actions',
                'description' => null,
                'translates' => [
                    'en' => 'actions',
                    'uk' => 'дії',
                    'ru' => 'действия',
                ]
            ],
            [
                'key' => 'main.create',
                'description' => null,
                'translates' => [
                    'en' => 'create',
                    'uk' => 'створити',
                    'ru' => 'создать',
                ]
            ],
            [
                'key' => 'main.update',
                'description' => null,
                'translates' => [
                    'en' => 'update',
                    'uk' => 'оновити',
                    'ru' => 'обновить',
                ]
            ],
            [
                'key' => 'main.edit',
                'description' => null,
                'translates' => [
                    'en' => 'edit',
                    'uk' => 'редагувати',
                    'ru' => 'редактировать',
                ]
            ],
            [
                'key' => 'main.save',
                'description' => null,
                'translates' => [
                    'en' => 'save',
                    'uk' => 'зберегти',
                    'ru' => 'сохранить',
                ]
            ],
            [
                'key' => 'main.search',
                'description' => null,
                'translates' => [
                    'en' => 'search',
                    'uk' => 'пошук',
                    'ru' => 'поиск',
                ]
            ],
            [
                'key' => 'main.delete',
                'description' => null,
                'translates' => [
                    'en' => 'delete',
                    'uk' => 'видалити',
                    'ru' => 'удалить',
                ]
            ],
            [
                'key' => 'main.cancel',
                'description' => null,
                'translates' => [
                    'en' => 'cancel',
                    'uk' => 'скасувати',
                    'ru' => 'отменить',
                ]
            ],
            [
                'key' => 'main.index',
                'description' => null,
                'translates' => [
                    'en' => 'index',
                    'uk' => 'індекс',
                    'ru' => 'индекс',
                ]
            ],
            [
                'key' => 'main.flag',
                'description' => null,
                'translates' => [
                    'en' => 'flag',
                    'uk' => 'прапор',
                    'ru' => 'флаг',
                ]
            ],
            [
                'key' => 'main.key',
                'description' => null,
                'translates' => [
                    'en' => 'key',
                    'uk' => 'ключ',
                    'ru' => 'ключ',
                ]
            ],
            [
                'key' => 'main.name',
                'description' => null,
                'translates' => [
                    'en' => 'name',
                    'uk' => 'назва',
                    'ru' => 'название',
                ]
            ],
            [
                'key' => 'main.description',
                'description' => null,
                'translates' => [
                    'en' => 'description',
                    'uk' => 'опис',
                    'ru' => 'описание',
                ]
            ],
            [
                'key' => 'main.is_active',
                'description' => null,
                'translates' => [
                    'en' => 'active',
                    'uk' => 'активний',
                    'ru' => 'активен',
                ]
            ],
            [
                'key' => 'main.is_default',
                'description' => null,
                'translates' => [
                    'en' => 'default',
                    'uk' => 'за замовчуванням',
                    'ru' => 'по умолчанию',
                ]
            ],
            [
                'key' => 'main.created_at',
                'description' => null,
                'translates' => [
                    'en' => 'created at',
                    'uk' => 'створено',
                    'ru' => 'создано',
                ]
            ],
            [
                'key' => 'main.updated_at',
                'description' => null,
                'translates' => [
                    'en' => 'updated at',
                    'uk' => 'оновлено',
                    'ru' => 'обновлено',
                ]
            ],
            [
                'key' => 'main.restart',
                'description' => null,
                'translates' => [
                    'en' => 'restart',
                    'uk' => 'перезапустити',
                    'ru' => 'перезапустить',
                ]
            ],
            [
                'key' => 'main.verify',
                'description' => null,
                'translates' => [
                    'en' => 'verify',
                    'uk' => 'перевірити',
                    'ru' => 'проверить',
                ]
            ],
            [
                'key' => 'main.import',
                'description' => null,
                'translates' => [
                    'en' => 'import',
                    'uk' => 'імпорт',
                    'ru' => 'импорт',
                ]
            ],
            [
                'key' => 'main.parse',
                'description' => null,
                'translates' => [
                    'en' => 'parse',
                    'uk' => 'розібрати',
                    'ru' => 'разобрать',
                ]
            ],
        ];

        self::$langsIds = self::getLangIds();
        $statuses = self::decodeTranslates([
            'en' => 2,
            'uk' => 2,
            'ru' => 2,
        ]);

        foreach ($translates as $translate) {
            $key = self::decodeKey($translate['key']);
            $group = self::storeGroup('main', $key['type']);
            $translations = self::decodeTranslates($translate['translates']);

            self::storeTranslation($group->type, $group->id, $key['name'], $translate['description'], $translations, $statuses);
        }
    }

    public static function decodeKey($key)
    {
        $key = explode('::', $key);
        if (isset($key[1])) {
            $arr['type'] = $key[0];
            $key = explode('.', $key[1]);
        } else {
            $arr['type'] = 'system';
            $key = explode('.', $key[0]);
        }
        $arr['group'] = $key[0];
        $arr['name'] = $key[1];

        return $arr;
    }

    public static function decodeTranslates($translates)
    {
        $arr = [];
        foreach ($translates as $lang => $translate) {
            if (isset(self::$langsIds[$lang])) {
                $arr[self::$langsIds[$lang]] = $translate;
            }
        }

        return $arr;
    }

    public static function getLangIds()
    {
        return Langs::all()->keyBy('index')->pluck('id', 'index');
    }
}
