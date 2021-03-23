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
                        <div class="col-sm-12 top_bar_area">
                            <div class="row">
								<div class="col-sm-4 from_to_filter">
									<div class="view_back"><a onClick="goBack();" href="javascript:void(0);"><i class="fa fa-arrow-left"></i></a></div>
									<div id="historyCount" style="display:none;">1</div>
									<div class="title">Back</div>
								</div>
                                <div class="col-sm-8 top_btns">
                                <button class="btn btn-primary" id="add-category" data-toggle="modal" data-title="Add category" data-url="{{ URL::route('superadminAddnewsCategory')}}" data-target="#createCatModal">Add Category<i class="fa fa-plus"></i></button>
                                    <!--a class="btn btn-info" href="{{ URL('/superadmin/news/list/') }}"  data-title="view News"  >View News<i class="fa fa-eye"></i></a-->
									<a class="btn btn-info" href="{{ URL('/superadmin/news/role/') }}"  data-title="view Roles"  >View Roles<i class="fa fa-eye"></i></a>
                                </div>
                            </div>
                        </div>  
                        <!--table start -->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Category List</div>
									<table class="display responsive nowrap" id="catWrap" width="100%">
										<thead>
										    <tr>
										        <th>Sr. No.</th>
                                                <th>Category Name</th>
												<th>URL</th>
												<th>Actions</th>
										    </tr>
										</thead>
										<tbody>
                                         @foreach($data as $category)							    
                                            <tr>
                                                <td></td>
                                                <td>{{$category->name}}</td>
                                                <td>{{$category->category_url}}</td>
                                                <td>
                                                    <button data-url="{{URL::route('superadminViewNewsCategoryEdit', $category->id)}}" data-title="Edit Category" type="button" class="btn btn-success edit-category" id="edit-category" data-catid="{{$category->id}}" >Edit</button>
                                                    <a class="btn btn-danger deleteCategory" data-catid="{{$category->id}}" href="#">delete</a>
                                                  
                                                </td>
                                            </tr>
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
     <!-- popup start from here-->
     <div class="modal fade" id="createCatModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
              
                <div class="modal-header">
                    <h4 class="modal-title"><b>Add New Category</b></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="/superadmin/news/category" method="post" id="catForm" >
                <!-- <meta name="csrf-token" content="{!! csrf_token() !!}"> -->
                {{@csrf_field()}}
                <div class="modal-body register_new_user">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="hidden" name="cat_id" class="form-control" id="cat_id">
                                <input type="hidden" name="url" value="/superadmin/news/category" class="form-control" >
                                <input type="hidden" name="slug" value="" >
                                <input type="text" id="name" name="name" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer pl-0 pr-0">
                    <div class="col-md-12 text-center p-0"> 
                        <button type="button" id="save_button" class="btn btn-success btn-submit save_button">Add</button>
                        <button type="button" id="update_button" style="display:none;" class="btn btn-success btn-submit update_button">Update</button>
                        <a href="#" type="btn" class="btn btn-secondary ml-1" data-dismiss="modal">Cancel</a>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
    <!-- popup end here-->
@endsection
@section('page_js') 
<script>
    var validator;
    $(function() {
        validator = $('#catForm').validate({
            rules: {
                name:{
                    required:true,
                    alpha: true
                }
            },
        
            errorPlacement: function(label, element) {
                label.addClass('text-danger');
                label.insertAfter(element);
            },
            wrapper: 'span'
        });
        $.validator.addMethod("alpha", function(value, element) {
           
            return this.optional(element) || value == value.match(/^[a-z0-9\-\s]+$/i);
        }, "Letters only please");
    });
  
    $('.btn-submit').click(function(){
        //debugger;
        if($("#catForm").valid()){ 
			$('#loader').show();
            var _token      =  $("input[name='_token']").val();
            var url         = $("input[name='url']").val();
            var slug         = $("input[name='slug']").val();
            var name        = $("input[name='name']").val();
            var cat_id        = $("input[name='cat_id']").val();
         
            $.ajax({
                url: url,
                type:'POST',
                headers: {
                    'X-CSRF-TOKEN': _token
                },
                data: { name: name, slug: slug,id:cat_id },
                success: function(data) {

                    if($.isEmptyObject(data.error)){
						$('#loader').hide();
                        alert(data.success);
                        jQuery('.alert-danger').hide();
                        $('#createCatModal').modal('hide');
                        location.reload();
                    }else{
						$('#loader').hide();
						alert(data.error);
                       // printErrorMsg(data.error);
                        
                    }
                }
            });
        }
    });
    $("document").ready(function(){
        var t_aboutSliders =  $('#catWrap').DataTable({
            "order": [[ 0, 'desc' ]]          
        });

        t_aboutSliders.on( 'order.dt search.dt', function () {
            t_aboutSliders.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        }).draw();

    });

   
 //on add button
    $(document).on('click', "#add-category", function() {
       
       var options = {
           'backdrop': 'static'
       };
       $('#catForm')
           .find('[name="url"]')
           .val($(this).data('url'))
           .end();
       var title = $(this).data('title');
       var modal = $('#createCatModal').modal(options);
       modal.find('.modal-title').text(title);
       $("#catForm").trigger("reset");
      
      
       validator.resetForm();
       $('.save_button').show();
       $('.update_button').hide();
   });
    //Edit News
    $(document).on('click', "#edit-category", function() {        
        $(this).addClass('edit-item-trigger-clicked'); 
        //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.
        var cat_id = $(this).data("catid");
        $('#catForm')
           .find('[name="url"]')
           .val($(this).data('url'))
           .end();
        $.ajax({
            type: "GET",
            url: "{{route('superadminViewAjaxRequest')}}",
            data: { id: cat_id, type: "getCatById" },
            success: function(data) {                
                if ($.isEmptyObject(data.error)) {
                    //len = length;
                    //console.log("content "+data['data'].description);
                    if (data['data']) {
                        $("input[name='cat_id']").val(data['data'].id);
                        $("input[name='name']").val(data['data'].name);
                        $("input[name='slug']").val(data['data'].url);
                  
                        
                    } else {
                        alert("Something went wrong!");
                    }
                } else {
                    alert(data.error);               
                }
            }       
        });

        var options = {
            'backdrop': 'static'
        };
        var title = $(this).data('title');
        var modal = $('#createCatModal').modal(options);
        modal.find('.modal-title').text(title);
        $('#catForm').find('[name="url"]').val($(this).data('url')).end();
        //show/hide button
        $("#catForm").trigger("reset");
        validator.resetForm();
        $('.save_button').hide();
        $('.update_button').show();
    });

    $(document).on('click', '.deleteCategory', function (e) {
        $row =  $(this).parent().parent();
        e.preventDefault();
        var catid = $(this).data('catid');
        swal({
                title: "Are you sure!",
                type: "error",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes!",
                showCancelButton: true,
            },
            function() {
            $.ajax({
                type: "GET",
                url: "{{route('superadminViewAjaxRequest')}}",
                data: { id: catid, type: "deleteNewsCategory" },
                success: function(data){
                    
                    if($.isEmptyObject(data.error)){
                        
                        swal("Deleted!", data.success, "success"); 
						location.reload();
                        $row.remove();
                        
                    }else{
                        
                        swal("Cancelled", data.error, "error");   
                    }

                }       
            });
        });
    });
    function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }
	goBack = function() {
        historyCount = parseInt($('#historyCount').text());
        history.go(-historyCount);
    }
    
</script>
@endsection