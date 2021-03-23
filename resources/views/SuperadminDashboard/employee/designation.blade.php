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
                            <div class="row">
                                <div class="col-sm-12 top_btns">
                                    <button class="btn btn-primary" id="add-role" data-toggle="modal" data-url="{{ URL('/superadmin/designation/') }}" data-target="#roleModal">Add New Designation<i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <!-- datepicker -->
                        <!--table start -->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Designation</div>
                                <table class="display responsive nowrap" id="designation_list" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Designation</th>
                                            <th>Department</th>
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
    <div class="modal fade" id="roleModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Add New Designation</b></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="" id="roleForm" method="post" enctype= multipart/form-data>
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <div class="modal-body register_new_user">
                         <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Designation</label>
                                    <input type="text" name="role" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Department Name</label>
                                    <select name="department_id" id="department_id" class="form-control">
                                        <option value="">Select Department</option>
                                        @foreach($departments as $value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer pl-0 pr-0">
                        <div class="col-md-12 text-center p-0"> 
                              <input type="hidden" id="id" name="id" value="" >  
                            <button type="button" id="save_role" class="btn btn-success save_role save_button">Add</button>
                            <button type="button" id="update_role" style="display:none;" class="btn btn-success save_role update_button">Update</button>
                            <a href="#" type="btn" class="btn btn-secondary ml-1" data-dismiss="modal">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- popup ends here-->
@endsection
@section('page_js')
<script>
$(function() {
     validator = $('#roleForm').validate({
        rules: {
            role:{
                required:true,
                alpha: true
            },
            department_id:{
                required:true,

            }
      },
            messages: {
            role:{
                required:"Please enter designation name"
            },
            department_id:"Please select department"
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
    //on modal show

    $('#roleModal').on('show.bs.modal', function() {
      
      var el = $(".edit-item-trigger-clicked"); // See how its usefull right here? 
      var id = el.data('id');
    
      if(typeof id !==  "undefined"){
            var row = el.closest(".data-row");
        
            // get the data
            var role = row.children(".role").text();
            var department_id = row.children(".department_id").data('id');
           
            // fill the data in the input fields
            $("input[name='id']").val(id);
            $("input[name='role']").val(role);
         
            $('[name=department_id] option').filter(function() { 
                return ($(this).val() == department_id); //To select Blue
            }).prop('selected', true);
      }
  });
    $(document).on('click', ".save_role", function() {  
        if($("#roleForm").valid()){
        var button_id     =   $(this).attr("id");
        var _token        =   $("input[name='_token']").val();
        var role          =   $("input[name='role']").val();
        var id            =   $("input[name='id']").val();
        var department_id =   $("select[name='department_id']").val();
        var url           =   $('#roleForm').attr('action');
        
        $.ajax({
            url: url,
            type:'POST',
            data: {_token:_token, id:id, role:role, department_id:department_id},
            success: function(data) {
                if($.isEmptyObject(data.error)){
                    alert(data.success);
                    jQuery('.alert-danger').hide();
                    
                        $('#open').hide();
                        $('#roleModal').modal('hide');
                        location.reload();
                }else{
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

    //edit role
    $(document).on('click', "#edit-role", function() {
        $(this).addClass('edit-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.
  
        var options = {
          'backdrop': 'static'
        };
        
        $('#roleModal').modal(options);
        $('#roleForm').attr('action', $(this).data('url'));
        //show/hide button
        $('.save_button').hide();
        $('.update_button').show();
    });


    //add role button click
    $(document).on('click', "#add-role", function() {
        $('#roleForm').attr('action', $(this).data('url'));
        $('.save_button').show();
        $('.update_button').hide();

    });
    // on modal hide
    $('#roleModal').on('hide.bs.modal', function() {
        $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
        $("#edit-form").trigger("reset");
        $("#roleForm").trigger("reset");
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
        $(document).on('click', '.delDesignation', function (e) {
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
                    url: "{{URL('superadmin/designation/delete/')}}/"+id,
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
    $('#designation_list').DataTable({
            "processing": true,
            "serverSide": true,
            "bDestroy": true,
            "ajax": "{{ route('superadminEmployee.designationList') }}",   
            "rowId": "ShipmentId",
            "columns":[
                // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                { data: "role",className: "role"},
                {data:"department"},
                // {data:"created_at",className: "department_date"},
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
