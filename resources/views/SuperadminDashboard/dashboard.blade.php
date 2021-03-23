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
                <div class="col-md-12">
                    <div class="row">	
                        <!-- Top Boxes Start-->
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3 single_box">
                                    <div class="inside">
                                        <div class="icon"><img src="{{asset('assets/superadmin/images/income.svg')}}"></div>
                                        <div class="title">Revenue</div>
                                        <div class="income_flexs">
                                            <div class="cus_num">${{$ledger}}</div>
                                            <!--div class="cus_num2"><span class="text-success"><i class="fa fa-plus"></i> 14%</span></div-->
                                        </div>
                                    </div>
                                </div>		
                                <div class="col-md-3 single_box">
                                    <div class="inside">
                                        <div class="icon"><img src="{{asset('assets/superadmin/images/chartlow.svg')}}"></div>
                                        <div class="title">Expenses</div>
                                        <div class="income_flexs">
                                            <div class="cus_num">$<span class="text-danger">{{$expense}}</span></div>
                                            <!--div class="cus_num2"><span class="text-danger"><i class="fa fa-chevron-up"></i> 8%</span></div-->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 single_box">
                                    <div class="inside">
                                        <div class="icon"><img src="{{asset('assets/superadmin/images/employee.svg')}}"></div>
                                        <div class="title">Customers</div>
                                        <div class="income_flexs">
                                            <div class="cus_num">{{$total_member}}</div>
                                            <!--div class="cus_num2"><span class="text-success"><i class="fa fa-chevron-down"></i> 15%</span></div-->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 single_box">
                                    <div class="inside">
                                        <div class="icon"><img src="{{asset('assets/superadmin/images/clients.svg')}}"></div>
                                        <div class="title">Prospects</div>
                                        <div class="income_flexs">
                                            <div class="cus_num">{{$total_non_member}}</div>
                                            <!--div class="cus_num2"><span class="text-warning"><i class="fa fa-plus"></i> 76%</span></div-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Top Boxes End-->

                        <div class="col-md-12">
                            <div class="target_title mb-4">Target Section</div>
                        </div>

                        <!-- Top Boxes Start-->
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6 single_box">
                                    <div class="inside">
                                        <div class="title">Revenue Target</div>
                                        <div class="income_flexs">
                                            <div class="cus_num"><span class="text-danger">{{number_format($percentRevenue, 2)}}%</span></div>
                                            <div class="cus_num2">
                                                <div class="progress-bar-xs progress">
                                                    <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="71" aria-valuemin="0" aria-valuemax="100" style="width: {{number_format($percentRevenue, 1)}}%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>      
                                <div class="col-md-6 single_box">
                                    <div class="inside">
                                        <div class="title">Expenses Target</div>
                                        <div class="income_flexs">
                                            <div class="cus_num"><span class="text-success">{{number_format($percentExpense, 2)}}%</span></div>
                                            <div class="cus_num2">
                                                <div class="progress-bar-xs progress">
                                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="54" aria-valuemin="0" aria-valuemax="100" style="width: {{number_format($percentExpense, 1)}}%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                               
                            </div>
                        </div>
                        <!-- Top Boxes End-->

                        <!--Revenue start -->
                        <div class="col-lg-12 right_area">
                            <div class="row">
                                <div class="col-md-4 single_box">
                                    <div class="inside">
                                        <div class="title">Total Sales</div>
                                        <div id="chart"></div>
                                    </div>
                                </div>
                                <div class="col-md-4 single_box">
                                    <div class="inside">
                                        <div class="title">Daily Sales</div>
                                        <div id="chart2"></div>
                                    </div>
                                </div>
                                <div class="col-md-4 single_box">
                                    <div class="inside">
                                        <div class="title">Total Expenses</div>
                                        <div id="chart3"></div>
                                    </div>
                                </div>
                            </div>
							
                        </div>
                        <!--Revenue end -->

                        <!-- Top-sale-manager -->
                      <?php /*  <div class="col-md-12">
                            <div class="target_title mb-4">Top 3 Sale Managers</div>
                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <!-- first-sale -->
                                <div class="col-sm-12 col-lg-6 col-xl-4">
                                    <div class="mb-4 profile-responsive card">
                                        <div class="profile_box">
                                            <div class="mr-3">
                                                <div class="avatar-icon rounded"><img src="{{asset('assets/superadmin/images/3.jpg')}}"></div>
                                            </div>
                                            <div>
                                                <h5 class="menu-header-title">Jeff Walberg</h5>
                                                <h6 class="menu-header-subtitle">Sales Manager</h6>
                                            </div>
                                        </div>
                                        <div class="proflist">
                                            <ul>
                                                <li>
                                                    <div class="row no-gutters">
                                                        <div class="col-md-6">
                                                            <a href="#">
                                                                <div class="heading">
                                                                    <i class="fa fa-id-card"></i>
                                                                    <h3>View Profile</h3>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <a href="#">
                                                                <div class="heading noborder">
                                                                    <i class="fa fa-flask"></i>
                                                                    <h3>Lead Generated</h3>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- first-sale -->
                                <!-- second-sale -->
                                <div class="col-sm-12 col-lg-6 col-xl-4">
                                    <div class="mb-4 profile-responsive card">
                                        <div class="profile_box">
                                            <div class="mr-3">
                                                <div class="avatar-icon rounded"><img src="{{asset('assets/superadmin/images/8.jpg')}}"></div>
                                            </div>
                                            <div>
                                                <h5 class="menu-header-title">John Rosenberg</h5>
                                                <h6 class="menu-header-subtitle">Sales Manager</h6>
                                            </div>
                                        </div>
                                        <div class="proflist">
                                            <ul>
                                                <li>
                                                    <div class="row no-gutters">
                                                        <div class="col-md-6">
                                                            <a href="#">
                                                                <div class="heading">
                                                                    <i class="fa fa-id-card"></i>
                                                                    <h3>View Profile</h3>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <a href="#">
                                                                <div class="heading noborder">
                                                                    <i class="fa fa-flask"></i>
                                                                    <h3>Lead Generated</h3>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- second-sale -->
                                <!-- third-sale -->
                                <div class="col-sm-12 col-lg-6 col-xl-4">
                                    <div class="mb-4 profile-responsive card">
                                        <div class="profile_box">
                                            <div class="mr-3">
                                                <div class="avatar-icon rounded"><img src="{{asset('assets/superadmin/images/1.jpg')}}"></div>
                                            </div>
                                        <div>
                                        <h5 class="menu-header-title">Ruben Tillman</h5>
                                        <h6 class="menu-header-subtitle">Sales Manager</h6>
                                    </div>
                                </div>
                                <div class="proflist">
                                    <ul>
                                        <li>
                                            <div class="row no-gutters">
                                                <div class="col-md-6">
                                                    <a href="#">
                                                        <div class="heading">
                                                            <i class="fa fa-id-card"></i>
                                                            <h3>View Profile</h3>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="col-md-6">
                                                    <a href="#">
                                                        <div class="heading noborder">
                                                            <i class="fa fa-flask"></i>
                                                            <h3>Lead Generated</h3>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- third-sale -->
                    </div>
                </div> */ ?>
                <!-- Top-sale-manager-end-->

                <!--Recently-Joined-Partners-->

                <div class="col-sm-12 top_selling">
                    <div class="inside">
                        <div class="title">Recently Joined Contractors</div>  
                            <table class="display responsive nowrap" width="100%">
                                <thead>
                                    <tr>
                                        <th>Sr. No</th>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Postal Code</th>
                                        <th>Start Date</th>
                                        <!-- <th>Salary</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @if(!empty($recently_joined_members))
                                    @php $count = 1
                                    @endphp
                                    @php 
                                            $name = '';
                                            $address= '';
                                            $postal = ''; 
											$role = '';
											@endphp
                                    @foreach($recently_joined_members as $recently_joined_member)

                                        <tr> 
                                      
                                            @if(isset($recently_joined_member->details))
                                           @php  $name = $recently_joined_member->details->f_name.' '.$recently_joined_member->details->l_name;
                                            $address= $recently_joined_member->details->address;
                                            $postal= $recently_joined_member->details->postal;
                                            $role = $recently_joined_member->role;
                                            @endphp
                                            @endif
                                         <?php   
                                         if($recently_joined_member->role=='1'){ $role='user'; }
                                         elseif($recently_joined_member->role=='2'){ $role='Accountant'; }
                                         elseif($recently_joined_member->role=='4'){$role='Sales Manager';}
                                         elseif($recently_joined_member->role=='5'){ $role='Sales Executive'; }else{} ?>
                                            <td>{{$count}}</td>
                                            <td>{{$name}}</td>
                                            <td>{{ $role }}</td>
                                            <td> {{$address}} </td>
                                            <td>{{$postal}}</td>
                                            <td>{{ date('d-M-yy', strtotime($recently_joined_member->created_at)) }}</td>
                                            <!-- <td><a href="#" class="btn btn-success">View</a></td> -->
                                        </tr>
                                        @php
                                        $count++
                                        @endphp
                                    @endforeach
                                    @else
                                        No Data Found
                                    @endif              
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--Recently-Joined-Partners-end-->

                    <!--Income start -->
                    <div class="col-lg-12 right_area">
                        <div class="row">
                            <div class="col-md-7 single_box">
                                <div class="inside">
                                    <div class="title">Income Report</div>
                                    <div class="col-md-12">
                                        <div id="chart4"></div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="titlelabel">
                                            <nav>
                                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                                    <a class="nav-item nav-link active" id="nav-income-tab" data-toggle="tab" href="#nav-income" role="tab" aria-controls="nav-income" aria-selected="true">Income</a>
                                                    <a class="nav-item nav-link" id="nav-expenses-tab" data-toggle="tab" href="#nav-expenses" role="tab" aria-controls="nav-expenses" aria-selected="false">Expenses</a>
                                                </div>
                                            </nav>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="content_tab">
                                            <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                                <!-- first-tab-start -->
                                                <div class="tab-pane fade show active" id="nav-income" role="tabpanel" aria-labelledby="nav-income-tab">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="widget_content">
                                                                <div class="widget_content_wrapper">
                                                                    <div class="widget_content_left">Orders</div>
                                                                    <div class="widget_content_right">366</div>
                                                                </div>
                                                                <div class="progress-bar-xs progress">
                                                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="76" aria-valuemin="0" aria-valuemax="100" style="width: 76%;"></div>
                                                                </div>
                                                                <div class="sub_panel">
                                                                    <div class="sub_panel_left">Monthly Target</div>
                                                                    <div class="sub_panel_right">100%</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="widget_content">
                                                                <div class="widget_content_wrapper">
                                                                    <div class="widget_content_left">Income</div>
                                                                    <div class="widget_content_right text-success">$2797</div>
                                                                </div>
                                                                <div class="progress-bar-xs progress">
                                                                    <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="23" aria-valuemin="0" aria-valuemax="100" style="width: 23%;"></div>
                                                                </div>
                                                                <div class="sub_panel">
                                                                    <div class="sub_panel_left">Monthly Target</div>
                                                                    <div class="sub_panel_right">100%</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- first-tab-end -->
                                                <!-- second-tab -->
                                                <div class="tab-pane fade" id="nav-expenses" role="tabpanel" aria-labelledby="nav-expenses-tab">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="widget_content">
                                                                <div class="widget_content_wrapper">
                                                                    <div class="widget_content_left">Sale</div>
                                                                    <div class="widget_content_right"><span class="text-success">$ 976 <i class="fa fa-chevron-up"></i></span></div>
                                                                </div>
                                                                <div class="sub_panel">
                                                                    <div class="sub_panel_left">Monthly Goals</div>
                                                                    <div class="sub_panel_right"><i class="fa fa-chevron-up"></i> 175%</div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="widget_content">
                                                                <div class="widget_content_wrapper">
                                                                    <div class="widget_content_left">Expenses</div>
                                                                    <div class="widget_content_right"><span class="text-warning">84% <i class="fa fa-chevron-down"></i></span></div>
                                                                </div>
                                                                <div class="sub_panel">
                                                                    <div class="sub_panel_left">Returning</div>
                                                                    <div class="sub_panel_right">45 <i class="fa fa-chevron-up"></i></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- second-tab-end-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 single_box">
                                <div class="inside">
                                    <div class="title">Sale Executive</div>
                                    <div class="scroll_container">
                                        <ul>
                                            <li>
                                                <div class="side_wraper">
                                                    <div class="side_content_left"><img width="38" class="rounded-circle" src="{{asset('assets/superadmin/images/1.jpg')}}"></div>
                                                    <div class="side_content_center">
                                                        <div class="heads">Beck Coller</div>
                                                        <div class="badge badge-pill badge-danger">$152</div>
                                                    </div>
                                                    <div class="side_content_right">
                                                        <small class="opacity-5 pr-1 text-success">$</small>
                                                        <span class="text-success">750</span>
                                                        <small class="text-success pl-2"><i class="fa fa-angle-up"></i></small>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="side_wraper">
                                                    <div class="side_content_left"><img width="38" class="rounded-circle" src="{{asset('assets/superadmin/images/3.jpg')}}"></div>
                                                    <div class="side_content_center">
                                                        <div class="heads">Angelo Hume</div>
                                                        <div class="badge badge-pill badge-danger">$53</div>
                                                    </div>
                                                    <div class="side_content_right">
                                                        <small class="opacity-5 pr-1 text-success">$</small>
                                                        <span class="text-success">542</span>
                                                        <small class="text-success pl-2"><i class="fa fa-angle-up"></i></small>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="side_wraper">
                                                    <div class="side_content_left"><img width="38" class="rounded-circle" src="{{asset('assets/superadmin/images/1.jpg')}}"></div>
                                                    <div class="side_content_center">
                                                        <div class="heads">Beck Coller</div>
                                                        <div class="badge badge-pill badge-danger">$152</div>
                                                    </div>
                                                    <div class="side_content_right">
                                                        <small class="opacity-5 pr-1 text-success">$</small>
                                                        <span class="text-success">750</span>
                                                        <small class="text-success pl-2"><i class="fa fa-angle-up"></i></small>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="side_wraper">
                                                    <div class="side_content_left"><img width="38" class="rounded-circle" src="{{asset('assets/superadmin/images/3.jpg')}}"></div>
                                                    <div class="side_content_center">
                                                        <div class="heads">Angelo Hume</div>
                                                        <div class="badge badge-pill badge-danger">$53</div>
                                                    </div>
                                                    <div class="side_content_right">
                                                        <small class="opacity-5 pr-1 text-success">$</small>
                                                        <span class="text-success">542</span>
                                                        <small class="text-success pl-2"><i class="fa fa-angle-up"></i></small>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="side_wraper">
                                                    <div class="side_content_left"><img width="38" class="rounded-circle" src="{{asset('assets/superadmin/images/1.jpg')}}"></div>
                                                    <div class="side_content_center">
                                                        <div class="heads">Beck Coller</div>
                                                        <div class="badge badge-pill badge-danger">$152</div>
                                                    </div>
                                                    <div class="side_content_right">
                                                        <small class="opacity-5 pr-1 text-success">$</small>
                                                        <span class="text-success">750</span>
                                                        <small class="text-success pl-2"><i class="fa fa-angle-up"></i></small>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="side_wraper">
                                                    <div class="side_content_left"><img width="38" class="rounded-circle" src="{{asset('assets/superadmin/images/3.jpg')}}"></div>
                                                    <div class="side_content_center">
                                                        <div class="heads">Angelo Hume</div>
                                                        <div class="badge badge-pill badge-danger">$53</div>
                                                    </div>
                                                    <div class="side_content_right">
                                                        <small class="opacity-5 pr-1 text-success">$</small>
                                                        <span class="text-success">542</span>
                                                        <small class="text-success pl-2"><i class="fa fa-angle-up"></i></small>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="inside">
                                    <div class="title">Monthly Statistics</div>
                                    <div class="col-md-12"><div id="chart5"></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Income end -->
                    <!--table start -->
                    <div class="col-sm-12 top_selling">
                        <div class="inside">
                            <div class="title">Highly Trending Properties</div>
                            <table class="display responsive nowrap" width="100%">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>County</th>
                                        <th>Zip Code</th>
                                        <th>Address</th>
                                        <!-- <th>Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @if(!empty($trending))
                                    @php $count = 1
                                    @endphp
                                    @foreach($trending as $high_trending_property)
                                        <tr>
                                            <td>{{$count}}</td>
                                            <td>{{ isset($high_trending_property->City) ? $high_trending_property->City : 'NA' }}</td>
                                            <td>{{ isset($high_trending_property->State) ? $high_trending_property->State : 'NA' }}</td>
                                            <td>{{ isset($high_trending_property->County) ? $high_trending_property->County : 'NA' }}</td>
                                            <td>{{ isset($high_trending_property->Zip) ? $high_trending_property->Zip : 'NA' }}</td>
                                            <td>{{ isset($high_trending_property->Address) ? $high_trending_property->Address : 'NA' }}</td>
                                            <!-- <td><a href="#" class="btn btn-success">View</a></td> -->
                                        </tr>
                                        @php
                                        $count++
                                        @endphp
                                    @endforeach
                                    @else
                                        No Data Found
                                    @endif
                                </tbody>
                            </table>
                            <!-- <div class="view_all mt-3"><a href="#" class="btn btn-success">View All</a></div> -->
                        </div>
                    </div>
                    <!--table end -->
                    <!--table start -->
                    <div class="col-sm-12 top_selling">
                        <div class="inside">
                            <div class="title">Interested Property</div>
                            <table class="display responsive nowrap" width="100%">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>County</th>
                                        <th>Zip Code</th>
                                        <th>Address</th>
                                        <!-- <th>Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($highly_interested_properties))
                                    @php
                                    $count = 1
                                    @endphp
                                    @foreach($interested_properties as $interested_property)
                                        <tr>
                                            <td>{{$count}}</td>
                                            <td>{{ isset($interested_property->City) ? $interested_property->City : 'NA' }}</td>
                                            <td>{{ isset($interested_property->State) ? $interested_property->State : 'NA' }}</td>
                                            <td>{{ isset($interested_property->County) ? $interested_property->County : 'NA' }}</td>
                                            <td>{{ isset($interested_property->Zip) ? $interested_property->Zip : 'NA' }}</td>
                                            <td>{{ isset($interested_property->Address) ? $interested_property->Address : 'NA' }}</td>
                                            <!-- <td><a href="#" class="btn btn-success">View</a></td> -->
                                        </tr>
                                        @php
                                        $count++
                                        @endphp
                                    @endforeach
                                    @else
                                        No Data Found
                                    @endif
                                </tbody>
                            </table>
                            <!-- <div class="view_all mt-3"><a href="#" class="btn btn-success">View All</a></div> -->
                        </div>
                    </div>
                    <!--table end -->
                    <!--table start -->
                    <div class="col-sm-12 top_selling">
                        <div class="inside">
                            <div class="title">Highly Interested Property</div>
                            <table class="display responsive nowrap" width="100%">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>County</th>
                                        <th>Zip Code</th>
                                        <th>Address</th>
                                        <!-- <th>Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($highly_interested_properties))
                                    @php $count = 1
                                    @endphp
                                    @foreach($highly_interested_properties as $high_interested_property)
                                        <tr>
                                            <td>{{$count}}</td>
                                            <td>{{ isset($high_interested_property->City) ? $high_interested_property->City : 'NA' }}</td>
                                            <td>{{ isset($high_interested_property->State) ? $high_interested_property->State : 'NA' }}</td>
                                            <td>{{ isset($high_interested_property->County) ? $high_interested_property->County : 'NA' }}</td>
                                            <td>{{ isset($high_interested_property->Zip) ? $high_interested_property->Zip : 'NA' }}</td>
                                            <td>{{ isset($high_interested_property->Address) ? $high_interested_property->Address : 'NA' }}</td>
                                            <!-- <td><a href="#" class="btn btn-success">View</a></td> -->
                                        </tr>
                                        @php
                                        $count++
                                        @endphp
                                    @endforeach
                                    @else
                                        No Data Found
                                    @endif
                                </tbody>
                            </table>
                            <!-- <div class="view_all mt-3"><a href="#" class="btn btn-success">View All</a></div> -->
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
@endsection
@section('page_js')

