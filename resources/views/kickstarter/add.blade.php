@extends('layouts.main')

@section('title')
Kickstarter Add
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
          .pad-top-30{
            padding:30px 0 30px 0;
          }
         </style>
@endsection

@section('content')

            <div class="breadcrumb_sec">
               <ul class="breadcrumb">
                  <li class="active msg"><a class="inactive_bread" href="#">Kickstarter Add</a></li>
               </ul>
            </div>
            <section class="table_design">
            
               <div class="offset-md-3 col-md-6 pad-top-30">
                          @if(session('success'))
                          <div class="alert alert-success">
                            <strong>Success!</strong> {{session('success')}}
                          </div>
                          @endif
                  <form action="" method="post" enctype= multipart/form-data>
                     @csrf
                    <div class="form-group">
                      <label for="name">Name:</label>
                      <input type="text" class="form-control" name="name" required placeholder="Enter Name" id="name">
                    </div>
                    <div class="form-group">
                      <label for="description">Desc:</label>
                      <textarea rows="5" name="description" required  class="form-control" id="description" placeholder="Enter Description"></textarea>
                    </div>
                    <div class="form-group ">
                      <label for="image">Image:</label>
                      <input type="file" name="image" required class="form-control" id="image">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>

               </div>
            </section>


@endsection

@section('js_files')
    <script src="{{ url('assets/js/sweetalert.min.js') }}"></script>
@endsection

@section('custom_js')



@endsection