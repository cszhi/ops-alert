<?php

namespace App\Http\Controllers\Alert;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Auser;
use App\Models\Group;

class GroupController extends Controller
{
    public $module = 'alert.group';
    public $parent_module = 'alert';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Auser::lists('name', 'id');
        $items = Group::with('users')->get();
        return view('alert.group', compact('items', 'users'))->with([
            'title' => '报警分组'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(requests\GroupCreateFormRequest $request)
    {
        $data = $request->except('_token', 'users');
        $data['token'] = str_random(16);
        if(Group::where('token', $data['token'])->get())
        {
            $data['token'] = str_random(16);
        }
        $group = Group::create($data);
        $group->users()->sync($request->get('users'));
        return back()->with('status', "添加分组 $group->name 成功");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(requests\GroupEditFormRequest $request, $id)
    {
        $group = Group::findOrFail($id);
        $group->name = $request->get('name');
        $group->type = $request->get('type');
        // $group->token = $request->get('token');
        $group->save();
        $group->users()->sync($request->get('users'));
        return back()->with('status', "修改分组 $group->name 成功");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        $group->delete();
        $group->users()->sync([], true);
        return back()->with([
            'status' => "删除分组 $group->name 成功！"
        ]);
    }
}
