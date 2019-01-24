@extends('adminlte::page')

@section('title', 'Ospaa Cpanel')

@section('content_header')

<h3 class="text-center">
	
كلمات البحث	

</h3>

@stop

@section('content')


	
<div class="row text-center" >
	<form action="{{route('tag.create')}}" method="POST" role="form" class="col-md-4 col-md-push-4">
	@csrf
	<div class="form-group">
		
		<input type="text" dir="rtl" name="tag" class="form-control" placeholder="ادخل كلمة">
	</div>

	
	<button type="submit" class="btn btn-primary">اضافة</button>
</form>

</div>
<hr>
	{{--all tags--}}
<table class="table table-hover" dir="rtl">
        <thead>
            <tr class="text-center">
                <th class="text-center">الكلمة</th>
                <th class="text-center">تعديل</th>
                <th class="text-center">حذف</th>
                <th class="text-center">تاريخ الانشاء</th>
            </tr>
        </thead>

        <tbody>
        @foreach($tags as $tag)
        
            <tr class="text-center">
                <td>{{$tag->tag}}</td>
                <td><button class="btn btn-primary" data-toggle="modal" data-target="#cat-{{$tag->id}}">تعديل</button></td>
                <td><a href="{{route('tag.delete',['id'=>$tag->id])}}" onclick="return confirm('تأكيد')" class="btn btn-danger">حذف</a></td>
                <td>
                <bdi>
                {{$tag->created_at->diffForHumans()}}
                </bdi>
                </td>
            </tr>
                 
<div class="modal fade modal-md" id="cat-{{$tag->id}}" role="dialog" dir="rtl">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><bdi>{{$tag->tag}}</bdi></h4>
        </div>
        <div class="modal-body">
        
          <form action="{{route('tag.edit',['id'=>$tag->id])}}" method="POST" role="form">
	
		@csrf
		@method('post')
	<div class="form-group">
		<input type="text" class="form-control" name="tag" value="{{$tag->tag}}">
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
	{{$tags->links()}}
</div>    
    
@stop


