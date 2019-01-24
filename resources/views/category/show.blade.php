@extends('layouts.app')

@include('included.nav')
@section('title',"-")
@section('content')


@foreach($category as $ad)
<div class="row text-center">
{{Auth::id()}}
<h1>
	{{$ad->title}}
</h1>
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

	<p>
			{{$ad->created_at->diffForHumans()}}
		</p>
		<a href="{{route('ads.single',['id'=>$ad->id])}}" class="btn btn-success">رؤية المزيد</a>
  			
  	
	</div>
	<hr>

@endforeach
<div class="row text-center">
	{{$category->links()}}
</div>
@endsection


