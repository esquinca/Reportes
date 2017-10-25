<link href="{{ asset('/plugins/toastr/toastr.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<script src="{{ asset('/plugins/toastr/toastr.js') }}" type="text/javascript"></script>

@if ($message = Session::get('imagenperf'))
<script type="text/javascript">
	//alert('<?php echo $message; ?>');
	toastr.success('<?php echo $message; ?>', 'Mensaje', {timeOut: 2500})
</script>
<?php Session::forget('success'); ?>
@endif

@if ($message = Session::get('bienvenido'))
<script type="text/javascript">
	//alert('<?php echo $message; ?>');
	toastr.success('<?php echo $message; ?>', 'Mensaje', {timeOut: 5000})
</script>
<?php Session::forget('success'); ?>
@endif

@if ($message = Session::get('success'))
<script type="text/javascript">
	//alert('<?php echo $message; ?>');
	toastr.success('<?php echo $message; ?>', 'Éxito', {timeOut: 5000})
</script>
<?php Session::forget('success'); ?>
@endif

@if ($message = Session::get('danger'))
<script type="text/javascript">
	//alert('<?php echo $message; ?>');
	toastr.error('<?php echo $message; ?>', 'Peligro', {timeOut: 5000})
</script>
<?php Session::forget('danger'); ?>
@endif
