<link href="{{ asset('/plugins/toastr/toastr.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('/plugins/toastr/toastr.js') }}" type="text/javascript"></script>
@if ($message = Session::get('danger'))
<script type="text/javascript">
	//alert('<?php echo $message; ?>');
	toastr.error('<?php echo $message; ?>', 'Peligro', {timeOut: 5000})
</script>
<?php Session::forget('danger'); ?>
@endif
