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
                <div class="col-sm-12 top_bar_area">
					<div class="row">
						<div class="col-sm-8 from_to_filter">
                            <div class="view_back"><a onClick="goBack();" href="javascript:void(0);"><i class="fa fa-arrow-left"></i></a></div>
							<div id="historyCount" style="display:none;">1</div>
                            <div class="title">Profile</div>
						</div>
                        <div class="col-sm-4 top_btns">
                            <a href="send-message.php?active=custom" class="btn btn-success">Message <i class="fa fa-envelope"></i></a>
                            <div class="status_button_wrap">
                         
								<a data-id="0" href="javascript:void(0);" class="btn btn-danger updateStatus">Deactivate <i class="fa fa-user-times"></i></a>
                         
							
                            </div>
                        </div>
					</div>
				</div>
				<!-- main row start-->
				<div class="col-sm-12">
					<div class="row">
					
					
						<!--Parent div start -->
						<div class="col-sm-8 top_selling profile_whole_detail">
							<div class="inside">
                                <div class="row">
                                    <div class="col-sm-12 all_customer_data">
                                        <div class="profile_pic">
                                            <img src="{{asset('assets/customer/images/user.jpg')}}">
                                        </div>
                                        <div class="profile_left">
                                            <h1>{{$member->f_name." ".$member->l_name}}</h1>
                                            <div class="member"><a href="#"><img src="{{asset('assets/customer/images/trophy.png')}}">Member </a></div>      
                                            <p><i class="fa fa-map-marker"></i> <span>{{$member->address}}</span></p>
                                            <p><i class="fa fa-envelope"></i> <span>Email: {{$member->email}}</span></p>
                                        </div>
                                        <div class="profile_right">
                                            <p><i class="fa fa-flag"></i> <span>Country: United States</span></p>
                                            <p><i class="fa fa-map"></i> <span>State: {{$member->state_name}}</span></p>
                                            <p><i class="fa fa-map-pin"></i> <span>City: {{$member->city_name}}</span></p>
                                            <p><i class="fa fa-map-signs"></i> <span>Postal Code: {{$member->postal}}</span></p>
                                            <p><i class="fa fa-phone"></i> <span>Phone No: {{$member->phone}}</span></p>
                                        </div>
                                    </div>
                                </div>
							</div>
						</div>
                        <!--Parent div end-->
                        <!--Parent div start -->
                       
						<div class="col-sm-4 top_selling customer_joined_details">
							<div class="inside">
                                <div class="customer_other_details">
                                    <ul>
                                        <li>
                                            <strong>Joining Date:</strong>
                                                <p>{{date('d/m/Y', strtotime($member->membership_purchase_date))}}</p>
                                        </li>
                                         <li>
                                            <strong>Report Purchased:</strong>
                                            <p>-</p>
                                        </li>
                                        <li>
                                            <strong>Sales Manager:</strong>
                                            <p>{{$sale_managerName}}</p>
                                        </li>
                                        <li>
                                            <strong>Sales Executive:</strong>
                                            <p>{{$sale_executiveName}}</p>
                                        </li> 
                                    </ul>
                                </div>
							</div>
                        </div>
                      
                       
                                
                        
                                    <div class="col-sm-8 top_selling"> 
                                        <div class="inside">
                                            <div class="membership_details">
                                                <div class="membership_data">
                                                    <div class="data_left">
                                                        <div class="name">Membership</div>
                                                        <label>valid Up to <span>{{date('d/m/Y', strtotime($expiry_date))}}</span></label>
                                                        <div class="available_plan">
                                                            <span>{{$daysLeft}} Days Left in membership</span>
                                                            <div class="progress" style="height:30px"><div class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width:{{$progressBar}}%; height:30px;">{{$progressBar}}%</div></div>
                                                        </div>
                                                    </div>
                                                    <div class="trophy"><img src="{{asset('assets/customer/images/badge.png')}}"></div>
                                                </div>
                                            </div>
                                        </div>
									</div>
									<div class="col-sm-4 top_selling">
										<div class="inside">
											<div class="title">About Membership</div>
											<div class="about_membership">
												<div class="list">
													<strong>Membership Type:</strong>
												</div>
												<div class="list">
													<strong>Membership Amount:</strong>
												</div>
												<div class="list">
													<strong>Purchase Date:</strong>
													<span>{{date("jS F, Y", strtotime($member->membership_purchase_date))}}</span>
												</div>
											</div>
										</div>
									</div>
                                
                                 
                                <div class="col-sm-12 top_selling">
									<div class="inside about_customer">
                                        <div class="title">About {{$member->f_name." ".$member->l_name}}</div>    
                                        <div class="content">
                                        {{$member->info}}
                                        </div>
									</div>
								</div>
                                <?php //if($member->type == '1'){ ?>        
                                <hr class="line_divider">
                                <!-- datepicker -->
                                <div class="col-sm-12 top_bar_area">
                                    <div class="row">
                                        <div class="col-sm-12 from_to_filter">
                                            <form>
                                            <div class="form-group">
                                                <label>From:</label>
                                                <input type="text" id="date_from_purchase" name="date_from_purchase" class="form-control datepickerSuper" placeholder="Date">
                                            </div>
                                            <div class="form-group">
                                                <label>To:</label>
                                                <input type="text" id="date_to_purchase" name="date_to_purchase" class="form-control datepickerSuper" placeholder="Date">
                                            </div>
                                            <button type="button" id="search_submit_purchase" class="btn btn-success">Search</button>
                                        </form>
                                        </div>
                                    </div>
                                </div>
						    <!-- datepicker -->
                            <!--table start -->
							    <div class="col-sm-12 top_selling">
									<div class="inside">
										<div class="title">Purchased Records</div>
										<table class="display responsive nowrap" id="purchase_record" width="100%">
										    <thead>
										        <tr>
										            <th>date</th>
										            <th>time</th>
													<th>Report name</th>
													<th>Points</th>
										        </tr>
										    </thead>
										    <tbody>
										    </tbody>
										</table>
									</div>
								</div>
                            <!--table end-->  

                                <hr class="line_divider">  
                                 <!-- datepicker -->
                                 <div class="col-sm-12 top_bar_area">
                                    <div class="row">
                                        <div class="col-sm-12 from_to_filter">
                                            <form>
                                            <div class="form-group">
                                                <label>From:</label>
                                                <input type="text" id="date_from" name="date_from" class="form-control datepickerSuper" placeholder="Date">
                                            </div>
                                            <div class="form-group">
                                                <label>To:</label>
                                              <input type="text" id="date_to" name="date_to" class="form-control  datepickerSuper" placeholder="Date">
                                            <input type="hidden" name="user_id" value="{{$member->user_primary_id}}">
                                            </div>
                                            <button type="button" id="search_submit" class="btn btn-success">Search</button>
                                        </form>
                                        </div>
                                    </div>
                                </div>
						    <!-- datepicker -->
                            <!--table start -->
							    <div class="col-sm-12 top_selling">
									<div class="inside">
										<div class="title">Saved Searches</div>
	                                        <table class="responsive nowrap display" id="SavedSearchlist" width="100%">
                                           <thead>
										        <tr>
										            <th>Date</th>
										            <th>Name</th>
													<th>ID</th>
													<!-- <th>Action</th> -->
										        </tr>
										    </thead>
										    <tbody>
										        
										    </tbody>
										</table>
									</div>
								</div>
                            <!--table end-->
                            <!-- datepicker -->
                            <div class="col-sm-12 top_bar_area">
                                    <div class="row">
                                        <div class="col-sm-12 from_to_filter">
                                            <form>
                                            <div class="form-group">
                                           <label>From:</label>
                                               <input type="text" name="date_from_trans" id="date_from_trans" class="form-control datepickerSuper" placeholder="Date">
                                            </div>
                                            <div class="form-group">
                                                <label>To:</label>
                                                <input type="text" name="date_to_trans" id="date_to_trans" class="form-control datepickerSuper" placeholder="Date">
                                            </div>
                                            <button type="button" id="search_submit_trans" class="btn btn-success">Search</button>
                                        </form>
                                        </div>
                                    </div>
                                </div>
						    <!-- datepicker -->
                            <div class="col-sm-12 customer_tabs">
								<ul class="nav nav-pills" id="configuration_sidebar_content">
									<li class="nav-item"><a data-id="credit_active" class="nav-link active" data-toggle="pill" href="#credit_points">Credit Points</a></li>
									<li class="nav-item"><a data-id="debit_active" class="nav-link" data-toggle="pill" href="#debit_points">Debit Points</a></li>
								</ul>
                            </div>
                            <div class="tab-content">
								<!--table start -->
                                <div class="col-sm-12 tab-pane active top_selling" id="credit_points">
                                    <div class="inside">
                                        <div class="title">Transaction History</div>
                                            <table class="display responsive nowrap" id="table_trans_credit" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Transaction ID</th>
                                                        <th>Amount</th>
                                                        <th>Credit</th>
                                                        <th>Payment Method</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                                 <!--table end-->
                                 <!--table start -->
                                <div class="col-sm-12 tab-pane top_selling fade" id="debit_points">
                                    <div class="inside">
                                        <div class="title">Transaction History</div>
                                        <table class="display responsive nowrap" id="table_trans_debit" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Debit</th>
                                                    <th>Debit Type</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
							</div>
                                <!--table end--> 
                                <hr class="line_divider" />
                            <div class="col-sm-12 customer_tabs">
								<ul class="nav nav-pills" id="properties_wrap">
									<li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#interested_properties">Interested Properties</a></li>
									<li class="nav-item"><a class="nav-link" data-toggle="pill" href="#highly_interested_properties">Highly Interested Properties</a></li>
								</ul>
                            </div>
                            <div class="tab-content">
                                <!-- Interested properties start-->
                                    <div class="col-sm-12 top_selling all_properties tab-pane active" id="interested_properties">
                                        <div class="inside">
                                            <div class="title mb-4">
                                                <p>interested properties</p>
                                                <div class="list_and_grid">
                                                    <i class="fa fa-th active grid_view"></i>
                                                    <i class="fa fa-list-ul list_view"></i>
                                                </div>
                                            </div> 
                                           
                                            <div id="prop_intr_container" class="row">
                                                 @include('AffiliateDashboard/member/propertiesResult')  
                                            </div>
                                        </div>
                                    </div>
                                <!-- Interested properties end-->

                                <!--Highly Interested properties start-->
                                    <div class="col-sm-12 top_selling all_properties tab-pane fade" id="highly_interested_properties">
                                        <div class="inside">
                                            <div class="title mb-4">
                                                <p>Highly interested properties</p>
                                                <div class="list_and_grid">
                                                    <i class="fa fa-th active grid_view"></i>
                                                    <i class="fa fa-list-ul list_view"></i>
                                                </div>
                                            </div>
                                            <div id="prop_highintr_container" class="row">
                                             @include('AffiliateDashboard/member/highPropertiesResult')
                                            </div>

                                        </div>
                                    </div>
                                <!--Highly Interested properties end-->
                            </div>
                        <?php //} ?>           
                                
					</div>
                 
				</div>
				
				
				<!-- main row end-->
			</div>
			<!-- inside_content_area end-->
        </section>
        <!-- right area end -->
    </div>
    <!-- main div end -->
