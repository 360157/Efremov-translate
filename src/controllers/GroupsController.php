<?php

namespace Sashaef\TranslateProvider\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Sashaef\TranslateProvider\Traits\Groups;
use App\Http\Controllers\Controller;
use Sashaef\TranslateProvider\Requests\GroupsStoreRequest;

class GroupsController extends Controller
{
    use Groups;
    /**
     * Display a listing of the resource.
     *
     * @param string $type
     * @return View
     */
    public function index($type = 'interface')
    {
        return view('vocabulare::pages.groups.index', [
            'type' => $type,
            'groups' => $this->getGroups($type)
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
    public function store(GroupsStoreRequest $request)
    {
        $this->storeGroup($request->name, $request->type);

        return redirect()
            ->route('translate.groups.type', ['type' => $request->type])
            ->withSuccess('The group has created!');
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
        $this->updateGroup(
            $request->id,
            $request->name
        );

        return redirect()
            ->route('translate.groups.type', ['type' => $request->type])
            ->withSuccess('The group has updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->deleteGroup($id);

        if ($response['status'] === 'success') {
            return redirect()->route('translate.groups.index')->withSuccess($response['message']);
        } else {
            return redirect()->route('translate.groups.index')->withError($response['message']);
        }
    }
}
