<?php

namespace Sashaef\TranslateProvider\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sashaef\TranslateProvider\Requests\TransStoreRequest;
use Sashaef\TranslateProvider\Traits\{TranslationsTrait, GroupsTrait};
use Sashaef\TranslateProvider\Resources\TransCollection;

class TranslateController extends Controller
{
    use TranslationsTrait, GroupsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (empty($request->type) || empty($request->group)) {
            return redirect()
                ->route('translate.groups.type', ['type' => 'interface'])
                ->withError('The type or the group is missing!');
        }

        return view('translate::pages.trans.index', [
            'type' => $request->type,
            'group' => self::getGroup($request->group),
            'langs' => self::getLangs(true),
            'title' => trans('main.translations')
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function get(Request $request)
    {
        $translations = self::filterTranslates($request);

        return new TransCollection($translations);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
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
    public function store(TransStoreRequest $request)
    {
        if (self::storeTranslation($request->type, $request->group_id, $request->key, $request->description, $request->translates, $request->statuses)) {
            return response()->json(['status' => 'success', 'message' => 'The key "'.$request->key.'" has created!'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'The key "'.$request->key.'" is already exists!'], 200);
        }
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->obj === 'key') {
            if (self::updateKey($request->id, $request->key, $request->description)) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'The key has updated!'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'The key has not updated!'
                ], 200);
            }
        }

        if ($request->obj === 'translate') {
            if (self::updateTranslation($request->key, $request->lang, $request->translation, $request->status)) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'The translation has updated!'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'The translation has not updated!'
                ], 200);
            }
        }
    }

    /**
     * Restart the specified resource from storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function restart(Request $request)
    {
        self::restartTranslationByType([$request->type]);

        return response()->json([
            'status' => 'success',
            'message' => 'The translation has restarted!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (self::deleteKey($request->id)) {
            return response()->json([
                'status' => 'success',
                'message' => 'The key has deleted!'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'The key has not deleted!'
            ], 200);
        }
    }
}
