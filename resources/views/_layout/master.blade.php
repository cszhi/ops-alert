<!DOCTYPE html>

<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title', 'OPSAlert')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ asset('/s/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="//cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.min.css">
  <link href="//cdn.bootcss.com/ionicons/2.0.1/css/ionicons.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('/s/dist/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/s/dist/css/skins/skin-blue.min.css') }}">
  <script src="{{asset('/s/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
  

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  @include('_layout/header')
  @include('_layout/sidebar')

  <div class="content-wrapper">
    <section class="content-header">
      <h1>{{$title or " "}}</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> OPS</a></li>
        <li class="active">{{$title or " "}}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
		@yield('content')
    </section>
    <!-- /.content -->
  </div>
  <div class='clearfix'></div>
  @include('_layout/footer')

</div>
<script src="{{asset('/s/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/s/dist/js/app.min.js')}}"></script>
@yield('addon')
<!-- by caishunzhi 2017 -->
</body>
</html>
