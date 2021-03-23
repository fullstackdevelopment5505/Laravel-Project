<!DOCTYPE html>
<html>
<head>
 <title>Laravel Send Email Example</title>
</head>
<body>
 
 <h1>This is test mail from Equity.com to reset password</h1>
 <p>Thank you, {{$data["subject"]}}</p>
 <p>{{$data["message"]}}</p>
 @if(isset($data['link']))
 <p><a href="{{$data['link']}}">Click here</a></p>
 @endif
</body>
</html> 
