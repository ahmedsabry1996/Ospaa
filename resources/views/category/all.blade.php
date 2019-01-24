
@extends('adminlte::page')

@section('title', 'Ospaa Cpanel')

@section('content_header')

<h3 class="text-center">
أقسام الموقع	
	
	</h3>

@stop

@section('content')


    
<div class="row text-center" >
	<form action="{{route('category.create')}}" method="POST" role="form" class="col-md-4 col-md-push-4" enctype="multipart/form-data">
	@csrf
	<div class="form-group text-right">
					<label> اسم القسم</label>

		<input type="text" dir="rtl" name="category" class="form-control" placeholder="انشاء قسم">
	</div>
	<div class="form-group text-right">
			<label> <bdi>اختر ايقونة (اختياري)</bdi></label>
		<input type="file" name="icon" class="form-control" >
	</div>

	<div class="form-group">
		<label>
		
		تمكين خاصية تحديد المكان <input type="checkbox" name="has_map" value="1"></label>
	</div>
	<div class="form-group">
		<label>
		تمكين خاصية رفع صور <input type="checkbox" name="has_img" value="1"></label>
	</div>
	
	<button type="submit" class="btn btn-primary">اضافة</button>
</form>

</div>
<hr>
	{{--all categories--}}
<table class="table table-hover" dir="rtl">
        <thead>
            <tr class="text-center">
                <th class="text-center">القسم</th>
                <th class="text-center">تعديل</th>
                <th class="text-center">حذف</th>
                <th class="text-center">تاريخ الانشاء</th>
            </tr>
        </thead>

        <tbody>
        @foreach($categories as $category)
        
            <tr class="text-center">
                <td>{{$category->category}}</td>
                <td><button class="btn btn-primary" data-toggle="modal" data-target="#cat-{{$category->id}}">تعديل</button></td>
                <td><a href="{{route('category.delete',['id'=>$category->id])}}" onclick="return confirm('تأكيد')" class="btn btn-danger">حذف</a></td>
                <td>{{$category->created_at->diffForHumans()}}</td>
            </tr>
                 
<div class="modal fade modal-md" id="cat-{{$category->id}}" role="dialog" dir="rtl">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><bdi>بيانات القسم : {{$category->category}}</bdi></h4>
        </div>
        <div class="modal-body">
        
          <form action="{{route('category.edit',['id'=>$category->id])}}" method="POST" role="form" enctype="multipart/form-data">
	
		@csrf
		@method('post')
	<div class="form-group">
		<input type="text" class="form-control" name="category" value="{{$category->category}}">
	</div>

<div class="form-group">
		<label>
		
		تمكين خاصية تحديد المكان <input type="checkbox" name="has_map" value="1"
		@if($category->has_map)
		checked
		@endif
		
		></label>
	</div>
	<div class="icon">
		
	<img src="{{asset($category->icon)}}" alt="{{$category->category}}" class="img-circle" width="70" height="70">
	</div>
	<div class="form-group">
	<label> اختر ايقونة</label>
		<input type="file" name="icon">
	</div>
<div class="form-group">
		<label>
		
		تمكين خاصية  رفع صور <input type="checkbox" name="has_img" value="1"
		@if($category->has_img)
		checked
		@endif
		
		></label>
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
    
        @endforeach
       
        </tbody>
    </table>
    {{--pagination--}}
<div class="row text-center">
	{{$categories->links()}}
</div>
    
@stop
