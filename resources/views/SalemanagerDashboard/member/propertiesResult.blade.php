@if(count($data) >0)
 @foreach($data as $value)   
    <div class="col-md-4 col-lg-3 property_box">
        <a href="#" target="_blank">
        <div class="inset">
            <div class="image_and_bulb">
                <p><img src="{{asset('assets/superadmin/images/house1.jpg')}}"></p>
                <span><img src="{{asset('assets/superadmin/images/bulb.png')}}"></span>
            </div>
            <div class="parent_data">
                <div class="data">
                {{ ($value->Bedrooms) ? $value->Bedrooms .' Bed ' : ''   }}       
                {{ ($value->Bathrooms) ? $value->Bathrooms .' Bath ' : ''  }}      
                {{ ($value->SqFoot) ? $value->SqFoot .' SqFoot ' : ''  }}      
                {{ ($value->StreetName) ? $value->StreetName  : ''  }}      
                {{ ($value->Unit) ? ' Unit '. $value->Unit : ''   }}      
                </div>


                <div class="data2">{{$value->Address}}{{($value->City) ?', '. $value->City : ''  }}{{($value->Zip) ?', '. $value->Zip : ''  }}
                    USA </div>
            </div>
        </div>
        </a>
    </div>
@endforeach
@else
<div class="col-md-4 col-lg-3 property_box">
    No Property Found.
</div>
@endif
<div class="col-sm-12 mt-4 mb-3">
    <div class="pagination"> {!! $data->render() !!} </div>
</div>