<script>
    $('.display').DataTable({
        responsive: true,
        dom: 'lBfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
            ],
        lengthMenu: [
                [10,20, 40, 60, 80, 100],
                [10,20, 40, 60, 80, 100]
            ],
    });
	
	var barGraphData1 = {!! $total_sale_graphs['sale_graph'] !!};
	var barGraphData2 = {!! $total_sale_graphs['purchase_records_graph'] !!};
	var barGraphData3 = {!! $total_sale_graphs['membership_graph'] !!};

	console.log(barGraphData1);
	console.log(barGraphData2);
	console.log(barGraphData3);
	var options = {
		series: [{
			name: 'Property Sale',
		
			data: barGraphData1
		}, {
			name: 'Records Sale',
		
			data: barGraphData2
		}, {
			name: 'Memberships Sale',
		
			data: barGraphData3
		}],
		chart: {
			type: 'bar',
		
			height: 250
		},
		plotOptions: {
			bar: {
				horizontal: false,
				columnWidth: '55%',
				endingShape: 'rounded'
			},
		},
		dataLabels: {
			enabled: false
		},
		stroke: {
			show: true,
			width: 2,
			colors: ['transparent']
		},
		xaxis: {
			categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August','September','October','November','December'],
		
		},
		yaxis: {
			title: {
				text: 'Amount($)'
			}
		
		},
		fill: {
			opacity: 1
		},
		tooltip: {
			y: {
				formatter: function (val) {
					return "$ " + val
				}
			}
		},
	};
	var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
	
</script>
@endsection
