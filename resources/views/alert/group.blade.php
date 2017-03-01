@extends('_layout.master')
@section('content')

<div class="modal fade" id="userInfoModal" tabindex="-1" role="dialog" aria-labelledby="userInfoModalLabel">
  <div class="modal-dialog modal-ls">
    <div class="modal-content">
      <div class="modal-header">
        <a type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <h4 class="modal-title" id="userInfoModalLabel">成员信息</h4>
      </div>
      <!-- /.modal-header -->

      <div class="modal-body" id="userinfo">
        <table class="table" style="word-break:break-all;word-wrap:break-word;">
          <tr>
            <th style="width:100px">用户名：</th>
            <td id="a_name"></td>
          </tr>
          <tr>
            <th>微信号：</th>
            <td id="a_weixin"></td>
          </tr>
          <tr>
            <th>邮箱：</th>
            <td id="a_email"></td>
          </tr>
          <tr>
            <th>备注</th>
            <td id="a_comment"></td>
          </tr>
          <tr>
            <th>创建时间</th>
            <td id="a_created_at"></td>
          </tr>
        </table>
      </div>
      <!-- /.modal-body -->
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
      <!-- /.modal-footer -->
    </div>
    <!-- /.modal-content -->
  </div>
</div>
<!-- /.userInfoModal -->

<div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="DeleteModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <a type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <h4 class="modal-title" id="DeleteModalLabel">删除</h4>
      </div>
      <div class="modal-footer">
        <form method="post" action="" class="pull-right">
          {!!csrf_field()!!}
          <div class="form-group">
            <div>
              <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
              <button type="submit" class="btn btn-danger">删除</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- /.deleteUserModal -->

<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <a type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <h4 class="modal-title" id="EditModalLabel">编辑</h4>
      </div>
      <div class="modal-footer">
        <form method="post" action="" class="form-horizontal">
          {!! csrf_field() !!}
          <div class="form-group">
            <label class="col-sm-3 control-label">组名：</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="editmodelname" name="name">
            </div>
          </div>
          <!-- /.form group -->
          <div class="form-group">
            <label class="col-sm-3 control-label">接收成员：</label>
            <div class="col-sm-9">
              <select id="editselect2" class="select2" class="form-control" style="width:100%" name="users[]" multiple="multiple">
		            @foreach($users as $id=>$name)
									<option value={!!$id!!}>{!!$name!!}</option>
								@endforeach
		          </select>
            </div>
          </div>
          <!-- /.form group -->
          <div class="form-group">
            <label class="col-sm-3 control-label">报警方式：</label>
            <div class="col-sm-9">
               <select class="form-control" name="type" id="editselect">
	                <option value="weixin">微信</option>
	                <option value="email">邮件</option>
	                <option value="all">微信+邮件</option>
	              </select>
            </div>
          </div>
          <!-- /.form group -->
          {{--
          <div class="form-group">
            <label class="col-sm-3 control-label">TOKEN：</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="editmodeltoken" placeholder="16个字符" name="token">
            </div>
          </div>
          <!-- /.form group -->
          --}}
          <div class="form-group">
            <div class="col-sm-12">
              <button type="submit" class="btn btn-primary">确定</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- /.editUserModal -->

