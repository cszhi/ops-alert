@extends('_layout.master')
@section('content')
@include('shared.errors')
@include('shared.status')
<div class="col-md-8 col-md-offset-2">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#password" data-toggle="tab">密码重置</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane" id="password">
      </div>
      <div class="tab-pane active" id="weixin">
        <form class="form-horizontal" method="post" action="{!!route('admin.password.update')!!}">
          {!! csrf_field() !!}
          <div class="form-group">
            <label class="col-sm-2 control-label">旧密码:</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" name="oldpassword" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">新密码:</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" name="password" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">确认新密码:</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" name="password_confirmation" value="">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-2 col-sm-offset-2">
              <button type="submit" class="btn btn-primary btn-block">确认</button>
            </div>
          </div>
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
  <!-- /.nav-tabs-custom -->
</div>
@endsection


