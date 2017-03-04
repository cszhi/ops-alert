<?php
namespace App;

class Weixin
{
    private $corpid, $corpsecret, $agentid;
    public  $token_cache;// = storage_path().DIRECTORY_SEPARATOR."token_cache";
    
    public function __construct()
    {
        $this->corpid = config('weixin.corpid');
        $this->corpsecret = config('weixin.corpsecret');
        $this->agentid = config('weixin.agentid');
    }

    public  $getAccessIdAPI = 'https://qyapi.weixin.qq.com/cgi-bin/gettoken?';
    public  $sendMsgAPI   = 'https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=';
    private static $access_token = NULL;

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
            var_dump($r);
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

    public function sendMsg($user, $msg) 
    {
        /* if return error
        {
           "errcode": 0,
           "errmsg": "ok",
           "invaliduser": "UserID1",
           "invalidparty":"PartyID1",
           "invalidtag":"TagID1"
        }
        */

        $accessToken = $this->getAccessID();
        $sendMsgAPI  = $this->sendMsgAPI.$accessToken;

        $data = array(
            'touser'   => $user,
            'msgtype' => 'text',
            'agentid' => $this->agentid,
            'text'    => array('content'=>$msg)
        );

        $returns = json_decode(self::doPost($sendMsgAPI, json_encode($data)), TRUE);
        print_r($returns);
        print_r($sendMsgAPI);
        print_r($data);
    }

     /**
     * Post请求
     *
     * @param $url
     * @param $data
     * @return mixed|null
     */
    private static function doPost($url, $data) 
    {
        $p = $data;
        if (is_array($data)) {
            $p = http_build_query($data);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $p);

        $returns = curl_exec($ch);

        curl_close($ch);

        return $returns;
    }


    private static function doGet($url, $data) 
    {
        $p = '';
        if (is_array($data)) {
            $p = http_build_query($data);
        }
        $url = $url.$p;
        echo $url;

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

