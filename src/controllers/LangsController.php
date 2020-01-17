<?php

namespace Sashaef\TranslateProvider\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sashaef\TranslateProvider\Traits\LangsTrait;
use Sashaef\TranslateProvider\Requests\LangCreateRequest;
use Sashaef\TranslateProvider\Requests\LangUpdateRequest;
use Sashaef\TranslateProvider\Resources\LangCollection;

class LangsController extends Controller
{
    use LangsTrait;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('translate::pages.langs.index', [
            'title' => trans('main.languages')
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
        $langs = self::filterLangs($request);

        return new LangCollection($langs);
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
    public function store(LangCreateRequest $request)
    {
        $response = self::postLang($request->name, $request->index, $request->flag);

        if ($response->wasRecentlyCreated) {
            return response()->json(['status' => 'success', 'message' => 'The language has created!'], 200);
        } else {
            return response()->json(['status' => 'danger', 'message' => 'The language is already exists!'], 200);
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
        return redirect()->route('translate.langs.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LangUpdateRequest $request)
    {
        $response = self::updateLang(
            $request->id,
            $request->index,
            $request->name,
            $request->flag,
            $request->is_active,
            $request->is_default
        );

        if ($response) {
            return response()->json(['status' => 'success', 'message' => 'The language has updated!'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Server error!'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $response = self::deleteLang($request->id);

        return response()->json($response, 200);
    }
}
