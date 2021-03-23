@extends('SuperadminDashboard.master')
@section('content')
    <!-- main div start -->
    <div class="main_area">
        @include('SuperadminDashboard.layouts.sidebar');	
        <!-- right area start -->
        <section class="right_section">
            @include('SuperadminDashboard.layouts.header');	
			<!-- inside_content_area start-->
			<div class="content_area">
				<div class="col-sm-12">
					<div class="row">
                        <div class="col-sm-12 top_bar_area">
                            <div class="row">
                                <div class="col-sm-12 top_btns">
                                    <button class="btn btn-primary" id="add-team" data-toggle="modal" data-title="Add Team" data-url="{{ URL('/superadmin/cms/about/team/') }}" data-target="#createTeamModal">Add Team<i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>  
                        <!--table start -->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Teams</div>
									<table class="display responsive nowrap" id="teamWrap" width="100%">
										<thead>
										    <tr>
										        <th>Sr. No.</th>
                                                <th>Name</th>
                                                <th>Email</th>
												<th>Phone</th>
												<th>Profile Image</th>
												<th>Slider Image</th>
												<th>Position</th>
												<th>Status</th>
												<th>Actions</th>
										    </tr>
										</thead>
										<tbody>
                                         @foreach($aboutTeams as $aboutTeam)							    
                                            <tr>
                                                <td></td>
                                                <td>{{$aboutTeam->name}}</td>
                                                <td>{{$aboutTeam->email}}</td>
                                                <td>{{$aboutTeam->phone_number}}</td>
                                                <td> @if($aboutTeam->profile_image !="")
													<img width="150" src="{{asset($aboutTeam->profile_image)}}"/>
													@else - @endif  </td>
												
                                                <td>@if($aboutTeam->header_image !="")
													<img width="150" src="{{asset($aboutTeam->header_image)}}"/>
													@else - @endif</td>
                                                <td>{{$aboutTeam->designation}}</td>
                                                <td>
                                                    <input data-id="{{$aboutTeam->id}}" data-title="{{ $aboutTeam->status ? 'Deactivate' : 'Activate' }}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $aboutTeam->status ? 'checked' : '' }}>
                                                </td>
                                                <td>
                                                    <button data-url="{{URL::route('superadminCmsTeamEdit', $aboutTeam->id)}}" data-title="Edit Team" type="button" class="btn btn-success edit-item" id="edit-item" data-teamid="{{$aboutTeam->id}}" >Edit</button>
                                                    <a class="btn btn-danger deleteTeam" data-teamid="{{$aboutTeam->id}}" data-value="{{$aboutTeam->status}}" href="#">delete</a>
                                                  
                                                </td>
                                            </tr>
                                            @endforeach
										</tbody>
									</table>
								</div>
							</div>
							<!--table end-->
						</div>
					</div>
		        </div>
			    <!-- inside_content_area end-->
	    </section>
	    <!-- right area end -->
    </div>
    <!-- main div end -->
     <!-- popup start from here-->
     <div class="modal fade" id="createTeamModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
              
                <div class="modal-header">
                    <h4 class="modal-title"><b>Add New Team</b></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="/superadmin/cms/about/team/" method="post" id="TeamForm" enctype= multipart/form-data>
                <!-- <meta name="csrf-token" content="{!! csrf_token() !!}"> -->
                {{@csrf_field()}}
                <div class="modal-body register_new_user">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="hidden" name="team_id" class="form-control" id="team_id">
                                <input type="hidden" name="url" class="form-control" >
                                <input type="text" id="name" name="name" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email Id</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <label>Profile Image</label>
                                        <input type="file" class="form-control" name="profile_image"  />
                                    </div>
                                </div>
                                <div class="col-sm-3 profile_img">
                                    <img style="display: none" src="#">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <label>Header Image</label>
                                        <input type="file" class="form-control" name="header_image"  />
                                    </div>
                                </div>
                                <div class="col-sm-3 header_image">
                                    <img style="display: none" src="#">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Position</label>
                                <select id="designation" name="designation" class="form-control">
                                    <option value="" selected="selected" >Select Position</option>
                                    <optgroup>
                                        <option value="CEO">CEO</option>
                                        <option value="CAO">CAO</option>
                                        <option value="Manager">Manager</option>
                                        <option value="Partner">Partner</option>
                                        <option value="Advisor">Advisor</option>
                                    </optgroup>
                                 </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Phone No</label>
                                <input type="text" name="phone_number" id="phone" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Facebook URL</label>
                                <input type="text" name="facebook_url" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Linkedin URL</label>
                                <input type="text" name="linkedin_url" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="" selected="selected">Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                 </select>
                                 
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer pl-0 pr-0">
                    <div class="col-md-12 text-center p-0"> 
                        <button type="button" id="save_button" class="btn btn-success btn-submit save_button">Add</button>
                        <button type="button" id="update_button" style="display:none;" class="btn btn-success btn-submit update_button">Update</button>
                        <a href="#" type="btn" class="btn btn-secondary ml-1" data-dismiss="modal">Cancel</a>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
   
    <!-- popup end here-->
