<?php

namespace Sashaef\TranslateProvider\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sashaef\TranslateProvider\Models\Trans;
use Sashaef\TranslateProvider\Requests\TransStoreRequest;
use Sashaef\TranslateProvider\Traits\Langs as LangTrait;
use Sashaef\TranslateProvider\Traits\Translations;
use Sashaef\TranslateProvider\Resources\TransResource;

class TranslateController extends Controller
{
    use Translations, LangTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (empty($request->type) || empty($request->id)) {
            return redirect()
                ->route('translate.groups.type', ['type' => 'interface'])
                ->withError('The type or the group is missing!');
        }

        return view('vocabulare::pages.trans.index', [
            'group_id' => $request->id,
            'type' => $request->type,
            'langs' => $this->getLangs(),
            'trans' => $this->getTranslations($request->filter)
       ]);
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
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function list(Request $request)
    {
        $data = $this->getTranslations($request->filter);

        return TransResource::collection($data);
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

            return redirect()
                ->route('translate.translates.index', ['type' => $request->type, 'group_id' => $request->group_id])
                ->withSuccess('The key "'.$request->key.'" has created!');
        } else {
            return redirect()
                ->route('translate.translates.index', ['type' => $request->type, 'group_id' => $request->group_id])
                ->withError('The key "'.$request->key.'" is already exists!');
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

        if ($request->obj === 'translation') {
            if (self::updateTranslation($request->type, $request->group_id, $request->key, $request->lang, $request->all())) {
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
