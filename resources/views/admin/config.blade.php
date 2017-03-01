@extends('_layout.master')
@section('content')
@include('shared.errors')
@include('shared.status')
<div class="col-md-8 col-md-offset-2">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class={!!$email or ''!!}><a href="#email" data-toggle="tab">邮箱设置</a></li>
      <li class={!!$weixin or ''!!}><a href="#weixin" data-toggle="tab">微信设置</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane {!!$email or ''!!}" id="email">
        <form class="form-horizontal" method="post" action="{!!route('admin.config.update')!!}">
          {!! csrf_field() !!}
          <div class="form-group">
            <label for="server" class="col-sm-2 control-label">邮件服务器:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="host" placeholder="如：smtp.abc.com" value="{!!$data['host']!!}">
            </div>
          </div>
          <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">发件人名称:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="fromname" placeholder="如：warn" value="{!!$data['fromname']!!}">
            </div>
          </div>
          <div class="form-group">
            <label for="email" class="col-sm-2 control-label">邮箱帐号:</label>
            <div class="col-sm-10">
              <input type="email" class="form-control" name="email" placeholder="如：warn@abc.com" value="{!!$data['username']!!}">
            </div>
          </div>
          <div class="form-group">
            <label for="password" class="col-sm-2 control-label">邮箱密码:</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" name="password" id="password" value="{!!$data['password']!!}">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-2 col-sm-offset-2">
              <button type="submit" class="btn btn-primary btn-block">确认</button>
            </div>
          </div>
        </form>
      </div>
      <div class="tab-pane {!!$weixin or ''!!}" id="weixin">
        <form class="form-horizontal" method="post" action="{!!route('admin.config2.update')!!}">
          {!! csrf_field() !!}
          <div class="form-group">
            <label for="server" class="col-sm-2 control-label">corpid:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="corpid" value="{!!$data['corpid']!!}">
            </div>
          </div>
          <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">corpsecret:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="corpsecret" value="{!!$data['corpsecret']!!}">
            </div>
          </div>
          <div class="form-group">
            <label for="email" class="col-sm-2 control-label">agentid:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="agentid" value="{!!$data['agentid']!!}">
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


