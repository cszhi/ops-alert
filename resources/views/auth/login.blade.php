<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>OPS | Chinac</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ asset('/s/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="//cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.min.css">
  <link href="//cdn.bootcss.com/ionicons/2.0.1/css/ionicons.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('/s/dist/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/s/dist/css/skins/skin-blue.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/s/plugins/iCheck/square/blue.css') }}">
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="{!! url('/') !!}"><b>OPS</b>Alert</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">登陆</p>

    <form action="{!! route('login') !!}" method="post">
      @include('shared.errors')
      {!! csrf_field() !!}
      <div class="form-group has-feedback">
        <input type="text" name="name" class="form-control" placeholder="用户名" >
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="密码">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name="remember"> 记住我
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">登陆</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<script src="{{asset('/s/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
<script src="{{asset('/s/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('s/plugins/iCheck/icheck.min.js')}}"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>