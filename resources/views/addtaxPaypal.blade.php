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
                background:  rgba(0, 0, 0, 0.5);
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
                <form action="{{route('affiliateAddTaxPaypal')}}" method="post">
                    {{@csrf_field()}}
                    <div class="form-group">
                        <label for="exampleInputTax">Tax Id</label>
                        <input type="text" class="form-control" id="taxid"  name="taxid" placeholder="Enter tax id" required="required">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Paypal Email </label>
                        <input type="email" class="form-control" id="paypal_email" name="paypal_email" placeholder="Enter paypal email" required="required">
                    </div>
                    <input type="hidden" name="user_id" value="{{$id}}">
                    <input type="submit" name="submit" class="btn btn-primary btn-lg" value="Submit">
                </form>
            </div>	
        </div>
        <script src="{{asset('assets/customer/js/jquery.min.js')}}"></script>
        <script src="{{asset('assets/customer/js/popper.min.js')}}"></script>
        <script src="{{asset('assets/customer/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/customer/js/custom.js')}}"></script>
    </body>
</html>