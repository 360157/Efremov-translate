<?php

namespace Sashaef\TranslateProvider\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Sashaef\TranslateProvider\Requests\{GroupsStoreRequest, GroupsImportRequest};
use Sashaef\TranslateProvider\Models\Groups;
use Sashaef\TranslateProvider\Models\Trans;
use Sashaef\TranslateProvider\Resources\GroupCollection;
use Sashaef\TranslateProvider\Traits\{GroupsTrait, TranslationsTrait};

class GroupsController extends Controller
{
    use GroupsTrait, TranslationsTrait;

    /**
     * Display a listing of the resource.
     *
     * @param string $type
     * @return View
     */
    public function index($type = 'interface')
    {
        return view('translate::pages.groups.index', [
            'type' => $type,
            'title' => trans('main.groups')
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param string $type
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function get(Request $request)
    {
        if (empty($request->type)) {$request->type = 'interface';}

        $groups = self::filterGroups($request);

        return new GroupCollection($groups);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupsStoreRequest $request)
    {
        $response = self::storeGroup($request->name, $request->type);

        if ($response->wasRecentlyCreated) {
            return response()->json(['status' => 'success', 'message' => 'The group has created!'], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => 'The group is already exists!'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function import(Request $request)
    {
        return response()->json(['status' => 'success', 'items' => self::getTranslateFilesByType($request->type)], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function parse(GroupsImportRequest $request)
    {
        $response = self::parseTranslateFiles($request->group, $request->type);

        if (!empty($response['done'])) {
            return [
                'status' => 'success',
                'message' => 'The groups ['.implode(', ', $response['done']).'] has imported! '
                    .(!empty($response['not_done']) ? 'The groups ['.implode(', ', $response['not_done']).'] has not imported: ' : '')
            ];
        } else {
            return ['status' => 'error', 'message' => 'The groups has not imported!'];
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function export()
    {
        $groups = Groups::where('type', 'interface')->get();

        $arr = [];
        foreach ($groups as $group) {
            $keys = Trans::where('group_id', $group->id)->get();

            foreach ($keys as $key) {
                $keyArr = explode('.', $key->key);

                if (count($keyArr) === 1) {
                    $arr[$group->name][$keyArr[0]] = $key->data()->where('lang_id', 1)->first()->translation;
                }

                if (count($keyArr) === 2) {
                    $arr[$group->name][$keyArr[0]][$keyArr[1]] = $key->data()->where('lang_id', 1)->first()->translation;
                }

                if (count($keyArr) === 3) {
                    $arr[$group->name][$keyArr[0]][$keyArr[1]][$keyArr[2]] = $key->data()->where('lang_id', 1)->first()->translation;
                }

                if (count($keyArr) === 4) {
                    $arr[$group->name][$keyArr[0]][$keyArr[1]][$keyArr[2]][$keyArr[3]] = $key->data()->where('lang_id', 1)->first()->translation;
                }
            }
        }

        return response()->json($arr, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $response = self::deleteGroup($request->id, $request->trans);

        return response()->json($response, 200);
    }
}
