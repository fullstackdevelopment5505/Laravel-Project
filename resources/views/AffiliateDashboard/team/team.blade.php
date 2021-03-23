@extends('AffiliateDashboard.master')
@section('content')
	<!-- main div start -->
	<div class="main_area">
		@include('AffiliateDashboard.layouts.sidebar');	
		<!-- right area start -->
		<section class="right_section">
			@include('AffiliateDashboard.layouts.header');	
			<!-- inside_content_area start-->
			<div class="content_area">
				@if ($message = Session::get('success'))
					<div class="alert alert-success alert-block">
						<button type="button" class="close" data-dismiss="alert">×</button>	
						<strong>{{ $message }}</strong>
					</div>
				@endif
				<div class="col-md-12">
					<div class="row row-eq-height">
						<div class="col-md-12 main_btn">
							<div class="flex_btn">
								<div class="tab_btn"></div>
								<!-- <div class="add_btn">
									<a href="{{route('salemanagerAddTeam')}}"><i class=" fa fa-plus"></i>Add New</a>
								</div> -->
							</div>
						</div>
						<!--property data start -->
						<div class="col-md-12 main_top_selling">
							<div class="inside">
								<table id="teamList" class="display  responsive nowrap" width="100%">
									<thead>
									    <tr>
									        <!-- <th>Sr No</th> -->
									        <th>Name</th>
									        <th>Email Id</th>
									        <th>Mobile</th>
									        <th>Department</th>
									        <!-- <th>City</th> -->
									        <th>Sales</th>
									        <th>Commision</th>
									        <!-- <th>Action</th> -->
									    </tr>
									</thead>
								
								</table>
							</div>
						</div>
						<!-- property data end -->
					</div>
				</div>
			</div>
			<!-- inside_content_area end-->
		</section>
		<!-- right area end -->
	</div>
	<!-- main div end -->
	<div class="modal fade" id="teamModal" aria-hidden="true">
<div class="modal-dialog modal-md">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" >Edit Team</h4>
		<button type="button" class="close" data-dismiss="modal">&times;</button>

    </div>
    <div class="modal-body ">
        <form id="productForm" name="productForm" class="form-horizontal" method="post" action="{{route('affiliate.updateTeam')}}">
           {{@csrf_field()}}
		   <div class="main_form">

		   <input type="hidden" name="id" id="id">
                <label>Name</label>
                    <input type="text" class="form-control fldtxt" id="first_name" name="first_name" placeholder="Enter name" value="" maxlength="50" required="">
                <label for="name" class="col-sm-2 control-label">Email</label>
                    <input type="text" class="form-control fldtxt" id="email" name="email" placeholder="Enter email" value="" maxlength="50" required="">
  
                <label class="col-sm-2 control-label">Mobile </label>
                    <input type="text" class="form-control fldtxt" id="phoneno" name="phoneno" placeholder="Enter mobile no." value="" required="">
                <!-- <label class="col-sm-2 control-label">City</label>
                    <input type="text" class="form-control fldtxt" id="city" name="city" placeholder="Enter city" value="" required="">
                <label class="col-sm-2 control-label">Department </label>
					<select class="fontsrm-control fldtxt" name="department" id="department">
						<option value="">--Choose-Department--</option>
						<option value="Marketing">Marketing</option>
						<option value="Accounts">Accounts</option>
						<option value="Development">Development</option>
					</select> -->
             <input type="submit" class="btn btn-success svbtn" id="btn-save" value="Save changes">
            </div>
        </form>
    </div>
    <div class="modal-footer">
         
    </div>
</div>
</div>
@endsection
@section('page_js')
<script type="text/javascript">
	$(document).ready(function() {
		$('#teamList').DataTable({
			"processing": true,
			"serverSide": true,
			"searching":false,
			"ajax": "{{ route('affiliate.teamList') }}",
			"columns":[
				// {"data": 'DT_RowIndex'},
				{ "data": "f_name",className:"first_name"},
				{"data":"email",className:"email"},
				{"data":"phone",className:"phoneno"},
				{"data":"department",name: 'department', orderable: false, searchable: false},
				// {"data":"city",className:"city"},
				{"data": 'sales', name: 'sales', orderable: false, searchable: false},
				{"data": 'commision', name: 'commision', orderable: false, searchable: false},
				// {"data": 'action',className:"action", name: 'action', orderable: false, searchable: false},
			],
			'createdRow': function( row, data, index ) {
				$(row).addClass( 'data-row' );
			},
			dom: 'lBfrtip',
			buttons: [
				'copy', 'csv', 'excel', 'pdf',
			],
		});
	});
	</script>
	<script>
		$(document).on('click', "#edit-team", function() {
			// alert("edit clicked");
			$(this).addClass('edit-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.
			var options = {
				'backdrop': 'static'
			};
			$('#teamModal').modal(options);
				// alert("clicked");
		});

		$(document).ready(function () {
			$("#editTeam").click(function () {
			});
			$('#teamModal').on('show.bs.modal', function() {
				// alert("i am here");
				var el = $(".edit-item-trigger-clicked");
				var row = el.closest(".data-row");
				var span = row.children(".action");
				
				var id = el.data('id');
				var name = row.children(".first_name").text();
				var email = row.children(".email").text();
				var phoneno = row.children(".phoneno").text();
				var city = row.children(".city").text();
				var department=row.children(".department").text();	
		
				// fill the data in the input fields
				$("input[name='id']").val(id);
				$("input[name='first_name']").val(name);
				$("input[name='email']").val(email);
				$("input[name='phoneno']").val(phoneno);
				$("select[name='department']").val(department);
				$("input[name='city']").val(city);
				
			});
			// on modal hide
			$('#teamModal').on('hide.bs.modal', function() {
				$('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
				$("#edit-form").trigger("reset");
				jQuery('.alert-danger').hide();
			});
		});
	</script>
	
@endsection	