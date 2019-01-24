@extends('layouts.app')

@section('title',' - create new ad')
@section('content')
@include('included.nav')
<style>


label.error{
  color: red
}
</style>
<div class="row " dir="rtl">
	<form id="create_ads" action="{{route('ads.store')}}" enctype="multipart/form-data" method="POST" role="form" class="col-md-5 col-md-push-3">
		@csrf
		<legend>إنشاء اعلان</legend>
		<h4 class="text-center">يرجي ملء كافة الحقول التالية</h4>
		<div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
		<label>عنوان الاعلان</label>
			<input type="text" class="form-control" placeholder="مثال : سيارة هيوانداي" name="title" value="{{old('title')}}"  title="تنبيه" data-toggle="popover" data-trigger="focus" data-content="مطلوب">

			@if($errors->has('title'))
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
				</button>
				{{$errors->first('title')}}
			</div>
			@endif


		</div>

		<div class="form-group {{$errors->has('address') ? 'has-error' : ''}}">
		<label>مكان اعلانك</label>
			<input type="text" class="form-control" placeholder="مثال : ابو حمص البحيرة" name="address" value="{{old('address')}}" title="تنبيه" data-toggle="popover" data-trigger="focus" data-content="مطلوب">
			
			@if($errors->has('address'))
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
				</button>
				{{$errors->first('address')}}
			</div>
			@endif
		</div>
		<div class="form-group {{$errors->has('category') ? 'has-error' : ''}} text-right">
			<label>التخصص :</label>
			<select name="category" dir="ltr">
				@foreach($categories as $category)

				<option value="{{$category->id}}"
						has_img="{{$category->has_img}}"
				  @if(old('category')==$category->id)
					selected
					@endif


					>{{$category->category}}</option>

				@endforeach
			</select>
		</div>
		<div class="form-group {{$errors->has('phone') ? 'has-error' : ''}}">
		<label>رقم الهاتف</label>
			<input type="text" class="form-control" placeholder="مثال : 01234567891" name="phone" value="{{old('phone')}}" title="تنبيه" data-toggle="popover" data-trigger="focus" data-content="يرجى كتابة رقم تليفونك المكون من 11 رقم">
			
			@if($errors->has('phone'))
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
				</button>
				{{$errors->first('phone')}}
			</div>
			@endif
		</div>
		<div class="form-group {{$errors->has('content') ? 'has-error' : ''}} form-group {{$errors->has('content') ? 'has-error' : ''}}">
			<label>يرجي كتابة محتوى لاعلانك ﻻ يقل عن 30 حرف</label>
			<textarea style="resize: none;" name="content" placeholder="محتوى الاعلان" cols="30" rows="10" class="form-control has-error" id="content" minlength="30">{{old('content')}}</textarea>

			@if($errors->has('content'))
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
				</button>
				{{$errors->first('content')}}
			</div>
			@endif
			<div class="text-right">
				<span class="text-left" id="length"><b>0</b></span>
			</div>
		</div>
		<div id="add-img" class="form-group {{$errors->has('imgs') ? 'has-error' : ''}}">
			<label>اختر على الاقل صورة لاعلانك</label>
			<input style="padding-bottom: 28px" type="file" class="form-control" name="imgs[]" onchange="readURL(this);" data-toggle="popover" data-trigger="focus" data-content="اختر صورة واحدة ع الاقل او 3 صور على الاكثر" multiple>
			<br>
		<div class="row">	
			@for($i=1 ; $i < 4 ;$i++ )
				<div class="col-md-4">
				<img src="#" alt="#" id="ad-{{$i}}" class="img-responsive hide" style="margin: 0 auto;height: 250px">
				</div>
			@endfor
			</div>
			@if($errors->has('imgs'))
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
				</button>
				{{$errors->first('imgs')}}
			</div>
			@endif
		</div>
		<div class="form-group">
		
				<label>كلمات الدلالة</label>
			<input type="text" class="form-control" placeholder="مثال : سيارة هيونداي عربية مﻻكي رخصة  " name="tags" value="{{old('tags')}}" id="tags" >
		</div>



		<button type="submit" class="btn btn-primary">اضافة</button>
	</form>
</div>
<script src="{{asset('js/jq.js')}}"></script>
<script>
$(document).ready(function(){
		
	$('#create_ads input:not(#tags), #create_ads textarea,#create_ads select').attr('required','required');

	$("#create_ads").validate({
  rules: {
    phone: {
      required: true,
      number: true,
	  minlength:11,
    },
  },
			  messages:{
		  phone:{
			  required:"يرجى ادخال رقم الهاتف",
			  minlength:'يرجي ادخال رقم هاتف صحيح',
			  number:'يرجي ادخال رقم الهاتف بصورة صحيحة'
		  },
		imgs:{
			  required:"يرجى اختيار صورة واحدة على الاقل",
		  },
	
	  }

});

	
    $('[data-toggle="popover"]').popover({placement:'left'});  
	
	if($('option:first-child').attr('has_img') == 0){
					$("#add-img").addClass('hide');

		
	}
	else{
	
		$("#add-img").removeClass('hide');
	
	}
	
	
	$("option").on('click',function(){
		
		
	let hasImage = $(this).attr('has_img');
		
	if(hasImage == 0){
	
		$("#add-img").addClass('hide');

	}	
		else{
			$("#add-img").removeClass('hide');

		}
		
	});
	
});
	
	     function readURL(input) {
			 
			for(let i = 0 ; i < 3 ;i++)	{
            if (input.files && input.files[i]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#ad-'+(i+1))
                        .attr('src', e.target.result).removeClass('hide');
                };

                reader.readAsDataURL(input.files[i]);
            }
}
     
   }
</script>
@endsection
