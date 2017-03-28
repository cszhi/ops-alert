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
    //token
    private $corpid, $corpsecret, $token_cache;
    public  $getAccessIdAPI = 'https://qyapi.weixin.qq.com/cgi-bin/gettoken?';
    public  $sendMsgAPI   = 'https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=';
    private static $access_token = NULL;

    public function __construct(Request $request)
    {
        \App::setLocale('en');
        $this->hostname = $request->get('hostname');
        $this->ip = $request->get('ip');
        $this->content = $request->get('content');
        $this->request = $request;

        $this->corpid = config('weixin.corpid');
        $this->corpsecret = config('weixin.corpsecret');
        $this->token_cache = storage_path().DIRECTORY_SEPARATOR."token_cache";
    }

    public function index() 
    {
        return $this->responseNotFound("The token is required.  Example:http://alert.test.com/alert/7uU03a7UhVwi3K23");
    }
   
    public function alert($token) 
    {

        $group = Group::where('token', $token)->first();
        if (!$group) 
        {
            return $this->responseNotFound("token not found: $token");
        }

        $check = $this->checkrequest();
        if($check->fails()){
            return $this->responseNotFound($check->errors());
        }

        $accessToken = $this->getAccessID();
        $sendMsgAPI  = $this->sendMsgAPI.$accessToken;
        switch ($group->type) {
            case "weixin":
                $this->weixin($group, $sendMsgAPI);
                l($this->hostname, $this->ip, $this->content, $token);
                break;

            case "email":
                $this->email($group);
                l($this->hostname, $this->ip, $this->content, $token);
                break;

            case "all":
                $this->weixin($group, $sendMsgAPI);
                $this->email($group);
                l($this->hostname, $this->ip, $this->content, $token);
                break;

            default:
                return $this->responseNotFound("type not found: $group->type");
        }
        return $this->responseSuccess("ok");
    }

    public function checkrequest()
    {
        $rules = ['hostname' => 'required', 'ip' => 'required|ip', 'content' => 'required', ];
        $validator = \Validator::make($this->request->all() , $rules);
        return $validator;
    }

    public function weixin($group, $sendMsgAPI)
    {
        $weixinUsers = implode('|', $group->users()->lists('weixin')->toArray());
        $contents = $this->hostname . "\n" . $this->ip . "\n" . $this->content."\n".$group->id;
        $this->dispatch(new AlertWeixin($sendMsgAPI, $weixinUsers, $contents));
    }

    public function email($group)
    {
        if ($this->request->has('subject')) 
        {
            $subject = $this->request->get('subject')."  -".$group->id;
        } else 
        {
            $subject = "Alert: " . $this->hostname . " " . $this->ip."  -".$group->id;
        }
        // $emailUsers = implode(',', $group->users()->lists('email')->toArray());
        $emailUsers = $group->users()->lists('email')->toArray();
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

    public function responseSuccess($message) 
    {
        return $this->response('success', 200, $message);
    }

    public function getAccessID() 
    {
        $data = array(
            'corpid' => $this->corpid,
            'corpsecret' => $this->corpsecret
        );

        $returns = array();
        $r = array();

        if (file_exists($this->token_cache)) 
        {
            $r = json_decode(file_get_contents($this->token_cache),TRUE);
            if (isset($r['access_token'])) 
            {
                $cTime = isset($r['cTime']) ? $r['cTime'] : 0;
                if ((time()-$cTime) <= 7000 )   $returns = $r;  
            }
        }

        if (empty($returns)) 
        {
            $r = json_decode(self::doGet($this->getAccessIdAPI, $data), TRUE);
            //var_dump($r);
            if (isset($r['access_token'])) 
            {
                $returns = $r;
                $r['cTime'] = time();
                file_put_contents($this->token_cache, json_encode($r));
            }
        }

        if (isset($returns['access_token'])) 
        {
            if (static::$access_token === NULL) 
                return static::$access_token = $returns['access_token'];
            return static::$access_token;
        }

        echo isset($r['errmsg']) ? $r['errmsg'] : 'My Error!';
        exit;
    }

    private static function doGet($url, $data) 
    {
        $p = '';
        if (is_array($data)) {
            $p = http_build_query($data);
        }
        $url = $url.$p;
        //echo $url;

        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
        return $data;
    } 

}
