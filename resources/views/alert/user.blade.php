@extends('_layout.master')
@section('content')

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

<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel"><div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <a type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <h4 class="modal-title" id="EditModalLabel">编辑</h4>
      </div>
      <div class="modal-footer">
        <form method="post" action="" class="form-horizontal">
        {!! csrf_field() !!}
          <div class="form-group">
            <label class="col-sm-2 control-label">用户名：</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="editmodelname" name="name">
            </div>
          </div>
          <!-- /.form group -->
          <div class="form-group">
            <label class="col-sm-2 control-label">微信号：</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="editmodelweixin" name="weixin">
            </div>
          </div>
          <!-- /.form group -->
          <div class="form-group">
            <label class="col-sm-2 control-label">邮箱：</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="editmodelemail" name="email">
            </div>
          </div>
          <!-- /.form group -->
          <div class="form-group">
            <label class="col-sm-2 control-label">备注：</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="editmodelcomment" name="comment">
            </div>
          </div>
          <!-- /.form group -->
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
@include('shared.errors')
@include('shared.status')  
<div class="row">
  <div class="col-md-9">
    <div class="box box-primary">
      <!-- /.box-header -->
      <div class="box-header with-border">
        <h3 class="box-title">所有用户&nbsp;&nbsp;&nbsp;&nbsp;<small></small></h3>
        {{--
        <div class="btn-group pull-right">
          <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-wrench"></i></button>
          <ul class="dropdown-menu">
            <li>
              <a href="{!! action('Asset\RackController@portimport') !!}">导入端口信息</a></li>
          </ul>
        </div>
        --}}
      </div>
      <div class="box-body">
        <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>用户名</th>
              <th>微信号</th>
              <th>邮箱</th>
              <th>备注</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
          @foreach($items as $i)
            <tr>
              <td>{!! $i->name !!}</td>
              <td><span class="label label-primary">{!! $i->weixin !!}</span></td>
							<td><span class="label label-primary">{!! $i->email !!}</span></td>
              <td>{!! $i->comment !!}</td>
              <td>
                <a href="#" class="fa fa-fw fa-edit" data-toggle="modal" data-target="#EditModal" data-id="{!! $i->id !!}"  data-name="{!! $i->name !!}" data-weixin="{!! $i->weixin !!}" data-email="{!! $i->email !!}" data-comment="{!! $i->comment !!}" data-action="{!! route('alert.user.update', $i->id) !!}"></a>
                <a href="#" class="fa fa-fw fa-close" data-toggle="modal" data-target="#DeleteModal" data-name="{!! $i->name !!}" data-action="{!! route('alert.user.destroy', $i->id) !!}"></a>
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
        <h3 class="box-title">添加用户</h3>
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
            <label>用户名：</label>
            <div class="form-group">
              <input type="text" class="form-control" name="name" value="{{old('name')}}">
            </div>
          </div>
          <!-- /.form group -->
          <div class="form-group ">
            <label>微信号：</label>
            <div class="form-group">
              <input type="text" class="form-control" name="weixin" value="{{old('weixin')}}">
            </div>
          </div>
          <!-- /.form group -->
          <div class="form-group ">
            <label>邮箱：</label>
            <div class="form-group">
              <input type="text" class="form-control" name="email" value="{{old('email')}}">
            </div>
          </div>
          <!-- /.form group -->
          <div class="form-group ">
            <label>备注：</label>
            <div class="form-group">
              <input type="text" class="form-control" name="comment" value="{{old('comment')}}">
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

@section('addon')
@include('shared.datatable')
<script>
$(function () {
  $('#datatable').dataTable({
    "language": {
      "url": "{!! asset('s/plugins/datatables/i18n/Chinese.json') !!}"
    },
    "lengthMenu": [[12, 25, 50, -1], [ 12, 25, 50, "All"]],
    "ordering": false,
  });

  $('#DeleteModal').on('show.bs.modal', function (event) {
		var a = $(event.relatedTarget) // Button that triggered the modal 当前点击的对象
		var action = a.data('action') //从点击的对象获取属性值
		var name = a.data('name') // Extract info from data-* attributes
		var modal = $(this)
		modal.find('.modal-header h4').text('删除类型'+name+'?')
		modal.find('.modal-footer form').attr('action', action)
  });

  $('#EditModal').on('show.bs.modal', function (event) {
		var a = $(event.relatedTarget) // Button that triggered the modal 当前点击的对象

		var action = a.data('action') //从点击的对象获取属性值
		var id = a.data('id') // Extract info from data-* attributes
		var name = a.data('name')
		var comment = a.data('comment')
    var weixin = a.data('weixin')
    var email = a.data('email')
		
		var modal = $(this)
		modal.find('.modal-header h4').text('编辑用户:'+name)
		modal.find('.modal-footer form').attr('action', action)
		modal.find('.modal-footer #editmodelname').val(name)
		modal.find('.modal-footer #editmodelcomment').val(comment)
    modal.find('.modal-footer #editmodelemail').val(email)
    modal.find('.modal-footer #editmodelweixin').val(weixin)
  });
});
</script>
@endsection
{{--by caishunzhi 2017 & cszhi@live.com --}}