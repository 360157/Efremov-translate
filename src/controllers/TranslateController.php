<?php

namespace Sashaef\TranslateProvider\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sashaef\TranslateProvider\Requests\TransStoreRequest;
use Sashaef\TranslateProvider\Traits\{LangsTrait as LangTrait, TranslationsTrait, GroupsTrait};
use Sashaef\TranslateProvider\Resources\TransCollection;

class TranslateController extends Controller
{
    use TranslationsTrait, LangTrait, GroupsTrait;

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
            'group' => $this->getGroup($request->group),
            'langs' => $this->getLangs(true),
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
        $translations = $this->filterTranslates($request);

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
        if ($this->storeTranslation($request->type, $request->group_id, $request->key, $request->description, $request->translates, $request->statuses)) {
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
        $response = $this->restartTranslation($request->group);

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
    public function destroy()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'The translation has not deleted!'
        ], 200);
    }
}
