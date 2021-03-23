@extends('layouts.main')

@section('title')
Privacy
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
         
<style type="text/css">
    textarea#Description {
        clear: both;
        height: 300px;
    }
</style>
@endsection

@section('content')

    <div class="breadcrumb_sec">
               <ul class="breadcrumb">
                  <li class="active msg"><a class="inactive_bread" href="#">Privacy</a></li>
               </ul>
            </div>
            <section class="table_design">
              @if(session('success'))
                <div class="alert alert-success">
                  <strong>Success!</strong> {{session('success')}}
                </div>
              @endif
              <form method="post" action>
                @csrf
                <textarea class="form-control" id="description" name="description">{!!$data->privacy!!}</textarea> 
                  <div class="form-group">
                    <br>
                    <button type="submit" class="btn btn-primary btn_view">Save</button>
                     <br>
                  </div>
                </form>
            </section>


@endsection

@section('js_files')
    <script src="{{ url('assets/js/sweetalert.min.js') }}"></script>
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
@endsection

@section('custom_js')
 <script type="text/javascript">

  CKEDITOR.replace("description");
            $(document).ready(function() {
                $('.myTable').DataTable({

                });
            });

           var selected=[];

            function delSelect() {
                  $("input[name='select[]']:checked").each(function (index, obj) {
                     var a=$(this).val();
                     selected.push(a);         
                    });
                  if(selected.length==0){
                                    swal({
                                        title: "Warning!",
                                        text: "Please select atleast one user.",
                                        type: "warning",
                                        showConfirmButton: true,
                                        // timer: 1000,
                                    },
                                    function () {
                                        return false;
                                    });
                  }
                  else{
                      swal({
                          title: "Are you sure?",
                          text: "You really want to delete selected user..!",
                          type: "warning",
                          showCancelButton: true,
                          confirmButtonClass: "btn-danger",
                          confirmButtonText: "Yes, delete it!",
                          closeOnConfirm: false,
                          showLoaderOnConfirm: true
                      },function(){
                           
                           $.ajax({
                            url: "{{ url('kickstarter/delete-multiple') }}",
                            type: "POST",
                            data: {
                                _method: "DELETE",
                                selected
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(resp){
                                if(resp == "1")
                                {
                                    swal({
                                        title: "Deleted!",
                                        text: "Users Deleted Successfully.",
                                        type: "success",
                                        showConfirmButton: true,
                                        // timer: 1000,
                                    },
                                    function () {
                                        location.reload()
                                    });
                                }
                                else
                                {
                                    swal({
                                        title: "Sorry!",
                                        text: "Unable to delete users. Please try again later.",
                                        type: "error",
                                        closeOnConfirm: true,
                                        // timer: 1000,
                                    }, 
                                    function () {
                                    });
                                }
                            }
                        });
                      })
                  }

            }


 </script>


@endsection