<?php

namespace Sashaef\TranslateProvider\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sashaef\TranslateProvider\Requests\GetTranslationRequest;
use Sashaef\TranslateProvider\Requests\TransStoreRequest;
use Sashaef\TranslateProvider\Traits\Langs as LangModel;
use Sashaef\TranslateProvider\Models\Langs;
use Sashaef\TranslateProvider\Traits\Translations;

class TranslateController extends Controller
{
    use Translations, LangModel;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GetTranslationRequest $request)
    {
        $data = $this->getTranslations($request->id, $request->type, $request->isFilter);
        return view('vocabulare::pages.trans.translations', [
            'group_id' => $request->id,
            'trans' => $data['trans'],
            'transData' => $data['transData'],
            'langs' => $this->getLangs(),
            'type' => $request->type
        ]);
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
        $this->storeTranslation($request->key, $request->group_id, $request->type);
        return redirect()->back()->withSuccess('Done!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return response()->json($this->getTransByKey($request->keys));
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
    public function update(Request $request, $group_id)
    {
        $this->updateTranslation($request->trans, $group_id, $request->type, $request->isChecked);
        return redirect()->back()->withSuccess('Done!');
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
