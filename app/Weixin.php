<?php
namespace App;

class Weixin
{
    private $agentid;
    
    public function __construct()
    {
        $this->agentid = config('weixin.agentid');
    }
    
    public function sendMsg($sendMsgAPI, $user, $msg) 
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

        //$accessToken = $this->getAccessID();
        //$sendMsgAPI  = $this->sendMsgAPI.$accessToken;

        $data = array(
            'touser'   => $user,
            'msgtype' => 'text',
            'agentid' => $this->agentid,
            'text'    => array('content'=>$msg)
        );

        $returns = json_decode(self::doPost($sendMsgAPI, json_encode($data)), TRUE);
        var_dump("========================================");
        print_r($sendMsgAPI);
        print_r($data);
        print_r($returns);
        print_r("========================================");
        
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

}

