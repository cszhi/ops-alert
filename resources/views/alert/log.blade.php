@extends('_layout.master')
@section('content')

<div class="modal fade" id="alertInfoModal" tabindex="-1" role="dialog" aria-labelledby="alertInfoModalLabel">
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <a type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
      <h4 class="modal-title" id="alertInfoModalLabel">报警详细</h4>
    </div>

    <div class="modal-body" id="alertinfo">
      <table class="table" style="word-break:break-all;word-wrap:break-word;">
        <tr>
          <th style="width:100px">服务器名</th>
          <td id="a_hostname"></td>
        </tr>
        <tr>
          <th>IP地址</th>
          <td id="a_ip"></td>
        </tr>
        <tr>
          <th>报警分组</th>
          <td id="a_name"></td>
        </tr>
        <tr>
          <th>报警方式</th>
          <td id="a_type"></td>
        </tr>
        <tr>
          <th>接收成员</th>
          <td id="a_user"></td>
        </tr>
        <tr>
          <th>报警内容</th>
          <td><pre id="a_content"></pre></td>
        </tr>
        <tr>
          <th>报警时间</th>
          <td id="a_created_at"></td>
        </tr>
      </table>
    </div>

    <div class="modal-footer">
    <form method="get" action="" class="pull-right">
      {!! csrf_field() !!}
      <div class="form-group">
        <div>
          <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        </div>
      </div>
      </form>

    </div>
  </div>
</div>
</div>

<div class="row">

  <div class="col-md-12">

    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">查询</h3>
      </div>
      <form class="form-inline">
        <div class="box-body">
          <div class="form-group">
            <label for="ip">IP:</label>
            <input type="text" class="form-control" name="ip" value="{!! isset($ip) ? $ip : '' !!}">
          </div>

          <div class="form-group">
            <label for="content">&nbsp;&nbsp;报警内容:</label>
            <input type="text" class="form-control" name="content" value="{!! isset($content) ? $content : '' !!}">
          </div>

          <div class="form-group">
            <label for="starttime">&nbsp;&nbsp;开始:</label>
            <input type="text" class="form-control" name="starttime" id="starttime" value="{!! isset($starttime) ? $starttime : '' !!}"> 
          </div>

          <div class="form-group">
            <label for="endtime">&nbsp;&nbsp;结束:</label>
            <input type="text" class="form-control" name="endtime" id="endtime" value="{!! isset($endtime) ? $endtime : '' !!}">
          </div>
          <!-- /.form group -->

          <div class="form-group pull-right">
            <button type="submit" class="btn btn-block btn-primary" >查询</button>
          </div>
          <!-- /.form group -->

        </div>
        <!-- /.box-body -->
      </form>
    </div>
    <!-- /.box -->

    <div class="box box-primary">
      <div class="box-header">
        <h4 class="box-title">总数:{!! $items->total() !!}&nbsp;&nbsp;&nbsp;本页:{!! $items->count() !!}&nbsp;&nbsp;&nbsp;<small>{{-- $starttime --}}  {{-- $endtime --}}</small></h4>
        <div class="box-tools">{!! $items->appends(array('ip'=>"$ip",'content'=>"$content","starttime"=>"$starttime","endtime"=>"$endtime"))->render() !!}</div>
      </div>
      <!-- /.box-header -->
      <div class="box-body no-padding">
        <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th style="width:4%">ID</th>
            <th style="width:12%">服务器名</th>
            <th style="width:12%">IP地址</th>
            {{--
            <th style="width:8%">报警方式</th>
            --}}
            <th style="width:8%">报警分组</th>
            <th>报警内容</th>
            <th style="width:16%">报警时间</th>
            <th style="width:5%">详细</th>
          </tr>
        </thead>
        <tbody>
          @foreach( $items as $item)
          <tr>  
            <td>{!! $item->id !!}</td>
            <td>{!! $item->hostname !!}</td>
            <td>{!! $item->ip !!}</td>
            {{--
            @if($item->item_type == "weixin")
            <td>微信</td>
            @elseif($item->item_type == "email")
            <td>邮件</td>
            @else
            <td>微信+邮件</td>
            @endif
            --}}
            <td>{!! $item->group->name !!}</td>
            <td>{!! str_limit($item->content, $limit = 200, $end = '...') !!}</td>
            <td>{!! $item->created_at !!}</td>
            <td>
              <a data-toggle="modal" data-target="#alertInfoModal" data-id="{!! $item->id !!}" href="#" >查看</a>
            </td>
          </tr>
          @endforeach
        </tbody>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>
@endsection

@section('addon')
@include('shared.datatable')
@include('shared.datetimepicker')
<script>
  $(function(){
    $('#alertInfoModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var id = button.data('id')

      $.ajax({
        type: "get",
        url : '/log/'+id,
        success : function(a){
          $("#a_hostname").text(a.hostname),
          $("#a_ip").text(a.ip),
          $("#a_type").text(a.type),
          $("#a_user").text(a.user),
          $("#a_name").text(a.name),
          $("#a_content").text(a.content),
          $("#a_created_at").text(a.created_at)
        }
      });
    });

	  $('#starttime').datetimepicker({
	    language:  'zh-CN',
	    weekStart: 1,
	    autoclose: 1,
	    todayHighlight: 1,
	    startView: 2,
	    forceParse: 0,
	    //showMeridian: 1,
	    format: 'yyyy-mm-dd',
	    minView: 2,
	    minuteStep: 30
	  });

	  $('#endtime').datetimepicker({
	    language:  'zh-CN',
	    weekStart: 1,
	    autoclose: 1,
	    todayHighlight: 1,
	    startView: 2,
	    forceParse: 0,
	    //showMeridian: 1,
	    format: 'yyyy-mm-dd',
	    minView: 2,
	    minuteStep: 30
	  });
	});

</script>

@endsection
{{--by caishunzhi 2017 --}}