@endsection
@section('page_js') 
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>CKEDITOR.replace( 'description' );</script>
<script>
    var validator;
	$(document).ready(function () {
		$('#phone').usPhoneFormat({
			format: '(xxx) xxx-xxxx',
		});
		
		
	});
    $(function() {
        validator = $('#TeamForm').validate({
            rules: {
                name:{
                    required:true,
                    alpha: true
                },
                email:{
                    required:true,
                    email: true,
                    remote: {
                        url: "{{route('superadminCmsAjaxRequest')}}",
                        type: "GET",
                        async: false,
                        data: {
                            email: function () {
                                return $("input[name='email']").val();
                            },
                            id: function () {
                                return $("input[name='team_id']").val();
                            },
                            type: function () {
                                return 'checkEmail';
                            },
                        }
                    
                    }

                },
                phone_number:{ 
                    required:true,
					phoneUS: true
                } ,
                designation:{
                    required:true

                },
                status:{
                    required:true

                },
                profile_image: {
                    accept:"image/jpeg,image/png"
                
                },
               header_image: {
                    accept:"image/jpeg,image/png"
                
                }
            },
            messages: {
                phone_number:{
                        required:"Please enter a mobile number ",
                        digits: "Please enter only numbers"
                },
                profile_image: {
                    accept: "Please upload file in these format only (jpg, jpeg, png)."
                },
                header_image: {
                    accept: "Please upload file in these format only (jpg, jpeg, png)."
                },
                name:{
                    required:"Please enter name"
                },
                email:{
                    remote: "Email id already registred",
                    required:"Please enter email"
                }
            },
            errorPlacement: function(label, element) {
                label.addClass('text-danger');
                label.insertAfter(element);
            },
            wrapper: 'span'
        });
		$.validator.addMethod("phoneUS", function(phone_number, element) {
			phone_number= phone_number.replace(/[^0-9]/gi, '');
            return this.optional(element) || phone_number.length == 10;
        }, "Please specify a valid US phone number");
        $.validator.addMethod("alpha", function(value, element) {
            return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
        }, "Letters only please");
        
    });
    $("#teamWrap").on('shown.bs.modal', function() {
        CKEDITOR.replace('description', {
        height: '400px',
        width: '100%'
        });
    });
    $('.btn-submit').click(function(){
        if($("#TeamForm").valid()){ 
			$('#loader').show();
            var _token      =  $("input[name='_token']").val();
            var url         = $("input[name='url']").val();
            var data        =  new FormData($("#TeamForm")[0])
            data.append('description', CKEDITOR.instances['description'].getData());
            console.log(url);
            $.ajax({
                url: url,
                type:'POST',
                headers: {
                    'X-CSRF-TOKEN': _token
                },
                processData: false,
                contentType: false,
                data: data,
                success: function(data) {
                    if($.isEmptyObject(data.error)){
						$('#loader').hide();
                        alert(data.success);
                        jQuery('.alert-danger').hide();
                        $('#open').hide();
                        $('#createKickstarterModal').modal('hide');
                        location.reload();
                    }else{
                        printErrorMsg(data.error);
						$('#loader').hide();
                        $.each(data.responseJSON, function (key, value) {
                            var input = '#formArticle input[name=' + key + ']';
                            $(input + '+span>strong').text(value);
                            $(input).parent().parent().addClass('has-error');
                        });
                    }
                }
            });
        }
    });
    $("document").ready(function(){
        var t_aboutSliders =  $('#teamWrap').DataTable({
            "columns":[
                {data: "index", orderable: false, searchable: false},
                {data: "name"},
                {data: "email"},
                {data: "phone_number"},
                {data: "image", orderable: false, searchable: false},
                {data: "slider_image", orderable: false, searchable: false},
                {data: "position"},
                {data: "status", className: "status",  orderable: false, searchable: false },
                {data: 'action', className:"action", name: 'action', orderable: false, searchable: false},
            ],
           
            "order": [[ 0, 'desc' ]]          
        });

        t_aboutSliders.on( 'order.dt search.dt', function () {
            t_aboutSliders.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        }).draw();

    });
 //on add button
    $(document).on('click', "#add-team", function() {
       
       var options = {
           'backdrop': 'static'
       };
       $('#TeamForm')
           .find('[name="url"]')
           .val($(this).data('url'))
           .end();
       var title = $(this).data('title');
       var modal = $('#createTeamModal').modal(options);
       modal.find('.modal-title').text(title);
       $("#TeamForm").trigger("reset");
      
         CKEDITOR.instances.description.setData('');//destroy the existing editor
		 
       $(".profile_img").hide();
	   $(".profile_img").find("img").attr('src', '');
       $(".header_image").hide();
	   $(".header_image").find("img").attr('src', '');
       validator.resetForm();
       $('.save_button').show();
       $('.update_button').hide();
   });
    //Edit Team
    $(document).on('click', "#edit-item", function() {        
        $(this).addClass('edit-item-trigger-clicked'); 
        //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.
        var teamid = $(this).data("teamid");
        $('#TeamForm')
           .find('[name="url"]')
           .val($(this).data('url'))
           .end();
        $.ajax({
            type: "GET",
            url: "{{route('superadminCmsAjaxRequest')}}",
            data: { id: teamid, type: "getTeamById" },
            success: function(data) {                
                if ($.isEmptyObject(data.error)) {
                    //len = length;
                    //console.log("content "+data['data'].description);
                    if (data['data']) {
                        $("input[name='team_id']").val(data['data'].id);
                        $("input[name='name']").val(data['data'].name);
                        $("input[name='email']").val(data['data'].email);
                        $("#designation").val(data['data'].designation);
                  
                        CKEDITOR.instances['description'].setData(data['data'].description);
                        $("input[name='phone_number']").val(data['data'].phone_number);
                        $("input[name='facebook_url']").val(data['data'].facebook_url);
                        $("input[name='linkedin_url']").val(data['data'].linkedin_url);
                        $("#status").val(data['data'].status);
                        if (data['data'].profile_image) {
                            $(".profile_img img").attr('src', data['data'].profile_image);
                            $(".profile_img img").show();
                        } else {
                            $(".profile_img img").hide();
                        }   
                        if (data['data'].header_image) {
							$(".header_image img").attr('src', data['data'].header_image);
                            
                            $(".header_image img").show();
                        } else {
                            $(".header_image img").hide();
                        }   
                    } else {
                        alert("Something went wrong!");
                    }
                } else {
                    alert(data.error);               
                }
            }       
        });

        var options = {
            'backdrop': 'static'
        };
        var title = $(this).data('title');
        var modal = $('#createTeamModal').modal(options);
        modal.find('.modal-title').text(title);
        $('#TeamForm').find('[name="url"]').val($(this).data('url')).end();
        //show/hide button
        $("#TeamForm").trigger("reset");
        validator.resetForm();
        $('.save_button').hide();
        $('.update_button').show();
    });
  
    $(document).on('click', '.deleteTeam', function (e) {
        $row =  $(this).parent().parent();
        e.preventDefault();
        var teamid = $(this).data('teamid');
        swal({
                title: "Are you sure!",
                type: "error",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes!",
                showCancelButton: true,
            },
            function() {
            $.ajax({
                type: "GET",
                url: "{{route('superadminCmsAjaxRequest')}}",
                data: { id: teamid, type: "deleteTeam" },
                success: function(data){
                    
                    if($.isEmptyObject(data.error)){
                        
                        swal("Deleted!", data.success, "success"); 
						location.reload();
                        $row.remove();
                        
                    }else{
                        
                        swal("Cancelled", data.error, "error");   
                    }

                }       
            });
        });
    });
</script>
@endsection