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
                        <?php 
                            //print_r($data1); die;
                        ?>
                    </div>
                    
                        <!--table-start -->
						 <div class="col-sm-12 top_selling">
                            <div class="inside">
							<form method="post" id="sliderForm" enctype="multipart/form-data" action="{{ URL('/superadmin/cms/') }}">
							  @csrf
                                <div class="title"> Become Affiliate Button</div>
                                <div class="row">
                                    <div class="col-sm-6">                                
                                        <div class="form-group">
                                            <div class="title">Button Text</div>
                                            <input class="form-control" type="text" name="become_affiliate_button" value="{{$data['become_affiliate_button']}}" />
                                        </div>
                                    </div>
                                </div>
								<div class="row text-center">
									<div class="col-sm-12">
									<input type="hidden" name="type" value="affiliate" />    
									<input type="hidden" name="section" value="affiliate_button" />    
									<div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg text-center">Save</button></div>
									</div>
								</div>
							</form>	
                            </div>                    
                        </div>
                        <div class="col-sm-12 top_selling">
                            <div class="inside">
							<form method="post" id="sliderForm" enctype="multipart/form-data" action="{{ URL('/superadmin/cms/') }}">
							  @csrf
                                <div class="title"> Banner Section</div>
                                <div class="row">
                                    <div class="col-sm-6">                                
                                        <div class="form-group">
                                            <div class="title">Banner Title</div>
                                            <input class="form-control" type="text" name="banner_title" value="{{$data['banner']['banner_title']}}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">   
                                            <div class="title">Banner Content</div> 
                                            <textarea class="form-control" name="banner_content" rows="5" cols="70">{{$data['banner']['banner_content']}}</textarea>
                                        </div>   
                                    </div>
									
                                </div>
								<div class="row text-center">
									<div class="col-sm-12">
									<input type="hidden" name="type" value="affiliate" />    
									<input type="hidden" name="section" value="affiliate_banner" />    
									<div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg text-center">Save</button></div>
									</div>
								</div>
							</form>	
                            </div>                    
                        </div>
                        <div class="col-sm-12 top_selling">
                            <div class="inside">
							<form method="post" id="getstartedForm" enctype="multipart/form-data" action="{{ URL('/superadmin/cms/') }}">
							  @csrf
								<div class="page-header">
								<div class="title">Get Started Section</div>
									<hr class="dashed">
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<div class="title">Title</div>
											<input class="form-control req" type="text" name="title" value="{{$data['get_started']['title']}}" />
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<div class="title">Description</div>
											<textarea class="form-control req" name="description">{{$data['get_started']['description']}}</textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<div class="title">Title 1</div> 
											<input class="form-control" type="text" name="title_1"  value="{{$data['get_started']['box']['title_1']}}" />
										</div>   
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<div class="title">Content 1</div>
											<textarea class="form-control" name="content_1" rows="5" cols="50">{{$data['get_started']['box']['content_1']}}</textarea>
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="title">Title 2</label>
											<input type="text" class="form-control" name="title_2"  value="{{$data['get_started']['box']['title_2']}}" />
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="title">Content 2</label>
											<textarea class="form-control" name="content_2" rows="5" cols="50">{{$data['get_started']['box']['content_2']}}</textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="title">Title 3</label>
											<input class="form-control" type="text" name="title_3"  value="{{$data['get_started']['box']['title_3']}}" />
										</div>
									</div>
									
									<div class="col-sm-6">
										<div class="form-group">
											<label class="title">Content 3</label>
											<textarea class="form-control" name="content_3" rows="5" cols="50">{{$data['get_started']['box']['content_3']}}</textarea>
										</div>
									</div>
								</div>
								<div class="row text-center">
								<div class="col-sm-12">
								<input type="hidden" name="type" value="affiliate" />   
								<input type="hidden" name="section" value="affiliate_get_started" />    
								<div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg">Save</button></div>
								</div>
								</div>
								</form>
                            </div>
                            </div>
                        </div>
						
						<form method="post" id="getStartedForm" enctype="multipart/form-data" action="{{ URL('/superadmin/cms/') }}" style="width:96%">
                         @csrf
                        <div class="col-sm-12 top_selling">
                            <div class="inside">
								<div class="page-header">
									<div class="title">After Get Started Section</div>
									<hr class="dashed">
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<div class="title">Title</div>
											<input class="form-control req" type="text" name="title" value="{{$data['after_getstarted']['title']}}" />
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<div class="title">Description</div>
											<textarea class="form-control req" name="description">{{$data['after_getstarted']['description']}}</textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<div class="title">Box Title 1</div> 
											<input class="form-control req" type="text" name="title_1"  value="{{$data['after_getstarted']['box']['title_1']}}" />
										</div>
									</div>
									
									<div class="col-sm-6">
										<div class="form-group">
											<div class="title">Content 1</div>
											<textarea class="form-control req" name="content_1" rows="5" cols="50">{{$data['after_getstarted']['box']['content_1']}}</textarea>
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="title">Box Title 2</label>
											<input type="text" class="form-control req" name="title_2"  value="{{$data['after_getstarted']['box']['title_2']}}" />
										</div>
									</div>
									
									<div class="col-sm-6">
										<div class="form-group">
											<label class="title">Content 2</label>
											<textarea class="form-control req" name="content_2" rows="5" cols="50">{{$data['after_getstarted']['box']['content_2']}}</textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="title">Box  Title 3</label>
											<input class="form-control req" type="text" name="title_3"  value="{{$data['after_getstarted']['box']['title_3']}}" />
										</div>
									</div>
									
									<div class="col-sm-6">
										<div class="form-group">
											<label class="title">Content 3</label>
											<textarea class="form-control req" name="content_3" rows="5" cols="50">{{$data['after_getstarted']['box']['content_3']}}</textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="title">Box  Title 4</label>
											<input class="form-control req" type="text" name="title_4"  value="{{$data['after_getstarted']['box']['title_4']}}" />
										</div>
									</div>
									
									<div class="col-sm-6">
										<div class="form-group">
											<label class="title">Content 4</label>
											<textarea class="form-control req" name="content_4" rows="5" cols="50">{{$data['after_getstarted']['box']['content_4']}}</textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="title">Box  Title 5</label>
											<input class="form-control req" type="text" name="title_5"  value="{{$data['after_getstarted']['box']['title_5']}}" />
										</div>
									</div>
									
									<div class="col-sm-6">
										<div class="form-group">
											<label class="title">Content 5</label>
											<textarea class="form-control req" name="content_5" rows="5" cols="50">{{$data['after_getstarted']['box']['content_5']}}</textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="title">Box  Title 6</label>
											<input class="form-control req" type="text" name="title_6"  value="{{$data['after_getstarted']['box']['title_6']}}" />
										</div>
									</div>
									
									<div class="col-sm-6">
										<div class="form-group">
											<label class="title">Content 6</label>
											<textarea class="form-control req" name="content_6" rows="5" cols="50">{{$data['after_getstarted']['box']['content_6']}}</textarea>
										</div>
									</div>
								</div>
								<div class="row text-center">
									<div class="col-sm-12">
									<input type="hidden" name="type" value="affiliate" /> 
									<input type="hidden" name="section" value="affiliate_after_get_started" /> 
									<div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg">Save</button></div>
									</div>
								</div>
								
                            </div>
                        </div>
                    </form>
                                            
                        <div class="col-sm-12 top_selling">
                            <div class="inside">
							<form method="post" id="benefitsForm" enctype="multipart/form-data" action="{{ URL('/superadmin/cms/') }}">
							  @csrf
                                <div class="title">Program Benefits Section</div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="title">Title</label>
                                            <input type="text" class="form-control" name="title" value="{{$data['program_benefits']['title']}}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="title">Description</label>
                                            <textarea class="form-control" id="program_benefits_description" name="program_benefits_description" rows="10" cols="80">{!!$data['program_benefits']['description']!!}</textarea>
                                        </div>
                                    </div>
                                </div>
								<div class="row text-center">
									<div class="col-sm-12">
									<input type="hidden" name="section" value="affiliate_program_benefits" /> 
									<input type="hidden" name="type" value="affiliate" /> 														
									<div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg">Save</button></div>
									</div>
								</div>
								</form>
                            </div>
                        </div>
                        <!--table-end-->
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
CKEDITOR.replace( 'program_benefits_description' );

	$("document").ready(function(){
        setTimeout(function(){
            $(".alert").remove();
        }, 5000 );
    });
</script>   
@endsection   