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
                        <!-- Top Boxes Start-->
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-md-4 single_box">
                                    <div class="inside">
                                        <div class="icon"><img src="{{asset('assets/superadmin/images/wallet.png')}}"></div>
                                        <div class="title">Total Wallet Balance</div>
                                        <div class="cus_num">${{$total}}</div>
                                    </div>
                                </div>		
                                <div class="col-md-4 single_box">
                                    <div class="inside">
                                        <div class="icon"><img src="{{asset('assets/superadmin/images/credit.png')}}"></div>
                                        <div class="title">Today Debit</div>
                                        <div class="cus_num">${{$debit}}</div>
                                    </div>
                                </div>
                                <div class="col-md-4 single_box">
                                    <div class="inside">
                                        <div class="icon"><img src="{{asset('assets/superadmin/images/debit.png')}}"></div>
                                        <div class="title">Today Credit</div>
                                        <div class="cus_num">${{$credit}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Top Boxes End-->
                        <!--table start -->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Wallet</div>
                                    <table class="display responsive nowrap" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Sr. No</th>
                                                <th>date</th>
                                                <th>Customer name</th>
                                                <th>Type</th>
                                                <th>Deposit Amount(points)</th>
                                                <!-- <th>Tax</th>
                                                <th>Cash</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            @if(!empty($data))
                                                @php $count = 1
                                                @endphp
                                                @php $name = '';  @endphp
                                                @foreach($data as $wallet_data)
                                                    <tr>
                                                    @if(isset($wallet_data->user->details))
                                                        @php $name = $wallet_data->user->details->f_name.' '.$wallet_data->user->details->l_name; @endphp
                                                    @endif
                                                        <td>{{$count}}</td>
                                                        <td>{{date("d-M-yy", strtotime($wallet_data->created_at))}}</td>
                                                        <td>{{ $name}} </td>
                                                        <td><?php if($wallet_data->type ==1){ ?>Credit <?php 
														}else{ ?> Debit <?php } ?></td>
                                                        <td>${{ $wallet_data->amount }}</td>
                                                        <!-- <td></td>
                                                        <td></td> -->
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
$(document).ready(function() {
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
});
</script>
@endsection 