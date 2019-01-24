@extends('adminlte::page')

@section('title', 'Ospaa Cpanel')

@section('content_header')

<h3 class="text-center">
	
	
	خدمة العملاء
	</h3>

@stop

@section('content')

<table class="table table-striped text-center" dir="rtl">
        <thead>
            <tr>
                <th>صاحب الشكوى</th>
                <th>رابط الاعلان</th>
                <th>عرض الشكوى</th>
                <th>رد</th>
            </tr>
        </thead>
   
			<tbody>
            

@foreach($reports as $report)
   
          <tr>
                <td>{{$report->user->name}}</td>
                <td><a target="_blank" href="{{route('ads.single',['id'=>$report->ads_id])}}">عرض الاعلان</a>
		</td>
                <td><a class="btn btn-info" data-toggle="modal" data-target="#myModal-{{$report->id}}">عرض الشكوى</a></td>
                
                <td><a class="btn btn-info" data-toggle="modal" data-target="#reply-{{$report->id}}">رد</a></td>
            </tr>
            
             <div class="modal fade" id="myModal-{{$report->id}}" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">
      <bdi>
		
		  محتوى الشكوى
        
        </bdi>
        
        </h4>
        </div>
        <div class="modal-body">

			<h3>
				{{$report->report}}
				
			</h3>
  
       
       </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق</button>
        </div>
      </div>
      
    </div>
  </div>
   
   {{--Add Reply--}}
             <div class="modal fade" id="reply-{{$report->id}}" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">
      <bdi>
		
		  محتوى الشكوى
        
        </bdi>
        
        </h4>
        </div>
        <div class="modal-body">

			<form action="{{route('reply',['id'=>$report->user->id])}}" method="POST" role="form">
			@csrf
	<legend> رد على الشكوى </legend>

	<div class="form-group">
		<textarea required="required" class="form-control" name="reply" style="resize: none ; direction: rtl"></textarea>
	</div>


	<div class="text-center">
	<button type="submit" class="btn btn-success">ارسال</button>
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
