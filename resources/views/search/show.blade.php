@extends('layouts.main')

@section('title')
Search Detail
@endsection

@section('css_files')
    <link rel="stylesheet" href="{{ url('assets/css/sweetalert.css')  }}">
@endsection

@section('custom_css')
         <style type="text/css">


         </style>
@endsection

@section('content')

    <div class="breadcrumb_sec">
               <ul class="breadcrumb">
                  <li class="active msg"><a class="inactive_bread" href="#">Search Detail</a></li>
               </ul>
            </div>
            <section class="table_design">
              <table>
                <tr>
                  <td>Country</td>
                  <td>{{$data->country}}</td>
                </tr>
                <tr>
                  <td>State</td>
                  <td>{{$data->state}}</td>
                </tr>
                <tr>
                  <td>Land Use</td>
                  <td>{{$data->land}} - {{$data->land=='Residentials'? $data->residentials : $data->commercial}}</td>
                </tr>
                <tr>
                  <td>Owner</td>
                  <td>{{$data->owner}} - {{$data->owner=='Exemption'? $data->exemption : $data->occupancy}}</td>
                </tr>
                <tr>
                  <td>Sales Information(Last Sale Recording Date)</td>
                  <td>{{$data->sales_from}}- {{$data->sales_to}}</td>
                </tr>
                <tr><td>Open Lien Information(Mortgage Amount)</td><td>{{$data->mortgage_amount_f}}-{{$data->mortgage_amount_t}}</td></tr>
                <tr><td>Open Lien Information(Mortgage Recording Date)</td><td>{{$data->mortgage_date_f}}-{{$data->mortgage_date_t}}</td></tr>
                <tr><td>Open Lien Information(Mortgage Type)</td><td>{{$data->mortgage_type}}</td></tr>
                <tr><td>Interest Rate:</td><td>{{$data->interest_rate_f}}%-{{$data->interest_rate_t}}%</td></tr>
                <tr><td>Open Lien Information(Max Open Lien)</td><td>{{$data->max_open_lien}}</td></tr>
                <tr><td>Equity</td><td>{{$data->equity_from}}% - {{$data->equity_to}}%</td></tr>
                <tr><td>Listing Status</td><td>{{$data->listing_status}}</td></tr>
                <tr><td>Listing Amount</td><td>{{$data->listing_amount_f}}-{{$data->listing_amount_t}}</td></tr>
                <tr><td>Foreclosure Status </td><td>{{$data->foreclosure_status}}</td></tr>
                <tr><td>Foreclosure Date</td><td>{{$data->foreclosure_date_f}}-{{$data->foreclosure_date_t}}</td></tr>
                <tr><td>Foreclosure Amount</td><td>{{$data->foreclosure_amount_f}}-{{$data->foreclosure_amount_t}}</td></tr>
                <tr><td>Finance Scores </td><td>{{$data->finance_scores}}</td></tr>
                <tr><td>Owner Properties Owned</td><td>{{$data->owner_owned_f}}-{{$data->owner_owned_t}}</td></tr>
                <tr><td>HOA Lien(Open HOA Lien Present)</td><td>{{$data->hoa}}</td></tr>
                <tr><td>Phone</td><td>{{$data->phone}}</td></tr>
                <tr><td>Email</td><td>{{$data->email}}</td></tr>
                <tr><td>Other pertinent information as available</td><td>{{$data->other}}</td></tr>
              </table>
            </section>

              <section class="table_design">
              @if(session('success'))
                <div class="alert alert-success">
                  <strong>Success!</strong> {{session('success')}}
                </div>
              @endif
              @if($data->status==0)
              <form action="excel" method="post" enctype="multipart/form-data">
                @csrf
                <div >
                  <label for="file">File</label>
                  <input type="file" id="csv" required="" class="form-control" name="csv">
                  <input type="hidden"  name="id" value="{{$data->id}}">
                  <input type="hidden"  name="user_id" value="{{$data->user_id}}">
                </div>
                <div>
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </form>
              @endif
            </section>


@endsection

@section('js_files')
    <script src="{{ url('assets/js/sweetalert.min.js') }}"></script>
@endsection

@section('custom_js')

@endsection