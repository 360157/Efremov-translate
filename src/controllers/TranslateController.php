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

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return view('vocabulare::pages.trans.index', [
            'group_id' => $request->id,
            'type' => $request->type,
            'langs' => $this->getLangs()
        ]);
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
        if ($this->storeTranslation($request->type, $request->group_id, $request->key, $request->translates, $request->statuses)) {
            return response()->json([
                'status' => 'success',
                'message' => 'The translation has created!'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'The key is already exists!'
            ], 200);
        }

        return redirect()->back()->withSuccess('Done!');
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
            if (self::updateKey($request->id, $request->value)) {
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
