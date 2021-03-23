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
                                    <button class="btn btn-primary" id="add-holiday" data-toggle="modal" data-url="{{ URL('/superadmin/holiday/') }}" data-target="#holidayModal">Add New Holiday<i class="fa fa-plus"></i></button>
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
								<div class="title">Holidays</div>
                                <table class="display responsive nowrap" width="100%" id="holiday_list">
                                    <thead>
                                        <tr>
                                            <th>Holiday Name</th>
                                            <th>Holiday Date</th>
                                            <th>Day</th>
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
    <div class="modal fade" id="holidayModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Add New Holiday</b></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="" method="post" id="holidayForm" enctype= multipart/form-data>
                    @csrf
                    <div class="modal-body register_new_user">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div> 
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Holiday Name</label>
                                    <input type="text" name="name" id="name" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Holiday Date</label>
                                    <input autocomplete="off" type="text" name="holiday_date" id="holiday_date" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pl-0 pr-0">
                        <div class="col-md-12 text-center p-0"> 
                            <input type="hidden" id="holiday_id" name="holiday_id" value="" >  
                            <button type="button" id="save_holiday" class="btn btn-success save_holiday save_button">Add</button>
                            <button type="button" id="update_holiday" style="display:none;" class="btn btn-success save_holiday update_button">Update</button>
                            <a href="#" type="btn" class="btn btn-secondary ml-1" data-dismiss="modal">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page_js')
<script> 
var validator;
$(function() {
     validator = $('#holidayForm').validate({
        rules: {
            name:{
                required:true,
                alpha: true
            },
            holiday_date:{
                required:true,
            }
        },
            messages: {
            name:{
                required:"Please enter name"
            },
            holiday_date:{
                required:"Please select date"
            }
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

    //Holiday add/edit bootstrap modal ajax

    //on modal show
    $(document).ready(function () {

    $('#holidayModal').on('show.bs.modal', function() {
      var el = $(".edit-item-trigger-clicked"); // See how its usefull right here? 
      var holiday_id = el.data('holiday_id');
        var row = el.closest(".data-row");
        var span = row.children(".action");

        // get the data
        var name = span.children("span.name").text();
        var holiday_date = span.children("span.holiday_date").text();

        // fill the data in the input fields
        $("input[name='holiday_id']").val(holiday_id);
        $("input[name='name']").val(name);
        $("input[name='holiday_date']").val(holiday_date);
      
  });
    //Add holiday ajax request

    $('.save_button').click(function(){ 
        if($("#holidayForm").valid()){ 

        var button_id     =   $(this).attr("id");
        var _token        =   $("input[name='_token']").val();
        var name          =   $("input[name='name']").val();
        var holiday_date  =   $("input[name='holiday_date']").val();
        var id            =   $("input[name='holiday_id']").val();
        var url           =   $('#holidayForm').attr('action');
       
        $.ajax({
            url: url,
            type:'POST',
            data: {_token:_token, id:id, name:name, holiday_date:holiday_date},
            success: function(data) {
                if($.isEmptyObject(data.error)){
                    
                    alert(data.success);
                    jQuery('.alert-danger').hide();
                    
                        $('#open').hide();
                        $('#holidayModal').modal('hide');
                        location.reload();
                }else{
                    $.each(data.responseJSON, function (key, value) {
                                var input = '#formArticle input[name=' + key + ']';
                                $(input + '+span>strong').text(value);
                                $(input).parent().parent().addClass('has-error');
                            });
                    // printErrorMsg(data.error);
                   
                    
                    
                }
            }
        });
    } 
        
    });

    //show error message on submit
    function printErrorMsg (msg) {
      $(".print-error-msg").find("ul").html('');
      $(".print-error-msg").css('display','block');
      $.each( msg, function( key, value ) {
          $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
      });
    }

        //on edit button click set options

    $(document).on('click', "#edit-holiday", function() {
        $(this).addClass('edit-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.

        var options = {
            'backdrop': 'static'
        };
        
        $('#holidayModal').modal(options);
        $('#holidayForm').attr('action', $(this).data('url'));
        //show/hide button
        $('.save_button').hide();
        $('.update_button').show();
    });


    //on add button


    $(document).on('click', "#add-holiday", function() {
        $('#holidayForm').attr('action', $(this).data('url'));
        $('.save_button').show();
        $('.update_button').hide();

    });
    // on modal hide
    $('#holidayModal').on('hide.bs.modal', function() {
        $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
        $("#edit-form").trigger("reset");
        $("#holidayForm").trigger("reset");
        jQuery('.alert-danger').hide();
        
    });
}); 
    $(document).ready(function() {
        $(document).on('click', '.delHoliday', function (e) {
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
                    url: "{{URL('superadmin/holiday/delete/')}}/"+id,
                    data: {_token: "{{ csrf_token() }}"},
                    success: function(data){
                        
                        if($.isEmptyObject(data.error)){
                            
                            swal("Deleted!", data.success, "success"); 
                            $row.remove();
							location.reload();
                            
                        }else{
                            
                            swal("Cancelled", data.error, "error");   
                        }

                    }       
                });
        });
    });
    $('#holiday_list').DataTable({
            "processing": true,
            "serverSide": true,
            "bDestroy": true,
            "ajax": "{{ route('superadminHolidayList') }}",   
            "rowId": "ShipmentId",
            "columns":[
                // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                { data: "name",className: "name"},
                
                {data:"holiday_date",className: "holiday_date", render: function(d){
					
					return moment(d).format("DD-MMM-YYYY");
					},
				},
				{data:"holiday_date",className:"day", render: function(d){
					
					return moment(d).format("dddd");
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