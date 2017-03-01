{{--
@if (session('status'))
  <div class="alert alert-success">
  	{{ session('status') }}
  </div>
@endif
--}}
{{--
@if (session('status'))
	<div class="alert alert-success alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			{{ session('status') }}
	</div>
@endif
--}}
@if (session('status'))
	<link href="{!! asset('s/plugins/toastr/toastr.min.css') !!}" rel="stylesheet">
	<script type="text/javascript" src="{!! asset('s/plugins/toastr/toastr.min.js') !!}"></script>
	<script type="text/javascript">
		$(function () {
			toastr.options = {
				"closeButton": true,
				"progressBar": false,
				"timeOut": "3000",
				"positionClass": "toast-top-center"
			}
			toastr.success("{{ session('status') }}")
		});
	</script>
@endif