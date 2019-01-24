@extends('adminlte::page')

@section('title', 'Ospaa Cpanel')

@section('content_header')

<h3 class="text-center">

 	مرحباً بكم في لوحة التحكم

</h3>
@stop

@section('content')
    
@stop

@section('css')
    <link rel="stylesheet" href="{{asset('css/toastr.css')}}">
@stop

@section('js')
   <script src="{{asset('js/jq.js')}}"></script>
   <script src="{{asset('js/toastr.js')}}"></script>
   
    <script> 

			@if(Session::has('success'))
			
					toastr.success("{{Session::get('success')}}");
			
		@endif
</script>
@stop
