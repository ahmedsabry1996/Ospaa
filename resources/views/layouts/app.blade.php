<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ospaa @yield('title')</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <link href="{{ asset('css/bs.css') }}" rel="stylesheet">
    
</head>
<body>

   	
   	
        <div class="col-md-12">
            @yield('content')
        </div>
        
	<script src="{{ asset('js/jq.js') }}" ></script>
	<script src="{{ asset('js/jquery.validate.js') }}" ></script>
	<script src="{{ asset('js/messages_ar.js') }}" ></script>
	<script src="{{ asset('js/rates.js') }}" ></script>
    <script src="{{ asset('js/bs.js') }}" ></script>
    <script src="{{ asset('js/sa.js') }}" ></script>
 	<script src="{{ asset('js/toastr.js') }}"></script>
    <script>
	
	
		@if(Session::has('success'))
			toastr.success("{{Session::get('success')}}");
		@endif
		
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
	
	$('body').delegate('button#delete-img',"click",function(){

		$.ajax({
			url:'edit/1/2',
			method:'GET',
			success:function(data){
				console.log(data)
			},
			error:function(err){
				console.log(err)
			}
		});
	
	});
	
		@auth
		
		setInterval(function(){
			
			$.ajax({
				url:"/unr",
				method:'GET',
				success:function(data){
					
					
					if(data > 0 ){
						$('.fa-globe-asia').addClass('new-notification');
					}
					
					
					
				},
				error:function(err){
					
					console.log(err);
				}
				
			});
				
		},3000);
		
		$('#show-notification,#show-notification-xs').on('click',function(){
			$('.fa-globe-asia').removeClass('new-notification');
			return displayNotifications();
		});
		
		function displayNotifications(){
			$.ajax({
				
				url:'/allnotifications',
				method:'GET',
				success:function(data){
					let notifications = '';
					for(let i = 0 ; i < data.length ; i++){
					console.log(data[i].data);
						let current_data = data[i].data;
						notifications +=`

							 <li>
            		<div class="text-center"><a href=/ads/single/${current_data.ads_id}>
            		<h4>

				<bdi>	
				${current_data.message}
          		 <b> ${current_data.ads_title} </b>		
           		</bdi>
           		</h4>
            		</a> 
            		
            		</div>
            	</li>
  

						`;
					}
					
					$('.drop-content').append(notifications);
				},
				error:function(err){
					console.log(err);
				}
			})
		}
	
	$('#content').keyup(function(){

		let contnetArea = $(this).val().trim();
		$("#length b").html(contnetArea.length);
		
		if(contnetArea.length < 30){
				$("#length").addClass('text-danger');
				$("#length").removeClass('text-success');
		}
		else{
			$("#length").addClass('text-success');
			$("#length").removeClass('text-danger');

		}
		
	});
	
	
		@endauth
		
	</script>
</body>
</html>
