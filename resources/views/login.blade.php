<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Equity</title>
        <meta charset="UTF-8" />
        <meta name="keywords" content="HTML,CSS,XML,JavaScript" />
        <meta name="description" content="Free Web tutorials" />
        <meta name="author" content="Equity" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="{{asset('assets/customer/css/bootstrap.min.css')}}" />
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800i&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{asset('assets/customer/css/style.css')}}" />
        <style type="text/css">
            body{
                background: url('assets/customer/images/background.jpg') rgba(0, 0, 0, 0.5);
                background-size: cover;
                background-blend-mode:overlay;
            }
        </style>
    </head>
    <body>
        <div class="login_wrap">
            <div class="login_logo"><img src="{{asset('assets/customer/images/logo.png')}}"></div>
            <div class="sign-in-htm">
                @if(Session::has('error'))
                    <div class="alert alert-danger">
                        {{Session::get('error')}}
                    </div>
                @endif
                <form action="{{route('login')}}" method="post">
                    {{@csrf_field()}}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1"  name="email" placeholder="Enter email" required="required">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password" required="required">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Remember Me</label>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary btn-lg" value="Login">
                </form>
            </div>	
        </div>
        <div class="forgot">
            <span>Do not worry if you forgot your password. just click the below links</span>
            <a href="#">Forgot Password?</a>
        </div>
        <script src="{{asset('assets/customer/js/jquery.min.js')}}"></script>
        <script src="{{asset('assets/customer/js/popper.min.js')}}"></script>
        <script src="{{asset('assets/customer/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/customer/js/custom.js')}}"></script>
    </body>
</html>