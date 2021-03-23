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
						<!--table start -->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Recevied Designs</div>
								<table class="display responsive nowrap" id="postcard_table" width="100%">
									<thead>
										<tr>
											<th>Sr No.</th>
											<th>Date</th>
											<th>Customer Name</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									@php $i=1; @endphp
									@foreach($sent_postcards as $key => $data)
										<tr>
											<td>{{$i}}</td>
											<td>{{$data->date}}</td>
											<td>{{ isset($data->users->details) ? $data->users->details->f_name : ''}}</td>
											<td>{{ $data->status == '0' ? 'sent' : 'rejected'}}</td>
											<td>
												<a href="{{URL::route('superadminPostcardDesignDetail', $data->id)}}"><button class="btn btn-primary"><i class="fa fa-eye"></i> View Detail</button></a>
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
    <!-- popup end here-->
@endsection
@section('page_js')
<script> 
    $(document).ready(function() {
        $('#postcard_table').DataTable();
	});
</script> 
@endsection