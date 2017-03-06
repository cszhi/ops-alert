<?php

namespace App\Http\Controllers\Alert;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Log;
use Carbon\Carbon;

class LogController extends Controller
{
    public $module = 'alert.log';
    public $parent_module = 'alert';

    public function index(Request $request)
    {
        if($request->has('starttime'))
        {
            $starttime = $request->get('starttime');
            $stime = Carbon::parse($starttime);
        }
        else
        {
            $starttime='';
            $stime='';
        }
        if($request->has('endtime'))
        {
            $endtime = $request->get('endtime');
            $etime = Carbon::parse($endtime)->addDays(1);
        }
        else
        {
            $endtime='';
            $etime='';
        }

        $ip = $request->get('ip');
        $content = $request->get('content');

        $items = Log::with('group')->where(function($query) use ($ip)
        {
            if($ip)
            {
                if(filter_var($ip, FILTER_VALIDATE_IP))
                {
                    $query->where('ip', $ip);
                }
                else
                {
                    $query->where('hostname', $ip);
                }
            }
        })
        ->where(function($query) use ($content)
        {
            if($content)
            {
                $query->where('content', 'like', '%'.$content.'%');
            }
        })
        ->where(function($query) use ($stime)
        {
            if($stime)
            {
                $query->where('created_at', '>=', $stime);
            }
        })
        ->where(function($query) use ($etime)
        {
            if($etime)
            {
                $query->where('created_at', '<=', $etime);
            }
        })
        ->orderBy('created_at', 'desc')
        ->Paginate('12');

        return view('alert.log', compact('items'))->with([
            'title' => '报警记录',
            'endtime' => $endtime,
            'starttime' => $starttime,
            'ip' => $ip,
            'content' => $content
        ]);
    }

    public function show($id)
    {
        $log =Log::findOrFail($id);
        $data = $log->toArray();

        $type = $log->group->type;
        if($type == "weixin")
        {
            $data['type'] = "微信";
        }
        elseif($type == "email")
        {
            $data['type'] = "邮件";
        }
        else
        {
            $data['type'] = "微信+邮件";
        }
        
        $data['user'] = implode(',', $log->group->users->lists('name')->toArray());
        $data['name'] = $log->group->name;

        return \Response::json($data);
    }
}
