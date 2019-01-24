@extends('layouts.app')

@section('title',' - create new ad')
@section('content')
@include('included.nav')
@if($errors->has('report'))

	<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
</button>

	<h3 class="text-center">
				{{$errors->first('report')}}

	</h3>
</div>

@endif
<div class="row text-center" dir="rtl">

	<div class="ads-header">
		<h3>{{$ad->title}}</h3>
		<p>
			@if($ad->user_id === Auth::id())
			<bdi>
			تم النشر
			<b class="text-success">
			بواسطتك
			</b>

			</bdi>

			@else

			<bdi>
			بواسطة
			<b class="text-success"><i>{{$ad->user->name}}</i></b>
			</bdi>
			@endif

		</p>
		<p>
			{{$ad->created_at->diffForHumans()}}
		</p>
		<p><b>
			{{$ad->content}}
		</b>
		</p>
			<a href="#" id="phone" class="btn btn-primary">
				تواصل عن طريق الهاتف
			</a>
			
	</div>
	<br>
	<div class="ads-img">
		@foreach($ad->imgs as $img)
		
			<img src="{{asset($img->path)}}" alt="{{$ad->title}}" class="img-rounded" height="100" width="100">
		
		@endforeach
	
	</div>
	<div class="views">
		<bdi> عدد مرات المشاهدة : {{$ad->views->views}} </bdi>
	</div>
@if(Auth::id() !== $ad->user_id)


<div class="container">
		<div class="row">
		@auth
			<label>تقييم الاعلان</label>
	
	<div id='rate' avg="{{ceil($avg)}}" user-id="{{Auth::id()}}" ads-id ="{{$ad->id}}" ></div>
	@else
	<b class="text-center">
		يرجي تسجيل الدخول لتقييم المنتج
	</b>

	@endauth
		</div>

		<div class="row">
		
		@if(!$avg)
			<b>لم يتم تقييم الاعلان حتى الان</b>
		@else
		<bdi>نسبة تقييم هذا الاعلان : <b class="text-success">{{$avg}}</b> من 5</bdi>
		@endif
		
	</div>

		</div>

@endif
	
	@auth
	<hr/>
	@if(Auth::id() !== $ad->user->id)
	<div class="report">
	<button class="btn btn-warning" data-toggle="modal" data-target="#myreport">ابلاغ عن هذا الاعلان</button>
	
	 <!-- Modal -->
  <div class="modal fade" id="myreport" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">
      <bdi>
		  ابلاغ عن الاعلان
        : {{$ad->title}}</bdi></h4>
        </div>
        <div class="modal-body">

		<form action="{{route('report',['id'=>$ad->id])}}" method="POST" role="form">

			@csrf
	<div class="form-group">
		<textarea style="resize: none" name="report" class="form-control" cols="30" rows="10" placeholder="سبب الشكوي"></textarea>
	</div>
	<button type="submit" class="btn btn-primary">ارسال</button>
	
</form>
  
       
       </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق</button>
        </div>
      </div>
      
    </div>
  </div>
 
	</div>
	
@endif
	<hr/>
	
		<form method="POST" role="form" class="col-md-4 col-md-push-4">

		<input type="text" class="form-control" placeholder="اضف تعليقك" style="height: 40px" id="comment">
<br>

	<button type="submit" class="btn btn-primary" id="add-comment" ad-id="{{$ad->id}}" user-id="{{Auth::id()}}">تعليق</button>
</form>

@else

<b class="text-center">
	يُرجي تسجيل الدخول لتتمكن من اضافة تعليق
</b>
@endauth
</div>
<div class="container">
<div class="row text-center rounded comments">
	@foreach($ad->comments as $comment)
	<div class="comment 
	
		@if($ad->user_id == $comment->user_id)
				by-admin
		@endif
	
	">
	@if($comment->user_id == Auth::id())
			<b>انت</b>
		@elseif($ad->user_id == $comment->user_id )
		
		<b>المعلن</b>
		@else	
		<b>{{$comment->user->name}}</b>
		
		@endif
		
		<p>{{$comment->comment}}</p>
		<i style="color: #000;opacity: .2">{{$comment->created_at->diffForHumans()}}</i>
		</div>
	@endforeach
<input type="hidden" user-id='ss' name="rating" value="4" />
</div>
</div>
<style>

	.by-admin{
		background-color: rgba(0,0,0,.4);
	}
	.rated{
		opacity: 1 !important;
	}
	.jqEmoji{
		opacity: .5
	}
</style>
<script src="{{asset('js/jq.js')}}"></script>
<script>

		$(function(){
	
			let rateAvg = Number($("#rate").attr('avg'));
			
		
		
	let rate;		
	let options = {
	emoji: 'U+2B50',
	count: 5,
	fontSize: 16,
	inputName: 'rating',
	onUpdate: function(rating) {
		
		rate = rating;
		let userId = $("#rate").attr('user-id');
		let adId = 	 $("#rate").attr('ads-id');

		console.log(Number(adId));
		$.ajax({
					
					url:"/ads/rate",
					method:"get",
					data:{
						rate:	Number(rate),
						user_id:Number(userId),
						ad_id:	Number(adId),
					},
					success:function(data){
						console.log("rated");
					},
					error:function(err){
						console.log("error in rate:"+err);
					}
				})
				
		
	}
}
			$('#rate').emojiRating(options);
			
			$("#phone").click(function(){
				swal("هاتف المعلن","{{$ad->phone}}");
			});
			
			$("img").click(function(){
				$(this).toggleClass('zoom');
			});
			$("#add-comment").bind("click",function(e){
				e.preventDefault();
				
				let userId = Number($(this).attr('user-id'));
				let adId = Number($(this).attr('ad-id'));
				let comment = $("#comment").val();
				$.ajax({
				
					url:"{{route('comment.add')}}",
					method:'post',
					data:{
						comment:comment,
						ad_id:adId,
						user_id:userId,
						
					},
					success:function(data){
						$('.comments').prepend("تم اضافة التعليق <br>");
						
					},
					error:function(err){
						alert(this.url)
						console.log(err)
					}
				});
			});
			
		
		});
	
</script>
@endsection
<style>
	img{
		transition: .5s all ease-in-out;
		z-index: 200;

	}
	.zoom{
		transition: .5s all ease-in-out;
		transform: scale(5,5);
	}

</style>