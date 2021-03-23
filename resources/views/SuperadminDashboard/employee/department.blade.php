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
                        <!-- datepicker -->
                        <div class="col-sm-12 top_bar_area">
                            <div class="row">
                                <div class="col-sm-12 top_btns">
                                    <button class="btn btn-primary" id="add-department" data-url="{{ URL('/superadmin/department/') }}" data-toggle="modal" data-target="#departmentModal">Add New Departments<i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <!-- datepicker -->
                        <!--table start -->
						<div class="col-sm-12 top_selling">
                            @if(session()->get('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                            @endif
                            @if(session()->get('danger'))
                                <div class="alert alert-danger">
                                    {{ session()->get('danger') }}
                                </div>
                            @endif
							<div class="inside">
								<div class="title">Departments</div>
                                <table class="display responsive nowrap" id="department_list" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Department</th>
                                            <th>Created Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                </table>
							</div>
						</div>
                        <!--table end -->
					</div>
				</div>
			</div>
			<!-- inside_content_area end-->
	    </section>
	    <!-- right area end -->
    </div>
    <!-- main div end -->

    <!-- popup start from here-->
    <div class="modal fade" id="departmentModal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Add New Departments</b></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="" id="departmentForm" method="post" enctype= multipart/form-data>
                    @csrf
                    <div class="modal-body register_new_user">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Department Name</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer pl-0 pr-0">
                        <div class="col-md-12 text-center p-0"> 
                            <input type="hidden" id="department_id" name="department_id" value="" >  
                            <button type="button" id="save_department" class="btn btn-success save_department save_button">Add</button>
                            <button type="button" id="update_department" style="display:none;" class="btn btn-success save_department update_button">Update</button>
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
     validator = $('#departmentForm').validate({
        rules: {
            name:{
                required:true,
                alpha: true
            },
      },
            messages: {
            name:{
                required:"Please enter department name"
            },
        },
        errorPlacement: function(label, element) {
            label.addClass('text-danger');
            label.insertAfter(element);
        },
        wrapper: 'span'
    });
   
    $.validator.addMethod("alpha", function(value, element) {
         return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
     }, "Letters only please");
});
    //Add department ajax request

  $(document).on('click', ".save_department", function() {  
    if($("#departmentForm").valid()){ 

        var button_id     =   $(this).attr("id");
        var _token        =   $("input[name='_token']").val();
        var name          =   $("input[name='name']").val();
        var id            =   $("input[name='department_id']").val();
        var url           =   $('#departmentForm').attr('action');
        $.ajax({
            url: url,
            type:'POST',
            data: {_token:_token, id:id, name:name},
            success: function(data) {
                if($.isEmptyObject(data.error)){
                  
                    alert(data.success);
                    jQuery('.alert-danger').hide();
                    
                        $('#open').hide();
                        $('#departmentModal').modal('hide');
                        location.reload();
                }else{
                    // printErrorMsg(data.error);
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
  
    //on modal show
  
    $('#departmentModal').on('show.bs.modal', function() {
        
        var el = $(".edit-item-trigger-clicked"); // See how its usefull right here? 
        var department_id = el.data('department_id');
      
        if(typeof department_id !==  "undefined"){
          var row = el.closest(".data-row");
        
          // get the data
          var name = row.children(".name").text();
  
          // fill the data in the input fields
          $("input[name='department_id']").val(department_id);
          $("input[name='name']").val(name);
        }
    });
  
  
    //on edit button click set options
  
   $(document).on('click', "#edit-department", function() {
        $(this).addClass('edit-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.
  
        var options = {
          'backdrop': 'static'
        };
        
        $('#departmentModal').modal(options);
        $('#departmentForm').attr('action', $(this).data('url'));
        //show/hide button
        $('.save_button').hide();
        $('.update_button').show();
    });
  
    //on add button


    $(document).on('click', "#add-department", function() {
        $('#departmentForm').attr('action', $(this).data('url'));
        $('.save_button').show();
        $('.update_button').hide();

    });

    // on modal hide
    $('#departmentModal').on('hide.bs.modal', function() {
      $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
      $("#edit-form").trigger("reset");
      $("#departmentForm").trigger("reset");
      jQuery('.alert-danger').hide();
      
    });

    //show error message on submit
    function printErrorMsg (msg) {
      $(".print-error-msg").find("ul").html('');
      $(".print-error-msg").css('display','block');
      $.each( msg, function( key, value ) {
          $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
      });
    }
    $(document).ready(function() {
        $(document).on('click', '.delDepartment', function (e) {
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
                    type: "POST",
                    url: "{{URL('superadmin/department/delete/')}}/"+id,
                    data: {_token: "{{ csrf_token() }}"},
                    success: function(data){
                        
                        if($.isEmptyObject(data.error)){
                            
                            swal("Deleted!", data.success, "success"); 
                            $row.remove();
                            
                        }else{
                            
                            swal("Cancelled", data.error, "error");   
                        }

                    }       
                });
        });
    });
    $('#department_list').DataTable({
            "processing": true,
            "serverSide": true,
            "bDestroy": true,
            "ajax": "{{ route('superadminEmployee.departmentList') }}",   
            "rowId": "ShipmentId",
            "columns":[
                // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                { data: "name",className: "name"},
                {data:"created_at",className: "department_date", render: function(d){
					
					return moment(d).format("DD-MMM-YYYY");
					},
				},
                {data: 'action', className:"action", name: 'action', orderable: false, searchable: false},
            ],
            "createdRow": function ( row, data, index ) {
                    $(row).addClass('data-row');
            },
            dom: 'lBfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf',
            ],
        });
        
    }); 

    


</script>
@endsection 