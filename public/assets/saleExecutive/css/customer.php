<!DOCTYPE html>
<html lang="en-US">
<head>
<title>Customer</title>
<meta charset="UTF-8" />
<meta name="keywords" content="HTML,CSS,XML,JavaScript" />
<meta name="description" content="Free Web tutorials" />
<meta name="author" content="Equity" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="assets/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="assets/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="assets/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="assets/css/owl.carousel.min.css" />
<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="assets/css/style.css" />
<link rel="stylesheet" href="assets/css/pages.css" />
<style type="text/css">
.mapael .map {position: relative;}
.mapael .mapTooltip {
    position: absolute;
    background-color: #fff;
    moz-opacity: 0.70;
    opacity: 0.70;
    filter: alpha(opacity=70);
    border-radius: 10px;
    padding: 10px;
    z-index: 1000;
    max-width: 200px;
    display: none;
    color: #343434;
}
.mapcontainer_miller {margin-top:10px;}

</style>
</head>
<body>
<!-- main div start -->
<div class="main_area">
	<?php include"sidebar.php";?>
	
	<!-- right area start -->
	<section class="right_section">
	<?php include"header.php";?>

			<!-- inside_content_area start-->
			<div class="content_area">
				<div class="col-md-12">
						<div class="row row-eq-height">

							<div class="col-md-12 main_btn">
								<div class="flex_btn">
									<div class="tab_btn"></div>
									<div class="add_btn">
										<a href="JavaScript:void()" data-toggle="modal" data-target="#myModal"><i class=" fa fa-plus"></i>Add New</a>
									</div>
								</div>
							</div>
							<div class="col-sm-12 customer_tabs">
								<ul class="nav nav-pills">
									<li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#sale_manager">Sales Manager</a></li>
									<li class="nav-item"><a class="nav-link" data-toggle="pill" href="#sale_executive">Sales Executive</a></li>
								</ul>
							</div>


							<div class="tab-content">
								<!--property data start -->
								<div class="col-sm-12  tab-pane top_selling active" id="sale_manager">
									<div class="inside">
										<table id="property_data" class="display display2 responsive nowrap" width="100%">
										    <thead>
												<tr>
													<th>Sr. No.</th>
													<th>Name</th>
													<th>Location</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>1</td>
													<td>John Doe</td>
													<td>California</td>
													<td><a href="message.php?active=message" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>2</td>
													<td>Leon kennedy</td>
													<td>California</td>
													<td><a href="message.php?active=message" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>3</td>
													<td>Chris Redfill</td>
													<td>California</td>
													<td><a href="message.php?active=message" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>4</td>
													<td>John Doe</td>
													<td>California</td>
													<td><a href="message.php?active=message" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>5</td>
													<td>Leon kennedy</td>
													<td>California</td>
													<td><a href="message.php?active=message" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>6</td>
													<td>Chris Redfill</td>
													<td>California</td>
													<td><a href="message.php?active=message" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>7</td>
													<td>Chris Redfill</td>
													<td>California</td>
													<td><a href="message.php?active=message" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>8</td>
													<td>Chris Redfill</td>
													<td>California</td>
													<td><a href="message.php?active=message" class="btn btn-success">Message</a></td>
												</tr>
											</tbody>
										</table>

									</div>
								</div>
								<!-- property data end -->
								<!--property data start -->
								<div class="col-sm-12  tab-pane top_selling fade" id="sale_executive">
									<div class="inside">
										<table id="property_data" class="display display2 responsive nowrap" width="100%">
										    <thead>
												<tr>
													<th>Sr. No.</th>
													<th>Name</th>
													<th>Location</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>1</td>
													<td>John Doe</td>
													<td>California</td>
													<td><a href="message.php?active=message" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>2</td>
													<td>Leon kennedy</td>
													<td>California</td>
													<td><a href="message.php?active=message" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>3</td>
													<td>Chris Redfill</td>
													<td>California</td>
													<td><a href="message.php?active=message" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>4</td>
													<td>John Doe</td>
													<td>California</td>
													<td><a href="message.php?active=message" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>5</td>
													<td>Leon kennedy</td>
													<td>California</td>
													<td><a href="message.php?active=message" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>6</td>
													<td>Chris Redfill</td>
													<td>California</td>
													<td><a href="message.php?active=message" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>7</td>
													<td>Chris Redfill</td>
													<td>California</td>
													<td><a href="message.php?active=message" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>8</td>
													<td>Chris Redfill</td>
													<td>California</td>
													<td><a href="message.php?active=message" class="btn btn-success">Message</a></td>
												</tr>
											</tbody>
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

<!-- add-customer-popup -->
<!-- The Modal -->
<div class="modal fade" id="myModal">
<div class="modal-dialog modal-md">
  <div class="modal-content">
  
    <!-- Modal Header -->
    <div class="modal-header">
      <h4 class="modal-title">Add Customer</h4>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    
    <!-- Modal body -->
    <div class="modal-body">
      <div class="main_form">
      	<label>Name</label>
      	<input type="text" class="form-control fldtxt" name="">
      	<label>Email Id</label>
      	<input type="text" class="form-control fldtxt" name="">
      	<label>Phone No.</label>
      	<input type="text" class="form-control fldtxt" name="">
      	<label>City</label>
      	<input type="text" class="form-control fldtxt" name="">
      	<button class="btn btn-success svbtn">Save</button>
      </div>
    </div>
   
  </div>
</div>
</div>
<!-- add-customer-popup -->





<script src="assets/js/jquery.min.js"></script>
<!-- datatable start-->
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.responsive.min.js"></script>
<script src="assets/js/dataTables.buttons.min.js"></script>
<script src="assets/js/jszip.min.js"></script>
<script src="assets/js/pdfmake.min.js"></script>
<script src="assets/js/vfs_fonts.js"></script>
<script src="assets/js/buttons.html5.min.js"></script>
<!-- datatable end-->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<!-- chart js start-->
<script src="assets/js/chart.min.js"></script>
<script src="assets/js/utils.js"></script>
<!-- end chart js -->

<!-- map-visitor -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.2.7/raphael.min.js" charset="utf-8"></script>
<script src="assets/js/jquery.mapael.js" charset="utf-8"></script>
<script src="assets/js/world_countries.js" charset="utf-8"></script>
<script src="assets/js/world_countries_mercator.js" charset="utf-8"></script>
<script src="assets/js/world_countries_miller.js" charset="utf-8"></script>

<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/custom.js"></script>
<script>
$('.display').DataTable({
    responsive: true,
    dom: 'lBfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
        ]
});
</script>
</body>
</html>