<?php

namespace Sashaef\TranslateProvider\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sashaef\TranslateProvider\Traits\Langs;
use Sashaef\TranslateProvider\Requests\LangCreateRequest;
use Sashaef\TranslateProvider\Requests\LangUpdateRequest;

class LangsController extends Controller
{
    use Langs;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('vocabulare::pages.langs.index', [
            'langs' => $this->getLangs($request->select)
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
    public function store(LangCreateRequest $request)
    {
        $this->postLang($request->name, $request->index);
        return redirect()->route('langs.index')->withSuccess('Done!');
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LangUpdateRequest $request, $id)
    {
        $this->updateLang(
            $request->id,
            $request->index,
            $request->name,
            $request->is_active
        );
        return redirect()->route('langs.index')->withSuccess('Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->deleteLang($id);
        return redirect()->route('langs.index')->withSuccess('Deleted!');
    }
}