@endsection
@section('page_js')
<script>
   $('[data-toggle="pill"]').click(function(e) {    
        var uri = window.location.toString();
        if (uri.indexOf("#") > 0) {
            var clean_uri = uri.substring(0, uri.indexOf("#"));
            window.history.replaceState({}, document.title, clean_uri);
        }
            console.log("clicked tab");
            var $this = $(this),
            loadurl = $this.attr('href'),
            targ = $this.attr('data-target');

            var page = window.location.hash.replace('#', '');
            getData(page,loadurl);
            $this.tab('show');
            //console.log("idd"+loadurl);
            return false;
    });

    // $(window).on('hashchange', function() {
    //     if (window.location.hash) {
    //         var page = window.location.hash.replace('#', '');
    //         if (page == Number.NaN || page <= 0) {
    //             return false;
    //         }else{
    //             var href = $("#properties_wrap").find(".active").attr('href');
    //         // console.log("inr "+id);
    //             getData(page,href);
    //         }
    //     }
    // });

    $(document).ready(function()
    {        
        $(document).on('click', '.pagination a',function(event)
        {
            event.preventDefault();
            $('li').removeClass('active');
            $(this).parent('li').addClass('active');
            var myurl = $(this).attr('href');
            var page = $(this).attr('href').split('page=')[1];
            var href = $("#properties_wrap").find(".active").attr('href');
            //Update History
            historyCount = $('#historyCount').text();
            historyCount = parseInt(historyCount) + 1;
            $('#historyCount').text(historyCount);
            getData(page,href);
        });

    });

    function getData(page,href) {
        if(href == "#interested_properties"){

            $.get("{{route('affiliateSavedSearchList')}}?page="+ page,
            {
                user_id: $('input[name="user_id"]').val(),
                type: '#interested_properties'
            },
            function(data, status){
                //alert("Data: " + data );
                $("#prop_intr_container").empty().html(data);
                location.hash = page;
                
            });
        }
        if(href == "#highly_interested_properties"){
            $.get("{{route('affiliateSavedSearchList')}}?page="+ page,
            {
                user_id: $('input[name="user_id"]').val(),
                type: '#highly_interested_properties'
            },
            function(data, status){
                //alert("Data: " + data );
                $("#prop_highintr_container").empty().html(data);
                location.hash = page;
                
            });
        }
        // $.ajax(
        // {
        //     url: '?page=' + page,
        //     type: "get",
        //     datatype: "html"
        // }).done(function(data){
        //     $("#tag_container").empty().html(data);
        //     location.hash = page;
        // }).fail(function(jqXHR, ajaxOptions, thrownError){
        //         alert('No response from server');
        // });
    }

    $('.all_properties .inside .title .list_and_grid i.grid_view').click(function(){
        $('.all_properties .inside .title .list_and_grid i.grid_view').addClass('active');
        $('.all_properties .inside .title .list_and_grid i.list_view').removeClass('active');
        $('.all_properties').removeClass('all_properties_list');
    });
    $('.all_properties .inside .title .list_and_grid i.list_view').click(function(){
        $('.all_properties .inside .title .list_and_grid i.list_view').addClass('active');
        $('.all_properties .inside .title .list_and_grid i.grid_view').removeClass('active');
        $('.all_properties').addClass('all_properties_list');
    });
    $(function() {

        $('#date_from,#date_from_purchase,#date_from_trans').datepicker({
            beforeShow: customRange,
            dateFormat: "mm/dd/yy",
            firstDay: 1,
            maxDate: 'now',
            changeFirstDay: false
        });
        $('#date_to,#date_to_purchase,#date_to_trans').datepicker({
            beforeShow: customRange,
            dateFormat: "mm/dd/yy",
            firstDay: 1,
            changeFirstDay: false
        });
    });

    function customRange(input) {
        var min = null, // Set this to your absolute minimum date
        dateMin = min,
        dateMax = null;
        if (input.id === "date_from") {
            console.log("start time");
            dateMax = 'now';	
        }
        if (input.id === "date_to") {
            dateMin = $('#date_from').datepicker('getDate');
            dateMax = null;
        }

        if (input.id === "date_from_purchase") {
            dateMax = 'now';	
        }
        if (input.id === "date_to_purchase") {
            dateMin = $('#date_from_purchase').datepicker('getDate');
        }

        if (input.id === "date_from_trans") {
            dateMax = 'now';	
        }
        if (input.id === "date_to_trans") {
            dateMin = $('#date_from_trans').datepicker('getDate');
        }

        return {
            minDate: dateMin,
            maxDate: dateMax
        };
    }

    $('.datepickerSuper').datepicker('widget').delegate('.ui-datepicker-close', 'mouseup', function() {
    var inputToBeCleared = $('.datepicker').filter(function() { 
    return $(this).data('pickerVisible') == true;
    });    
    $(inputToBeCleared).val('');
    });

    
    var table = $('#SavedSearchlist').DataTable({
    
		processing: true,
		responsive: true,
		serverSide: true,
		dom: 'lBfrtip',
			buttons: [
				'copyHtml5',
				'excelHtml5',
				'csvHtml5',
				'pdfHtml5',
			],
		lengthMenu: [
				[10, 20 ],
				[10, 20]
			],
		paging: true,
		ajax: {
			url: "{{route('affiliateSavedSearchList')}}",
			data: function (d) {
					d.date_from = $('input[name="date_from"]').val();
					d.user_id = $('input[name="user_id"]').val();
                    d.type = 'saved_search';
					d.date_to =$('input[name="date_to"]').val();
				}
			},
			
			columns: [ 
				{ data: 'date', name: 'date' },
				{ data: 'name', name: 'name' },
				{ data: 'unique_id', name: 'unique_id' },
				// {data: 'action', name: 'action', orderable: false, searchable: false}
			]
	});
	 		
    $('#search_submit').click(function(){	
        $('#SavedSearchlist').DataTable().draw(true);
    });  


    var table = $('#purchase_record').DataTable({
		processing: true,
		responsive: true,
		serverSide: true,
		dom: 'lBfrtip',
			buttons: [
				'copyHtml5',
				'excelHtml5',
				'csvHtml5',
				'pdfHtml5',
			],
		lengthMenu: [
				[10, 20 ],
				[10, 20]
			],
		paging: true,
		ajax: {
			url: "{{route('affiliateSavedSearchList')}}",
			data: function (d) {
					d.date_from_purchase = $('input[name="date_from_purchase"]').val();
					d.user_id = $('input[name="user_id"]').val();
                    d.type = 'purchased_record';
					d.date_to_purchase =$('input[name="date_to_purchase"]').val();
					
				}
			},
			
			columns: [ 
				{ data: 'date', name: 'date' },
				{ data: 'time', name: 'time' },
				{ data: 'name', name: 'name' },
				{ data: 'point', name: 'point' }
				// {data: 'action', name: 'action', orderable: false, searchable: false}
			]
	});
	 		
    $('#search_submit_purchase').click(function(){	
        $('#purchase_record').DataTable().draw(true);
    }); 

    
    var table = $('#table_trans_credit').DataTable({
        processing: true,
        responsive: true,
        serverSide: true,
        dom: 'lBfrtip',
        buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5',
        ],
        lengthMenu: [
        [10, 20 ],
        [10, 20]
        ],
        paging: true,
        ajax: {
        url: "{{route('affiliateSavedSearchList')}}",
        data: function (d) {
        d.date_from_trans = $('input[name="date_from_trans"]').val();
        d.user_id = $('input[name="user_id"]').val();
        d.type = 'transaction_record_credit';
        d.date_to_trans =$('input[name="date_to_trans"]').val();
        }
        },

        columns: [ 
        { data: 'date', name: 'date' },
        { data: 'txn', name: 'txn' },
        { data: 'amount', name: 'amount' },
        { data: 'point', name: 'point' },
        { data: 'payment_method', name: 'payment_method' }
        // {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
    

    $('#search_submit_trans').click(function(){	
       var id = $("#configuration_sidebar_content").find(".active").data('id');
       if(id == "credit_active"){
           $('#table_trans_credit').DataTable().draw(true);
       }
       if(id == "debit_active"){
           $('#table_trans_debit').DataTable().draw(true);
       }
    });
    
    var table = $('#table_trans_debit').DataTable({
        processing: true,
        responsive: true,
        serverSide: true,
        dom: 'lBfrtip',
        buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5',
        ],
        lengthMenu: [
        [10, 20 ],
        [10, 20]
        ],
        paging: true,
        ajax: {
        url: "{{route('affiliateSavedSearchList')}}",
        data: function (d) {
        d.date_from_trans = $('input[name="date_from_trans"]').val();
        d.user_id = $('input[name="user_id"]').val();
        d.type = 'transaction_record_debit';
        d.date_to_trans =$('input[name="date_to_trans"]').val();

        }
        },

        columns: [ 
        { data: 'date', name: 'date' },
        { data: 'point', name: 'point' },
        { data: 'debit_type', name: 'debit_type' }
        // {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    goBack = function() {
        historyCount = parseInt($('#historyCount').text());
        history.go(-historyCount);
    }

  
    $('body').on('click', '.updateStatus', function(e) {
        e.preventDefault();
        var status = $(this).data("id");
        div = $(".status_button_wrap");
        swal({
            title: "Are you sure!",
            type: "error",
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes!",
            showCancelButton: true,
        },
        function() {
           
            var user_id = $('input[name="user_id"]').val();
            var type = 'deactivate_member';
         
            $.ajax({
                type: "GET",
                url: "{{route('affiliateSavedSearchList')}}",
                data: { user_id: user_id, type: type,status:status },
                success: function(data){
                    
                    if($.isEmptyObject(data.error)){
                       
                        swal(data.success,"Successfully", "success"); 
                        div.html(data.button)
                        
                    }else{
                        
                        swal("Cancelled", data.error, "error");   
                    }

                }       
            });
        });
    });
 
</script>
@endsection