@extends('layouts.main')

@section('title')
Search List
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
                  <li class="active msg"><a class="inactive_bread" href="#">Search List</a></li>
               </ul>
            </div>
            <section class="table_design">
            
               <div class="padding_inside">
                  <table class="myTable display joined_data">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Email</th>
                           <th>Provided Email</th>
                           <th>Provided Phone</th>
                           <th>Status</th>
                           <th>Created</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                     	@foreach($user as $key=>$value)
                        <tr>
                           <td><input type="checkbox" name="select[]" value="{{$value->id}}"></td>
                           <td>{{$value->user->email}}</td>
                           <td>{{$value->email}} </td>
                           <td>{{$value->phone}} </td>
                           <td>{{($value->status==0? 'Pending' : ($value->status==1? 'Closed' : 'Rejected'))}}</td>
                           <td>{{$value->created_at}}</td>
                           <td>
                              <a href="{{URL('search/'.$value->id)}}"  class="btn btn_view a-btn-slide-text1 ">
                                <span><strong>Detail</strong></span>
                              </a>

                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
                  <a onclick="return delSelect()" href="#">Delete Selected</a>
               </div>
            </section>


        <div class="modal" id="myModal">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                     </button>
                  </div>
                  <!-- Modal body -->
                  <div class="modal-body">
                     <form class="my-model" method="post" onSubmit="return formSubmit()" action="">
                     	<h6 class="error_msg">&nbsp;</h6>
                        <div class="form-row">
                           <div class="form-group col-md-6 ">
                              <label for="first_name">First Name</label>
                              <input type="text" name="first_name" required id="first_name" value="{{ old('first_name') }}"  class="form-control" placeholder="First Name">
                           </div>                           
							<div class="form-group col-md-6 ">
                              <label for="last_name">Last Name</label>
                              <input type="text" name="last_name" required id="last_name" class="form-control" placeholder="Last Name">
                           	</div>                          
                           	<div class="form-group col-md-6">
                              <label for="email_phone">Email/Phone</label>
                              <input type="text"  name="email_phone" required id="email_phone" class="form-control" placeholder="Email/Phone">
                           	</div>
                           	<div class="form-group col-md-6">
                              <label for="password">Password</label>
                              <input type="password"  minlength="5" name="password" required id="password" class="form-control" placeholder="Password">
                           	</div>
        
                           	<div class="form-group btnGrp col-md-6">
                              <button type="submit" class="btn btn-primary">Save</button>
                           	</div>
                        </div>
                     </form>
                  </div>
                  <!-- Modal footer -->
                  <div class="modal-footer">
                     <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>
               </div>
            </div>
         </div>

@endsection

@section('js_files')
    <script src="{{ url('assets/js/sweetalert.min.js') }}"></script>
@endsection

@section('custom_js')
         <script type="text/javascript">
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
                                        text: "Please select atleast one search.",
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
                          text: "You really want to delete selected search..!",
                          type: "warning",
                          showCancelButton: true,
                          confirmButtonClass: "btn-danger",
                          confirmButtonText: "Yes, delete it!",
                          closeOnConfirm: false,
                          showLoaderOnConfirm: true
                      },function(){
                           
                           $.ajax({
                            url: "{{ url('search/delete-multiple') }}",
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
                                        text: "Aearch Deleted Successfully.",
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
                                        text: "Unable to delete search. Please try again later.",
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
	      <script>
	         function readURL(input) {
	             if (input.files && input.files[0]) {
	                 var reader = new FileReader();
	                 reader.onload = function(e) {
	                     $('#imagePreview').css('background-image', 'url('+e.target.result +')');
	                     $('#imagePreview').hide();
	                     $('#imagePreview').fadeIn(650);
	                 }
	                 reader.readAsDataURL(input.files[0]);
	             }
	         }
	         $("#imageUpload").change(function() {
	             readURL(this);
	         });
	      </script>

	      <script type="text/javascript">
	      	
	      	function formSubmit(argument) {
	      		var first_name=document.getElementById('first_name').value;
	      		var last_name=document.getElementById('last_name').value;
	      		var email_phone=document.getElementById('email_phone').value;
	      		var password=document.getElementById('password').value;

	      		$.ajax({
	      			url:'{{URL("users")}}',
	      			type:'POST',
	      			data:{
	      				first_name,
	      				last_name,
	      				email_phone,
	      				password,
	      				_token:$('meta[name="csrf-token"]').attr('content'),
	      				_method:'POST'
	      			},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    statusCode: {
                    200: function(data) {
				      location.reload();
				    },
				    422: function(data) {
				    	$('.error_msg').html(data.responseJSON.message);
				    },
				    500: function() {
				      alert('500 status code! server error');
				    }
				  }
	      		})

	      		return false;
	      	}

	      </script>

@endsection