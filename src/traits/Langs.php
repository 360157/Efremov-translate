<?php
/**
 * Created by PhpStorm.
 * User: ipeople
 * Date: 02.09.19
 * Time: 13:41
 */

namespace Sashaef\TranslateProvider\Traits;

use Sashaef\TranslateProvider\Models\Langs as Model;
use Illuminate\Pagination\Paginator;

trait Langs
{
    use Groups;
    public static $langColumns = [
        'id',
        'index',
        'name',
        'is_active',
        'created_at',
        'updated_at'
    ];

    public function getLangs($select = null)
    {
        switch ($select) {
            case 'yes':
                $isActive = true;
                break;
            case 'no':
                $isActive = false;
                break;
            default:
                $isActive = null;
                break;
        }

        return Model::getLangs($isActive);
    }

    public function filterLangs($request)
    {
        switch ($request->isActive) {
            case 'yes': $request->isActive = true; break;
            case 'no': $request->isActive = false; break;
        }

        $order = [self::$langColumns[$request->order[0]['column'] ?? 0], $request->order[0]['dir'] ?? 'desc'];
        self::setPageByStart($request->start, $request->length);

        return Model::filterLangs([
            'is_active' => $request->isActive,
            'search' => $request->search
        ], $order, $request->length);
    }

    public function getLang($id)
    {
        return Model::find($id);
    }

    public function postLang($name, $index)
    {
        return Model::postLangs($name, $index);
    }

    public function updateLang($id, $index, $name, $isActive)
    {
        $lang = $this->getLang($id);

        if ($lang === null) {return ['status' => 'error', 'message' => 'The language is missing!'];}

        if ($lang->update([
            'name' => $name,
            'index' => $index,
            'is_active' => is_null($isActive) ? 0 : 1
        ])) {
            return ['status' => 'success', 'message' => 'The language has updated!'];
        } else {
            return ['status' => 'error', 'message' => 'Server error!'];
        }
    }

    public function deleteLang($id)
    {
        $lang = $this->getLang($id);

        if ($lang === null) {return ['status' => 'error', 'message' => 'The language is missing!'];}

        if ($lang->transData->isNotEmpty()) {return ['status' => 'error', 'message' => 'The language has translations!'];}

        if ($lang->delete()) {
            return ['status' => 'success', 'message' => 'The language has deleted!'];
        } else {
            return ['status' => 'error', 'message' => 'Server error!'];
        }
    }

    public static function setPageByStart($start, $perPage)
    {
        if ($start === null ) {return;}

        $page = $start / ($perPage ?? (new Model)->getPerPage()) + 1;

        Paginator::currentPageResolver(function() use ($page) {return $page;});
    }
}