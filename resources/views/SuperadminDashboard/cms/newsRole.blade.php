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
								<div class="col-sm-4 from_to_filter">
									<div class="view_back"><a onClick="goBack();" href="javascript:void(0);"><i class="fa fa-arrow-left"></i></a></div>
									<div id="historyCount" style="display:none;">1</div>
									<div class="title">Back</div>
								</div>
                                <div class="col-sm-8 top_btns">
                                <button class="btn btn-primary" id="add-role" data-toggle="modal" data-title="Add Role" data-url="{{ URL::route('superadminAddnewsRole')}}" data-target="#createRoleModal">Add Role<i class="fa fa-plus"></i></button>
                                    <!--a class="btn btn-info" href="{{ URL('/superadmin/news/list/') }}"  data-title="view News"  >View News<i class="fa fa-eye"></i></a-->
									 <a class="btn btn-info" href="{{ URL('/superadmin/news/category/') }}"  data-title="view News"  >View Categories<i class="fa fa-eye"></i></a>
                                </div>
                            </div>
                        </div>  
                        <!--table start -->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Role List</div>
									<table class="display responsive nowrap" id="roleWrap" width="100%">
										<thead>
										    <tr>
										        <th>Sr. No.</th>
                                                <th>Role Name</th>
												<th>Actions</th>
										    </tr>
										</thead>
										<tbody>
                                         @foreach($data as $roles)							    
                                            <tr>
                                                <td></td>
                                                <td>{{$roles->role}}</td>
                                                <td>
                                                    <button data-url="{{URL::route('superadminViewNewsRoleEdit', $roles->id)}}" data-title="Edit Role" type="button" class="btn btn-success edit-role" id="edit-role" data-id="{{$roles->id}}" >Edit</button>
                                                    <a class="btn btn-danger deleteRole" data-id="{{$roles->id}}" href="#">delete</a>
                                                  
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
     <div class="modal fade" id="createRoleModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
              
                <div class="modal-header">
                    <h4 class="modal-title"><b>Add New Role</b></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="/superadmin/news/role" method="post" id="roleForm" >
                <!-- <meta name="csrf-token" content="{!! csrf_token() !!}"> -->
                {{@csrf_field()}}
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label>Role</label>
                                <input type="text" id="role" name="role" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer pl-0 pr-0">
                    <div class="col-md-12 text-center p-0"> 
						<input type="hidden" name="url" value="/superadmin/news/role" class="form-control">
						<input type="hidden" name="id" value="" class="form-control">
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
<script>
    var validator;
    $(function() {
        validator = $('#roleForm').validate({
            rules: {
                role:{
                    required:true
                }
            },
        
            errorPlacement: function(label, element) {
                label.addClass('text-danger');
                label.insertAfter(element);
            },
            wrapper: 'span'
        });
       
    });
  
    $('.btn-submit').click(function(){
        //debugger;
        if($("#roleForm").valid()){ 
			$('#loader').show();
            var _token      =  $("input[name='_token']").val();
            var role         = $("input[name='role']").val();
            var url        = $("input[name='url']").val();
			var id        = $("input[name='id']").val();
            $.ajax({
                url: url,
                type:'POST',
                headers: {
                    'X-CSRF-TOKEN': _token
                },
                data: { role: role, id:id, type: "news_role" },
                success: function(data) {

                    if($.isEmptyObject(data.error)){
						$('#loader').hide();
                        alert(data.success);
                        jQuery('.alert-danger').hide();
                        $('#createRoleModal').modal('hide');
                        location.reload();
                    }else{
                        printErrorMsg(data.error);
						$('#loader').hide();
                        // $.each(data.responseJSON, function (key, value) {
                        //     var input = '#formArticle input[name=' + key + ']';
                        //     $(input + '+span>strong').text(value);
                        //     $(input).parent().parent().addClass('has-error');
                        // });
                    }
                }
            });
        }
    });
    $("document").ready(function(){
        var t_aboutSliders =  $('#roleWrap').DataTable({
            "order": [[ 0, 'desc' ]]          
        });

        t_aboutSliders.on( 'order.dt search.dt', function () {
            t_aboutSliders.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        }).draw();

    });

   
 //on add button
    $(document).on('click', "#add-role", function() {
       
       var options = {
           'backdrop': 'static'
       };
       $('#roleForm')
           .find('[name="url"]')
           .val($(this).data('url'))
           .end();
       var title = $(this).data('title');
       var modal = $('#createRoleModal').modal(options);
       modal.find('.modal-title').text(title);
       $("#roleForm").trigger("reset");
      
      
       validator.resetForm();
       $('.save_button').show();
       $('.update_button').hide();
   });
    //Edit News
    $(document).on('click', "#edit-role", function() {        
        $(this).addClass('edit-item-trigger-clicked'); 
        //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.
        var id = $(this).data("id");
        $('#roleForm')
           .find('[name="url"]')
           .val($(this).data('url'))
           .end();
        $.ajax({
            type: "GET",
            url: "{{route('superadminCmsAjaxRequest')}}",
            data: { id: id, type: "getNewsRoleById" },
            success: function(data) {                
                if ($.isEmptyObject(data.error)) {
                    //len = length;
                    //console.log("content "+data['data'].description);
                    if (data['data']) {
                        $("input[name='id']").val(data['data'].id);
                        $("input[name='role']").val(data['data'].role);
                  
                        
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
        var modal = $('#createRoleModal').modal(options);
        modal.find('.modal-title').text(title);
        $('#roleForm').find('[name="url"]').val($(this).data('url')).end();
        //show/hide button
        $("#roleForm").trigger("reset");
        validator.resetForm();
        $('.save_button').hide();
        $('.update_button').show();
    });

    $(document).on('click', '.deleteRole', function (e) {
        $row =  $(this).parent().parent();
        e.preventDefault();
        var id = $(this).data('id');
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
                data: { id: id, type: "deleteNewsRoleById" },
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
    function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }
	goBack = function() {
        historyCount = parseInt($('#historyCount').text());
        history.go(-historyCount);
    }
    
</script>
@endsection