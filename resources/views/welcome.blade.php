@extends('layouts.app')

@section('content')

    					@include('included.nav')

                <h1 class="text-center">
                    OSPAA
                </h1>
            
            <div class="row text-center" dir="rtl">
            <div class="col-md-6 col-md-push-3">
        		@include('included.search')
        		</div>
</div>
@endsection
<script src="{{asset('js/jq.js')}}"></script>
<script>
$(function(){
		
	$("#search-word").keyup(function(){
	
		let word = $(this).val();
		var results = '';
			if(word.trim().length > 0){
				$.ajax({
					
					url:'/search/',
					method:'get',
					data:{
					word
				},
					success:function(data){
						console.log((data));
						
						for(let i = 0 ; i < data.length ; i++){
							
							console.log(data[i].title,"في " , 
							data[i].address,
							data[i].content.substring(0,10)+" ... المزيد");
							results +=`
	
							<li class='list-group-item'>
<bdi>
							<b>${data[i].title}</b> في <b>${data[i].address} </b>
						<br>
						<i>
${data[i].content.substring(0,10)} ... 
				<a href="ads/single/${data[i].id}">المزيد</a>
	</i>
<bdi>
					</li>

						`;
							$(".results ul").html(results);
						}
					},
					error:function(err){
						console.log(err.responseText)
					}
				});
			}
		
		else{
		$(".results ul").html('');	
			results = '';	
		}
		
	});
	
});
</script>


