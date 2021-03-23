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
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>	
                            <strong>{{ $message }}</strong>
                        </div>
                      @endif
                    </div>
                    <div class="row">
                        <form method="post" id="contentForm" action="{{ URL('/superadmin/cms/') }}">
                            <!--table start -->
                            @csrf
                            <!--table start -->
                            <div class="col-sm-12 top_selling">
                                <div class="inside">
                                    <div class="title">Career</div>
                                    <textarea name="page_content">
                                    {!!$data->career!!}
                                    </textarea>
                                    <input type="hidden" name="type" value="career" />
                                    <div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg">Save</button></div>
                                </div>
                            </div>
                            <!--table end-->
                        </form>
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
    CKEDITOR.replace( 'page_content' );
    $("#contentForm").submit( function(e) {
        var messageLength = CKEDITOR.instances['page_content'].getData().replace(/<[^>]*>/gi, '').length;
        if( !messageLength ) {
            alert( 'Please enter  content' );
            e.preventDefault();
        }
    });
    $("document").ready(function(){
        setTimeout(function(){
            $(".alert").remove();
        }, 3000 );
    });

</script>   
@endsection