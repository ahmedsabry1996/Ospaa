@extends('adminlte::page')

@section('title', 'Ospaa Cpanel')

@section('content_header')

<h3 class="text-center">
	الاعلانات
</h3>
@stop

@section('content')


@if($errors->any())

<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
</button>

	{{$errors}}
</div>

@endif
<table class="table table-responsive" dir="rtl">
        <thead class="text-center">
            <tr>
                <th class="text-center">الاعلان</th>
                <th class="text-center">صاحب الاعلان </th>
                <th class="text-center">مراجعة</th>
                <th class="text-center">حالة الاعلان</th>
                <th class="text-center">حذف</th>
                <th class="text-center">تاريخ الاضافة</th>
            </tr>
        </thead>
        <tfoot>
      
        <tbody>
           @foreach($ads as $ad)
            <tr class="text-center">
                <td>{{$ad->title}} </td>
                <td>{{$ad->user->name}}</td>
                
                <td><a class="btn btn-info"  data-toggle="modal" data-target="#ad-data-{{$ad->id}}">مراجعة</a></td>    
                <td>
                		@if($ad->is_approved)
                		<button class="btn btn-success">
     							تمت الموافقة	           		
                		</button>
                		@else
                		<button class="btn btn-warning">
         				لم تتم الموافقة
                		</button>
               				
                		
                		@endif

					</td>
                <td><a href="{{route('ads.cancel',['id'=>$ad->id])}}" class="btn btn-danger" onclick="return (confirm('sure?'))">حذف</a></td> 
                <td>{{$ad->created_at->diffForHumans()}}</td>
            </tr>
         
<div class="modal fade" id="ad-data-{{$ad->id}}" role="dialog" dir="rtl">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><bdi> مراجعة الاعلان : {{$ad->title}}</bdi></h4>
        </div>
        <div class="modal-body">
        
          <form action="{{route('ads.approve',['id'=>$ad->id])}}" method="POST" role="form">
	
		@csrf
		@method('post')
	<div class="form-group">
		<label >عنوان الاعلان</label>
		<input type="text" class="form-control" name="title" value="{{$ad->title}}">
	</div>
	<div class="form-group">
		<label >مكان الاعلان </label>
		<input type="text" class="form-control" name="address" value="{{$ad->address}}">
	</div>
	<div class="form-group">
		<label ><bdi>رقم الهاتف {{$ad->phone}}</bdi></label>
	</div>

	<div class="form-group">
		<label>القسم : {{$ad->category->category}}</label>
		
	</div>

	<div class="form-group">
		<labe>المحتوي</labe>
		<textarea name="content" style="resize:none;" class="form-control"  cols="30" rows="10">{{$ad->content}}</textarea>
</div>

	<div class="form-group">
	كلمات البحث
		<textarea name="tags" style="resize:none;" class="form-control" cols="30" rows="10">{{$ad->tags}}</textarea>
</div>
	<div class="row">

	@foreach($ad->imgs as $img)
	
	<div class="col-md-4">
			<img style="margin: 0 auto;" src="{{asset($img->path)}}" alt="{{$ad->title}}"  width="150" height="150">
			</div>
			
	@endforeach
	
	</div>
	<div class="form-group">
		<label class="form-control"> موافقة على النشر<input type="checkbox" name="is_approved" @if($ad->is_approved )
				checked
					@endif
		></label>
	</div>
	<br>
<div class="text-center">
	<button type="submit" class="btn btn-success">وافق على النشر</button>
</div>
 </form>
  
		
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق</button>
        </div>
      </div>
    </div>
  </div>
    
                          @endforeach
         
        </tbody>
    </table>
<div class="row">
	{{$ads->links()}}
</div>
    
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

