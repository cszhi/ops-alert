<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    public $module = 'admin.config';
    public $parent_module = 'admin';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function config()
    {
        $data = [
            "fromname" => config('mail.from.name'),
            "from" => config('mail.from.address'),
            "host" => config('mail.host'),
            "username" => config('mail.username'),
            "password" => config('mail.password'),
            "corpid" => config('weixin.corpid'),
            "corpsecret" => config('weixin.corpsecret'),
            "agentid" => config('weixin.agentid'),
        ];
        return  view('admin.config', compact('data'))->with([
            'title' => "配置",
            'email' => "active"
        ]);
        
    }

    public function configupdate(requests\ConfigUpdateFormRequest $request)
    {
        $data = [
            "MAIL_HOST" => $request->get('host'),
            "MAIL_USERNAME" => $request->get('email'),
            "MAIL_FROM_ADDRESS" => $request->get('email'),
            "MAIL_PASSWORD" => $request->get('password'),
            "MAIL_FROM_NAME" => $request->get('fromname')
        ];

        modifyEnv($data);

        return back()->with([
            "email" => 'active',
            'status' => "修改邮箱配置成功！"
        ]);
    }

    public function config2update(requests\Config2UpdateFormRequest $request)
    {
        $data = [
            "WEIXIN_CORPID" => $request->get('corpid'),
            "WEIXIN_CORPSECRET" => $request->get('corpsecret'),
            "WEIXIN_AGENTID" => $request->get('agentid')
        ];

        modifyEnv($data);
        return back()->with([
            "weixin" => 'active',
            'status' => "修改微信配置成功"
        ]);
    }

}
