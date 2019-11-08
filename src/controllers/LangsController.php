<?php

namespace Sashaef\TranslateProvider\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sashaef\TranslateProvider\Traits\Langs;
use Sashaef\TranslateProvider\Requests\LangCreateRequest;
use Sashaef\TranslateProvider\Requests\LangUpdateRequest;
use Sashaef\TranslateProvider\Resources\LangCollection;

class LangsController extends Controller
{
    use Langs;
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('vocabulare::pages.langs.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function get(Request $request)
    {
        $langs = $this->filterLangs($request);

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
        $response = $this->postLang($request->name, $request->index);

        if ($response->wasRecentlyCreated) {
            return response()->json(['status' => 'success', 'message' => 'The language has created!'], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => 'The language is already exists!'], 200);
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
        $response = $this->updateLang(
            $request->id,
            $request->index,
            $request->name,
            $request->is_active
        );

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $response = $this->deleteLang($request->id);

        return response()->json($response, 200);
    }
}
