@if(count($data) >0)
@foreach($data as $key => $value) 
<div class="col-md-6 property_box">
													
	<div class="inset">
		<div class="row shortDtl">
		
			<div class="col-md-4"><b><i class="fa fa-tag"></i> apn</b>{{$value->datatree->APNFormatted}}</div>
			<div class="col-md-4"><b><i class="fa fa-address-card-o"></i> Owner</b><span>{{$value->datatree->OwnerFirstName_MI1}}</span></div>
			<div class="col-md-4"><b><i class="fa fa-road"></i> House Number</b><b><i class="fa fa-home"></i></b><span>{{$value->datatree->SitusHouseNumber}}</span></div>
			<div class="col-md-4"><b><i class="fa fa-street-view"></i> Street Name</b><span>{{$value->datatree->SitusStreetName}}</span></div>													
			<div class="col-md-4"><b><i class="fa fa-map-marker"></i> Zip</b><span>{{$value->datatree->SitusZipCode}}</span></div>
			<div class="col-md-4"><b><i class="fa fa-map-marker"></i> City</b><span>{{$value->datatree->SitusCity}}</span></div>
			<div class="col-md-4"><b><i class="fa fa-map-marker"></i> County</b><span>{{$value->datatree->County}}</span></div>
			<div class="col-md-4"><b><i class="fa fa-map-marker"></i> State</b><span>{{$value->datatree->SitusState}}</span></div>													
			<div class="col-md-4"><b><i class="fa fa-room"></i> Rooms</b><span>{{$value->datatree->SumOfTotalRooms}}</span></div>		
			<div class="col-md-4"><b><i class="fa fa-bed"></i> Bedrooms</b><span>{{$value->datatree->SumOfBedRooms}}</span></div>													
			<div class="col-md-4"><b><i class="fa fa-bath"></i> Bathrooms</b><span>{{$value->datatree->BathroomsNew}}</span></div>														
			<div class="col-md-4"><b><i class="fa fa-bed"></i> Land Sq. Footage</b><span>{{$value->datatree->LandSquareFootage}}</span></div>												
		</div>
		<div class="image_and_bulb">
			
			<span><img src="{{asset('assets/superadmin/images/fire.png')}}"></span>
		</div>
		<div class="parent_data">
			<div class="data"> </div>
			
			<div class="data2"></div>
		</div>
		<a class="lnkGo" target="_blank"></a>
	</div>

</div>
@endforeach
<div class="col-sm-12 mt-4 mb-3 text-center">
	<div class="pagination"> {!! $data->render() !!} </div>
</div>
@else
<div class="col-md-6 property_box">
    No Property Found.
</div>
@endif