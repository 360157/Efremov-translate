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
            'langs' => $this->getLangs($request->isActive)
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
        $response = $this->postLang($request->name, $request->index);

        if ($response->wasRecentlyCreated) {
            return redirect()->route('translate.langs.index')->withSuccess('The language has created!');
        } else {
            return redirect()->route('translate.langs.index')->withError('The language is already exists!');
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
        return redirect()->route('translate.langs.index');
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

        return redirect()->route('translate.langs.index')->withSuccess('Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->deleteLang($id);

        if ($response['status'] === 'success') {
            return redirect()->route('translate.langs.index')->withSuccess($response['message']);
        } else {
            return redirect()->route('translate.langs.index')->withError($response['message']);
        }
    }
}
