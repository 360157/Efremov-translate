<?php

namespace Sashaef\TranslateProvider\Controllers;

use Illuminate\Http\Request;
use Sashaef\TranslateProvider\Traits\Groups;
use App\Http\Controllers\Controller;
use Sashaef\TranslateProvider\Requests\GroupsStoreRequest;

class GroupsController extends Controller
{
    use Groups;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
    public function store(GroupsStoreRequest $request)
    {
        $this->storeGroup($request->name, $request->type);
        $route = ($request->type == 'interface') ? 'groups.mainInterface' : 'groups.mainSystems';
        return redirect()->route($route)->withSuccess('Updated!');
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->deleteGroup($id);
        return redirect()->route('groups.mainInterface')->withSuccess('Updated!');
    }

    public function showInterface()
    {
        return view('vocabulare::pages.trans.vocabulare', [
            'type' => 'interface',
            'groups' => $this->getGroups('interface')
        ]);
    }

    public function showSystem()
    {
        return view('vocabulare::pages.trans.vocabulare', [
            'type' => 'system',
            'groups' => $this->getGroups('system')
        ]);
    }
}
