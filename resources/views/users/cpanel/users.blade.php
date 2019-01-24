@extends('adminlte::page')

@section('title', 'Ospaa Cpanel')

@section('content_header')

<h3 class="text-center">
	المستخدمين
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
                <th class="text-center">الاسم</th>
                <th class="text-center">البريد الالكتروني</th>
                <th class="text-center">تعديل</th>
                <th class="text-center">حذف</th>
                <th class="text-center">تاريخ الانضمام</th>
            </tr>
        </thead>
        <tfoot>
      
        <tbody>
           @foreach($users as $user)
            <tr class="text-center">
                <td>{{$user->name}} </td>
                <td>{{$user->email}}</td>
                <td><a class="btn btn-info"  data-toggle="modal" data-target="#user-data-{{$user->id}}">تعديل</a></td>
                <td>
                @if(Auth::id() !== $user->id)
                
                @foreach($user->roles as $role)
                              
											
					
                @endforeach
                
                <a href="{{route('user.delete',['id'=>$user->id])}}" class="btn btn-danger"
                 onclick="return confirm('تأكيد')">حذف</a></td>
                 
                @else
                <a href="#">----</a>
                @endif
                
                
                <td>{{$user->created_at->toDateString()}}</td>
            </tr>
         
<div class="modal fade" id="user-data-{{$user->id}}" role="dialog" dir="rtl">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><bdi>بيانات المستخدم : {{$user->name}}</bdi></h4>
        </div>
        <div class="modal-body">
        
          <form action="{{route('user.update',['id'=>$user->id])}}" method="POST" role="form">
	
		@csrf
		@method('post')
	<div class="form-group">
		<label >الاسم</label>
		<input type="text" class="form-control" name="name"value="{{$user->name}}">
	</div>
	<div class="form-group">
		<label >البريد الالكتروني</label>
		<input type="text" class="form-control" name="email" value="{{$user->email}}">
	</div>
	<div class="form-group">
		<label >كلمة المرور</label>
		<input type="password" class="form-control" name="password" value="{{$user->original_password}}">
	</div>
	<div class="form-group">
	
			<label> الصلاحيات </label>
			<br>
		
			
		@foreach($all_roles as $role)
		@if($role->id !== 1)
			<label>
		
			{{$role->role_name}}
			<input value="{{$role->id}}" type="checkbox" name="roles[]" value="{{$role->role_id}}"
			@if($role->users()->where('user_id',$user->id)->get()->count()==1)
			checked
			@endif
			>
			</label>

			<br>
			
			@endif
		@endforeach
		
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
<div class="row">
	{{$users->links()}}
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
