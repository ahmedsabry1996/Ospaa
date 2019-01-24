@extends('layouts.app')

@section('title',' - اعلانات')
@section('content')
@include('included.nav')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@if($errors->any())
<div class="row" dir="rtl">
	<div class="alert alert-danger col-md-5 col-md-push-3">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
		</button>
		<h3 class="text-center">

			لم يتم تعديل الاعلان بنجاح يُرجي مراجعة الاخطاء التالية
		</h3>
		<ul>
			@foreach($errors->all() as $error)

			<li>
				{{$error}}
			</li>
			@endforeach
		</ul>
	</div>
</div>
@endif
<div class="row text-center" dir="rtl">

	@foreach($ads as $ad)
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
	
	@if($ad->user_id === Auth::id())	

		
		 <a type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal-{{$ad->id}}">تعديل</a>

  	<!-- Edit ads -->
  <div class="modal fade" id="myModal-{{$ad->id}}" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">تعديل اعلان </h4>
        </div>
        <div class="modal-body">
    
<form action="{{route('ads.update',['id'=>$ad->id])}}" enctype="multipart/form-data" method="POST" role="form">
@csrf
	<legend>إنشاء اعلان</legend>
		<h4 class="text-center">يرجي ملء كافة الحقول التالية</h4>
	<div class="form-group">
		<input type="text" class="form-control" placeholder="عنوان اعلانك" name="title" required="required" value="{{$ad->title}}" >
	</div>
	
	<div class="form-group">
		<input type="text" class="form-control"  placeholder="مكان اعلانك" name="address" value="{{$ad->address}}">
	</div>
	<div class="form-group text-right">
		<label>التخصص :</label>
		<select name="category" dir="ltr">
			@foreach($categories as $category)
			
			<option value="{{$category->id}}"
					has-img="{{$category->has_img}}"
					ad-id = {{$ad->id}}	
			@if($category->id == $ad->category_id)
				selected
			@endif
			>{{$category->category}}</option>
			
			@endforeach
		</select>
	</div>

	<div class="form-group">
		<input type="text" class="form-control"  placeholder="رقم الهاتف" name="phone" value="{{$ad->phone}}">
	</div>
	<div class="form-group">
	<label>يرجي كتابة محتوى لاعلانك ﻻ يقل عن 30 كلمة</label>
	<textarea style="resize: none;" name="content" placeholder="محتوى الاعلان" cols="30" rows="10" class="form-control" id="content">{{$ad->content}}</textarea>
	
	<div class="text-right">
	<span class="text-left" id="length"><b>0</b></span>
	</div>
	</div>
	
<div class="form-group" id="add-img-{{$ad->id}}">
					<div class="row ads-img">

			@foreach($ad->imgs as $img)	
			
					<button id="remove_img" ad-id="{{$ad->id}}" img-id="{{$img->id}}" type="button">ازالة</button>	
			<img src="{{asset($img->path)}}" alt="{{$ad->title}}" class="img-rounded" height="50" width="50" id="im-{{$img->id}}">
			@endforeach
						</div>

	

			@if($ad->imgs->count() !== 3 )
	<label id="img-label">اختر صورة لاعلانك</label>
		<input style="padding-bottom: 28px" type="file" class="form-control" name="imgs[]" multiple >
	@endif
	</div>
	
	<div class="form-group">
		<input type="text" class="form-control"  placeholder="كلمات الدلالة" name="tags" value="{{$ad->tags}}">
	</div>



	<button type="submit" class="btn btn-success">حفظ</button>
</form>	

    
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق</button>
        </div>
      </div>
      
    </div>
  </div>
  
  			
  			@endif
<a href="{{route('ads.single',['id'=>$ad->id])}}" class="btn btn-success">رؤية المزيد</a>
  			
  	
	</div>
	<hr>
	@endforeach
	{{$ads->links()}}
</div>

 <script src="{{ asset('js/jq.js') }}" ></script>

<script>
$(function(){
	$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
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
	
	$("option").click(function(){
		
	let adId = $(this).attr('ad-id');
		console.log(adId);
	let hasImage = $(this).attr('has-img');
		
	if(hasImage == 0){
	
		$("#add-img-"+adId).addClass('hide');

	}	
		else{
			$("#add-img-"+adId).removeClass('hide');

		}
		
	});
	
	$("body").delegate("button#remove_img","click",function(e){
			e.preventDefault();	
			let adId=$(this).attr('ad-id')+'/';
			let imgId = $(this).attr('img-id');
			let thisButton = $(this);
		
	$.ajax({
		url:'/ads/edit/'+adId+imgId,
		method:'GET',
		success:function(data){
				
				console.log(data.imgs);
		if(data.imgs === 0 ){
			alert('يحب ان يحتوي اعلانك على صورة واحدة على الاقل')
		}
			
			else{
				$("img#im-"+imgId).remove();
				thisButton.remove();
			}
		},
		error:function(err){
			alert(this.url);
			console.log(err);
		}
	});
	});
	
});
</script>

@endsection
