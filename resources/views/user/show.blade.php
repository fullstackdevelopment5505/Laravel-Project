@extends('layouts.main')

@section('title')
Users Detail
@endsection

@section('css_files')
    <link rel="stylesheet" href="{{ url('assets/css/sweetalert.css')  }}">
@endsection

@section('custom_css')
         <style type="text/css">
 
            .imagePreview {
            width: 100%;
            height: 180px;
            background-position: center center;
            background: url(http://cliquecities.com/assets/no-image-e3699ae23f866f6cbdf8ba2443ee5c4e.jpg);
            background-color: #fff;
            background-size: cover;
            background-repeat: no-repeat;
            display: inline-block;
            box-shadow: 0px -3px 6px 2px rgba(0, 0, 0, 0.2);
            }
            .btn-primary {
            display: block;
            border-radius: 0px;
            box-shadow: 0px 4px 6px 2px rgba(0, 0, 0, 0.2);
            margin-top: -5px;
            }
            .imgUp {
            margin-bottom: 15px;
            }
            .del {
            position: absolute;
            top: 0px;
            right: 15px;
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            background-color: rgba(255, 255, 255, 0.6);
            cursor: pointer;
            }
            .imgAdd {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #4bd7ef;
            color: #fff;
            box-shadow: 0px 0px 2px 1px rgba(0, 0, 0, 0.2);
            text-align: center;
            line-height: 30px;
            margin-top: 0px;
            cursor: pointer;
            font-size: 15px;
            }
            .demo-bg{
            background: #ffac0c;
            margin-top: 60px;
            }

			.intrest.intrest2 .tokenfield.form-control {
			padding-bottom: 22px;
		    }
		    .joined_data,.modal{
		    	text-align: left;
		    }
         </style>
@endsection

@section('content')

    <div class="breadcrumb_sec">
               <ul class="breadcrumb">
                  <li class="active msg"><a class="inactive_bread" href="#">Users Detail</a></li>
               </ul>
            </div>
            <section class="table_design">
              @if(session('success'))
                <div class="alert alert-success">
                  <strong>Success!</strong> {{session('success')}}
                </div>
              @endif
              <form action="excel" method="post" enctype="multipart/form-data">
                @csrf
                <div >
                  <label for="file">File</label>
                  <input type="file" id="csv" required="" class="form-control" name="csv">
                  <input type="hidden"  name="user_id" value="{{$user->id}}">
                </div>
                <div>
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </form>

            </section>




@endsection

@section('js_files')
    <script src="{{ url('assets/js/sweetalert.min.js') }}"></script>
@endsection

@section('custom_js')
         <script type="text/javascript">


         </script>
	     

@endsection