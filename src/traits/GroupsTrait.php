<?php
/**
 * Created by PhpStorm.
 * User: ipeople
 * Date: 03.09.19
 * Time: 16:28
 */

namespace Sashaef\TranslateProvider\Traits;

use Sashaef\TranslateProvider\Models\Groups;
use Sashaef\TranslateProvider\Models\Groups as Model;
use Illuminate\Pagination\Paginator;
use Sashaef\TranslateProvider\Models\Langs;
use Log;

trait GroupsTrait
{
    public static $groupColumns = [
        'id',
        'name',
        'type',
        'created_at',
        'updated_at'
    ];

    public function filterGroups($request)
    {
        $order = [self::$groupColumns[$request->order[0]['column'] ?? 0], $request->order[0]['dir'] ?? 'desc'];

        $page = $request->start / $request->length + 1;
        Paginator::currentPageResolver(function() use ($page) {return $page;});

        $groups = Model::filterGroups([
            'type' => $request->type,
            'search' => $request->search
        ], $order, $request->length);

        foreach ($groups as $k => $group) {
            $groups[$k]['trans'] = Model::getTransCount($group['id'], 'active');
            $groups[$k]['not_trans'] = Model::getTransCount($group['id']);
        }

        return $groups;
    }

    public function getGroup($id)
    {
        return Model::find($id);
    }

    public function storeGroup($name, $type)
    {
        return Model::storeGroup($name, $type);
    }

    public function updateGroup($id, $name)
    {
        $group = $this->getGroup($id);

        if ($group === null) {return ['status' => 'error', 'message' => 'The group is missing!'];}

        if ($group->update([
            'name' => $name,
        ])) {
            return ['status' => 'success', 'message' => 'The group has updated!'];
        } else {
            return ['status' => 'error', 'message' => 'Server error!'];
        }
    }

    public function deleteGroup($id, $trans = false)
    {
        $group = $this->getGroup($id);

        if ($group === null) {return ['status' => 'error', 'message' => 'The group is missing!'];}

        if ($trans === false && $group->trans->isNotEmpty()) {return ['status' => 'error', 'message' => 'The group has translations!'];}

        if ($group->delete()) {
            return ['status' => 'success', 'message' => 'The group has deleted!'];
        } else {
            return ['status' => 'error', 'message' => 'Server error!'];
        }
    }

    public function getAllGroups()
    {
        return Model::getAllGroups();
    }

    public function getTranslateFilesByType($type = 'system')
    {
        $dir = app('path.lang');
        $hidden = [];

        if ($type === 'interface') {
            $dir = config('translate.lang_path.interface');
            $hidden = ['index.js', 'icon.png'];
        }

        return $this->getTranslateFiles($type, $dir, $hidden);
    }

    public function getTranslateFiles($type, $dir, $hidden = [])
    {
        $existsGroup = Model::getByType($type)->pluck('name', 'id')->toArray();
        $files = app('files')->allFiles($dir, false);

        $groups = [];
        foreach ($files as $file) {
            $name = $file->getFileName();
            if (in_array($name, $hidden)) {continue;}
            if (($lang = $file->getRelativePath()) === '') {continue;}

            if (!isset($groups[$name])) {
                $groups[$name] = [
                    'lang' => [$lang],
                    'exists' => in_array($file->getBaseName('.'.$file->getExtension()), $existsGroup)
                ];
            } else {
                $groups[$name]['lang'] = array_merge($groups[$name]['lang'], [$lang]);
            }
        }

        return $groups;
    }

    public function parseTranslateFilesByType($groups, $type)
    {
        $dir = app('path.lang');

        if ($type === 'interface') {
            $dir = config('translate.lang_path.interface');
        }

        return $this->parseTranslateFiles($groups, $type, $dir);
    }

    public function parseTranslateFiles($groups, $type, $dir)
    {
        $files = app('files');
        $langs = Langs::getLangs(true);
        $done = [];
        $notDone = [];

        foreach ($groups as $filename => $check) {
            $group = substr($filename, 0, strrpos($filename, "."));
            $group = Model::storeGroup($group, $type);
            $translates = self::loadTranslateFiles($files, $dir, $langs, $filename, $type);

            if ($this->storeTranslations($group, $translates, 2)) {
                $done[] = $group->name;
            } else {
                $notDone[] = $group->name;
            }
        }

        return [
            'done' => $done,
            'not_done' => $notDone
        ];
    }

    public static function loadTranslateFiles($files, $dir, $langs, $filename, $type)
    {
        $translates = [];
        foreach ($langs as $lang) {
            if ($files->exists($path = "{$dir}/{$lang->index}/{$filename}")) {
                if ($type === 'system') {
                    $lines = $files->getRequire($path);
                }

                if ($type === 'interface') {
                    $lines = self::loadLangJsFile($path);
                }

                foreach ($lines as $key => $translation) {
                    $translates[$key][$lang->id] = $translation;
                }
            }
        }

        return $translates;
    }

    public static function loadLangJsFile($path)
    {
        $translates = [];
        if ($handle = fopen($path, "r")) {
            $keys = [];
            while (($line = fgets($handle)) !== false) {
                $line = trim($line);
                if (strpos($line, ': {') !== false) {
                    $keys[] = explode(': {', $line)[0];
                } elseif (strpos($line, '}') !== false) {
                    array_pop($keys);
                } elseif (strpos($line, ': ')) {
                    $prefix = implode('.', $keys);
                    try {
                        if (strpos($line, ": '")) {
                            list($key, $value) = explode(": '", $line);
                        } elseif (strpos($line, ': "')) {
                            list($key, $value) = explode(': "', $line);
                        }

                        $translates[($prefix ? $prefix.'.' : '').$key] = trim($value, '\',');
                    } catch (\Exception $e) {
                        Log::error('Translate: Not parse line: '.$line.' in file '.$path);
                    }
                }
            }
            fclose($handle);
        }

        return $translates;
    }




}
