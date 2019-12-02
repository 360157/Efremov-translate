<?php

namespace Sashaef\TranslateProvider\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Sashaef\TranslateProvider\Traits\Groups;
use App\Http\Controllers\Controller;
use Sashaef\TranslateProvider\Requests\GroupsStoreRequest;
use Sashaef\TranslateProvider\Resources\GroupCollection;

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
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param string $type
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function get(Request $request)
    {
        if (empty($request->type)) {$request->type = 'interface';}

        $groups = $this->filterGroups($request);

        return new GroupCollection($groups);
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
        $response = $this->storeGroup($request->name, $request->type);

        if ($response->wasRecentlyCreated) {
            return response()->json(['status' => 'success', 'message' => 'The group has created!'], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => 'The group is already exists!'], 200);
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $response = $this->deleteGroup($request->id, $request->trans);

        return response()->json($response, 200);
    }
}
