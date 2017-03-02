<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Group;
use App\Jobs\AlertWeixin;
use App\Jobs\AlertEmail;

class AlertController extends Controller
{
    private $hostname, $ip, $content, $request;

    public function __construct(Request $request)
    {
        \App::setLocale('en');
        $this->hostname = $request->get('hostname');
        $this->ip = $request->get('ip');
        $this->content = $request->get('content');
        $this->request = $request;
    }

    public function index() 
    {
        return $this->responseNotFound("The token is required.  Example:http://alert.test.com/alert/7uU03a7UhVwi3K23");
    }
   
    public function alert($token) 
    {
        $check = $this->checkrequest();
        if($check->fails()){
            return $this->responseNotFound($check->errors());
        }

        $group = Group::where('token', $token)->first();
        if (!$group) 
        {
            return $this->responseNotFound("token not found: $token");
        }

        switch ($group->type) {
            case "weixin":
                $this->weixin($group);
                l($this->hostname, $this->ip, $this->content, $token);
                break;

            case "email":
                $this->email($group);
                l($this->hostname, $this->ip, $this->content, $token);
                break;

            case "all":
                $this->weixin($group);
                $this->email($group);
                l($this->hostname, $this->ip, $this->content, $token);
                break;

            default:
                return $this->responseNotFound("type not found: $group->type");
        }
    }

    public function checkrequest()
    {
        $rules = ['hostname' => 'required', 'ip' => 'required', 'content' => 'required', ];
        $validator = \Validator::make($this->request->all() , $rules);
        return $validator;
    }

    public function weixin($group)
    {
        $weixinUsers = implode('|', $group->users()->lists('weixin')->toArray());
        $contents = $this->hostname . "\n" . $this->ip . "\n" . $this->content;
        $this->dispatch(new AlertWeixin($weixinUsers, $contents));
    }

    public function email($group)
    {
        if ($this->request->has('subject')) 
        {
            $subject = $this->request->get('subject');
        } else 
        {
            $subject = "Alert: " . $this->hostname . " " . $this->ip;
        }
        $emailUsers = implode(',', $group->users()->lists('email')->toArray());
        $this->dispatch(new AlertEmail($emailUsers, $subject, $this->content));
    }

    public function response($status, $status_code, $message) 
    {
        return \Response::json(['status' => $status, 'status_code' => $status_code, 'data' => $message]);
    }

    public function responseNotFound($message) 
    {
        return $this->response('failed', 404, $message);
    }

}
