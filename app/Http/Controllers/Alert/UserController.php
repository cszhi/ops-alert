<?php

namespace App\Http\Controllers\Alert;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Auser;
class UserController extends Controller
{
    public $module = 'alert.user';
    public $parent_module = 'alert';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Auser::all();
        return view('alert.user', compact('items'))->with([
            'title' => '成员管理'
        ]);;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(requests\UserCreateFormRequest $request)
    {
        $data = $request->except('_token');
        $user = Auser::create($data);
        return back()->with('status', "添加成员 $user->name 成功！");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auser::findOrFail($id);
        return \Response::json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(requests\UserEditFormRequest $request, $id)
    {
        $user = Auser::findOrFail($id);
        $user->name = $request->get('name');
        $user->comment = $request->get('comment');
        $user->weixin = $request->get('weixin');
        $user->email = $request->get('email');
        $user->save();
        return back()->with('status', "编辑成员 $user->name 成功！");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auser::findOrFail($id);
        $user->delete();
        $user->groups()->sync([],true);
        return back()->with([
            'status' => "删除成员 $user->name 成功！"
        ]);
    }
}