@include('shared.errors')
@include('shared.status')  
<div class="row">
  <div class="col-md-9">
    <div class="box box-primary">
      <!-- /.box-header -->
      <div class="box-header with-border">
        <h3 class="box-title">所有分组&nbsp;&nbsp;&nbsp;&nbsp;<small></small></h3>
      </div>
      <div class="box-body">
        <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th style="width:32px">组名</th>
              <th>接收成员</th>
              <th style="width:60px">报警方式</th>
              <th style="width:120px">TOKEN</th>
              <th style="width:32px">操作</th>
            </tr>
          </thead>
          <tbody>
          @foreach($items as $i)
            <tr>
              <td>{!! $i->name !!}</td>
              <td>
								@foreach($i->users as $user)
									<a data-toggle="modal" data-target="#userInfoModal" data-id="{!!$user->id!!}" href="#">{!!$user->name!!}</a>&nbsp;&nbsp;
								@endforeach
              </td>
							@if($i->type == "weixin")
              <td><span class="label label-primary">微信</span></td>
              @elseif($i->type == "email")
              <td><span class="label label-primary">邮件</span></td>
              @else
              <td><span class="label label-primary">微信+邮件</span></td>
              @endif
							<td><span class="label label-primary">{!!$i->token!!}</span></td>
              <td>
                <a href="#" class="fa fa-fw fa-edit" data-toggle="modal" data-target="#EditModal" data-id="{!! $i->id !!}"  data-name="{!! $i->name !!}" data-users={!! $i->users()->lists('a_user_id') !!} data-type="{!! $i->type !!}" data-token="{!! $i->token !!}" data-action="{!! route('alert.group.update', $i->id) !!}"></a>
                <a href="#" class="fa fa-fw fa-close" data-toggle="modal" data-target="#DeleteModal" data-name="{!! $i->name !!}" data-action="{!! route('alert.group.destroy', $i->id) !!}"></a>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
  </div>
  <!-- /.col-md-8 -->
  <div class="col-md-3">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">添加分组</h3>
      </div>
      <form method="post" class="form-group">
      {!! csrf_field() !!}
        <div class="box-body">
        	{{--
          <div class="form-group">
            <label>机房：</label>
            <div class="form-group">
              <select class="form-control" name="room">
              @foreach($rooms as $room)
                <option value={!!$room!!}>{!!$room!!}</option>
              @endforeach
              </select>
            </div>
          </div>
          --}}
          <!-- /.form group -->
          <div class="form-group">
            <label>组名：</label>
            <div class="form-group">
              <input type="text" class="form-control" name="name" value="{{old('name')}}">
            </div>
          </div>
          <!-- /.form group -->
          <div class="form-group ">
            <label>接收成员：</label>
            <div class="form-group">
              <select class="select2" class="form-control" style="width:100%" name="users[]" multiple="multiple">
		            @foreach($users as $id=>$name)
									<option value={!!$id!!}>{!!$name!!}</option>
								@endforeach
		          </select>
            </div>
          </div>
          <!-- /.form group -->
          <div class="form-group ">
            <label>报警方式：</label>
            <div class="form-group">
               <select class="form-control" name="type">
                  <option value="weixin" selected>微信</option>
                  <option value="email">邮件</option>
                  <option value="all">微信+邮件</option>
                </select>
            </div>
          </div>
          <!-- /.form group -->
          </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-block btn-primary">添加</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /.row -->
@endsection
{{--by caishunzhi 2017 --}}
@section('addon')
@include('shared.datatable')
@include('shared.select2')
<script>
$(function () {
  $('#datatable').dataTable({
    "language": {
      "url": "{!! asset('s/plugins/datatables/i18n/Chinese.json') !!}"
    },
    "lengthMenu": [[12, 25, 50, -1], [ 12, 25, 50, "All"]],
    "ordering": false,
  });

  $(".select2").select2({
  	multiple: true,
  	placeholder: "可多选"
  });

  $('#DeleteModal').on('show.bs.modal', function (event) {
		var a = $(event.relatedTarget) // Button that triggered the modal 当前点击的对象
		var action = a.data('action') //从点击的对象获取属性值
		var name = a.data('name') // Extract info from data-* attributes
		var modal = $(this)
		modal.find('.modal-header h4').text('删除分组'+name+'?')
		modal.find('.modal-footer form').attr('action', action)
  });
  <!-- /.DeleteModal -->

  $('#EditModal').on('show.bs.modal', function (event) {
		var a = $(event.relatedTarget) // Button that triggered the modal 当前点击的对象

		var action = a.data('action') //从点击的对象获取属性值
		var id = a.data('id') // Extract info from data-* attributes
		var name = a.data('name')
		var users = a.data('users')
    var type = a.data('type')
    var token = a.data('token')

  	$("#editselect2").val(users).trigger("change");
		
		if(type=='email') {
			$("#editselect").val('email')
		}
    if(type=='weixin'){
    	$("#editselect").val('weixin')
    }
    if(type=='all'){
    	$("#editselect").val('all')
    }

		var modal = $(this)
		modal.find('.modal-header h4').text('编辑分组:'+name)
		modal.find('.modal-footer form').attr('action', action)
		modal.find('.modal-footer #editmodelname').val(name)
    modal.find('.modal-footer #editmodeltoken').val(token)
  });
  <!-- /.EditModal -->

  $('#userInfoModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var id = button.data('id')

    $.ajax({
      type: "get",
      url : '/user/'+id,
      success : function(a){
        $("#a_name").text(a.name),
        $("#a_weixin").text(a.weixin),
        $("#a_email").text(a.email),
        $("#a_comment").text(a.comment),
        $("#a_created_at").text(a.created_at)
      }
    })
  });

});
</script>
@endsection