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
                        <!-- datepicker -->
                        <div class="col-sm-12 top_bar_area">
                            <div class="row">
                                <!--div class="col-sm-12 top_btns">
                                    <button class="btn btn-primary" id="add-item" data-toggle="modal" data-title="Add New Kickstarter" data-url="{{ URL('/superadmin/kickstarter/') }}" data-target="#createKickstarterModal">Add Kickstarter<i class="fa fa-plus"></i></button>
                                </div-->
                            </div>
                        </div>
                        <!-- datepicker -->
                        <!--table start -->
                        <?php //cho "<pre>"; print_r($user); echo "</pre>"; ?>
                        
                        <div class="col-sm-12 top_selling">
                            <div class="inside">
                                 <table class="display responsive nowrap" id="open_ticket_table" width="100%">
                                    <thead>
                                        <tr>
                                          
                                            <th>Ticket ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Time</th>
                                            <th>action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										@php $i=1; @endphp
										@foreach($data as $key => $value)
										<tr>
											
											<td>{{$value->ticket_number}}</td>
											<td>{{ isset($value->users->details->f_name) ? $value->users->details->f_name: ''}}</td>
											<td>{{ isset($value->users->email) ? $value->users->email: ''}}</td>
											<td>{{ isset($value->users->details->phone) ? $value->users->details->phone : ''}}</td>
											<td>{{ $value->time}}</td>
											<td>
												<a href="{{URL::route('superadminCancelMembershipTicketDetail', $value->id)}}"><button class="btn btn-primary"><i class="fa fa-eye"></i> View</button></a>
											</td>
										</tr>
									@php $i++; @endphp
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
@endsection
@section('page_js')
<script>
$(document).ready(function() {
	$('#open_ticket_table').DataTable({
	  "ordering": false
	});
});
</script>
@endsection