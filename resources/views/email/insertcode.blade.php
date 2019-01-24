<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Title Page</title>

		<!-- Bootstrap CSS -->
    <link rel="stylesheet" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">

		
	</head>
	<body>
		<h2 class="text-center"> 
    			يرجي مراجعة البريد الالكتروني الخاص بكم وادخال رمز التحقق ادناه
    	</h2>
			<form action="{{route('email.confirm')}}" method="POST" role="form">
	@csrf
	<div class="form-group">
		<input type="text" class="form-control" name="code">
	</div>



	<button type="submit" class="btn btn-primary">تحقق</button>
</form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
	</body>
</html>
