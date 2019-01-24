<?php 
           $user_roles = array();
           
           ?>

@auth
<div class="hide">
	@foreach(Auth::user()->roles as $role)
	{{
	array_push($user_roles,$role->pivot->role_id)
	}}
	@endforeach
</div>
@endauth
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<style>

.navbar-default .dropdown-menu.notify-drop {
  min-width: 330px;
  background-color: #fff;
  min-height: 360px;
  max-height: 360px;
}
.navbar-default .dropdown-menu.notify-drop .notify-drop-title {
  border-bottom: 1px solid #e2e2e2;
  padding: 5px 15px 10px 15px;
}
.navbar-default .dropdown-menu.notify-drop .drop-content {
  min-height: 280px;
  max-height: 280px;
  overflow-y: scroll;
}
.navbar-default .dropdown-menu.notify-drop .drop-content::-webkit-scrollbar-track
{
  background-color: #F5F5F5;
}

.navbar-default .dropdown-menu.notify-drop .drop-content::-webkit-scrollbar
{
  width: 8px;
  background-color: #F5F5F5;
}

.navbar-default .dropdown-menu.notify-drop .drop-content::-webkit-scrollbar-thumb
{
  background-color: #ccc;
}
.navbar-default .dropdown-menu.notify-drop .drop-content > li {
  border-bottom: 1px solid #e2e2e2;
  padding: 10px 0px 5px 0px;
}
.navbar-default .dropdown-menu.notify-drop .drop-content > li:nth-child(2n+0) {
  background-color: #fafafa;
}
.navbar-default .dropdown-menu.notify-drop .drop-content > li:after {
  content: "";
  clear: both;
  display: block;
}
.navbar-default .dropdown-menu.notify-drop .drop-content > li:hover {
  background-color: #fcfcfc;
}
.navbar-default .dropdown-menu.notify-drop .drop-content > li:last-child {
  border-bottom: none;
}
.navbar-default .dropdown-menu.notify-drop .drop-content > li .notify-img {
  float: left;
  display: inline-block;
  width: 45px;
  height: 45px;
  margin: 0px 0px 8px 0px;
}
.navbar-default .dropdown-menu.notify-drop .allRead {
  margin-right: 7px;
}
.navbar-default .dropdown-menu.notify-drop .rIcon {
  float: right;
  color: #999;
}
.navbar-default .dropdown-menu.notify-drop .rIcon:hover {
  color: #333;
}
.navbar-default .dropdown-menu.notify-drop .drop-content > li a {
  font-size: 12px;
  font-weight: normal;
}
.navbar-default .dropdown-menu.notify-drop .drop-content > li {
  font-weight: bold;
  font-size: 11px;
}
.navbar-default .dropdown-menu.notify-drop .drop-content > li hr {
  margin: 5px 0;
  width: 70%;
  border-color: #e2e2e2;
}
.navbar-default .dropdown-menu.notify-drop .drop-content .pd-l0 {
  padding-left: 0;
}
.navbar-default .dropdown-menu.notify-drop .drop-content > li p {
  font-size: 11px;
  color: #666;
  font-weight: normal;
  margin: 3px 0;
}
.navbar-default .dropdown-menu.notify-drop .drop-content > li p.time {
  font-size: 10px;
  font-weight: 600;
  top: -6px;
  margin: 8px 0px 0px 0px;
  padding: 0px 3px;
  border: 1px solid #e2e2e2;
  position: relative;
  background-image: linear-gradient(#fff,#f2f2f2);
  display: inline-block;
  border-radius: 2px;
  color: #B97745;
}
.navbar-default .dropdown-menu.notify-drop .drop-content > li p.time:hover {
  background-image: linear-gradient(#fff,#fff);
}
.navbar-default .dropdown-menu.notify-drop .notify-drop-footer {
  border-top: 1px solid #e2e2e2;
  bottom: 0;
  position: relative;
  padding: 8px 15px;
}
.navbar-default .dropdown-menu.notify-drop .notify-drop-footer a {
  color: #777;
  text-decoration: none;
}
.navbar-default .dropdown-menu.notify-drop .notify-drop-footer a:hover {
  color: #333;
}
	.new-notification{
		color: red;
	}
	.fa-globe-asia{
		font-size: 21px;
	}
</style>
<nav class="navbar navbar-default" role="navigation">
	<div class="navbar-header">

		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<ul>
			<li class="dropdown visible-xs pull-right" style="position: relative;margin: 13px">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" id="show-notification-xs" aria-haspopup="true" aria-expanded="false">
			  <i class="fas fa-globe-asia fa-1x"></i>
						</a>
          <ul class="dropdown-menu notify-drop" style="margin: 20px -93px;top: 20px;">
            <div class="notify-drop-title">
            	<div class="row">
            	
            		<div class="col-md-6 col-sm-6 col-xs-6 text-right"><a href="" class="rIcon allRead" data-tooltip="tooltip" data-placement="bottom" title="كل الاشعارات"><i class="fa fa-dot-circle-o"></i></a></div>
            		
            		
            	</div>
            </div>
            <!-- end notify title -->
            
            <!-- notify content -->
            <div class="drop-content">
  
            	  
            </div>
           
			  
            
          </ul>
        </li>
</ul>
		<a class="navbar-brand" href="{{url('/')}}">Ospaa</a>
	</div>

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse navbar-ex1-collapse">

		<ul class="nav navbar-nav navbar-right">

			@guest
			
			
			<li class="nav-item">
				<a class="nav-link" href="{{ route('login') }}">الدخول</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('register') }}">
				التسجيل
				</a>
			</li>
					{{--show all ads--}}
				<li>

			
			@else
			<li class="nav-item dropdown">
				<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
				</a>

				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
						{{ __('Logout') }}
					</a>
					@if(in_array(2,$user_roles) || in_array(3,$user_roles) || in_array(4,$user_roles))
					<a href="#">ss</a>
					@endif
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						@csrf
					</form>
				</div>
			</li>
			@endguest
				{{--show all ads--}}
				<li>

				<a href="{{route('ads.show')}}">عرض الاعلانات</a>
			</li>
					
			{{--create new ads--}}
			<li>
				<a href="{{route('ads.create')}}">انشاء اعلان</a>
			</li>
			{{--all cateogries--}}
			@foreach($categories as $category)
			
				<li>
					<a href="{{route('category.show',['id'=>$category->id])}}">{{$category->category}}</a>
				</li>
			@endforeach
			@auth
			        <li class="dropdown hidden-xs">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" id="show-notification" aria-haspopup="true" aria-expanded="false">
			  <i class="fas fa-globe-asia fa-1x"></i>
						</a>
          <ul class="dropdown-menu notify-drop">
            <div class="notify-drop-title">
            	<div class="row">
            	
            		<div class="col-md-6 col-sm-6 col-xs-6 text-right"><a href="" class="rIcon allRead" data-tooltip="tooltip" data-placement="bottom" title="كل الاشعارات"><i class="fa fa-dot-circle-o"></i></a></div>
            		
            		
            	</div>
            </div>
            <!-- end notify title -->
            
            <!-- notify content -->
            <div class="drop-content">
  
            	  
            </div>
           
			  
            
          </ul>
        </li>

			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"> {{ Auth::user()->name }} <b class="caret"></b></a>
				<ul class="dropdown-menu">

					@guest
					<li class="nav-item">
						<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
					</li>
					@else

					@if(in_array(2,$user_roles) || in_array(3,$user_roles) || in_array(4,$user_roles))
					<li>
						<a href="{{route('user.home')}}">لوحة التحكم</a>
					</li>

					@endif
					<li>
						<a href="{{route('my.ads')}}">اعلاناتي</a>
					</li>	<li>
						<a data-toggle="modal" data-target="#myModal"> اعدادت الحساب</a>
					</li>
					<li>

						<a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
							خروج
						</a>
					</li>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						@csrf
					</form>
					@endguest
				</ul>
 <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">بيانات حسابك </h4>
        </div>
        <div class="modal-body">

		<form action="{{route('edit.my.data')}}" method="POST" role="form">
@csrf
	<div class="form-group">
		<label>الاسم</label>
		<input type="text" value="{{Auth::user()->name}}" class="form-control" required placeholder="الاسم" name="username">
	</div>
	<div class="form-group">
		<label>البريد الالكتروني</label>
		<input type="text" value="{{Auth::user()->email}}" class="form-control" required placeholder="email" name="email">
	</div>
	
	@if(Auth::user()->facebook_id)
			
	<p><bdi>			تم تسجيل دخولك عن طريق فيسبوك 
	<br>
	بامكانك انشاء كلمة مرور خاصة بك او المتابعة عن طريق فيس بوك	
</bdi></p>			
	@endif
	
	<div class="form-group">
		<label>كلمة المرور</label>
		<input type="password" value="{{Auth::user()->original_password}}" class="form-control" required placeholder="كلمة المرور" name="password">
	</div>
	



	<button type="submit" class="btn btn-primary">تعديل</button>
</form>
  
       
       </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق</button>
        </div>
      </div>
      
    </div>
  </div>
 
				
			</li>
			
@endauth
	
		</ul>
	</div><!-- /.navbar-collapse -->
	</nav>
