@extends('layouts.adminapp')

@section('content')

      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-plus-square-o"></i> Edit Blog</h3>
                <a href="{{ url('admin/blogs') }}" class="btn btn-warning pull-right">Cancel</a>
            </div>
            <!-- /.box-header -->
            
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/blogs/edit').'/'.$editBlog->id }}" enctype="multipart/form-data">
              <div class="box-body">
              {{ csrf_field() }}
                <!-- text input -->            
                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                  <label for="link" class="col-sm-2 control-label">Title<span style="color: red;"> *</span></label>
                  <div class="col-sm-10">
                  	<input type="text" class="form-control" id="title" name="title" value="{{ $editBlog->title!='' ? $editBlog->title : old('title') }}">
                  </div>  
                </div>
                
                <div class="form-group">
                  <label for="link" class="col-sm-2 control-label">Description<span style="color: red;"> *</span></label>
                  <div class="col-sm-10">
                  		 <textarea id="editor1" name="description" rows="10" cols="80">
                          {{ $editBlog->description!='' ? $editBlog->description : old('description') }}
                    	</textarea>
                  </div>
                 </div>
               
               <div class="form-group">
                  <label for="image" class="col-sm-2 control-label">Featured Image</label>
                  <div class="col-sm-10">
                  @if(file_exists(public_path($editBlog->featured_image)) &&  $editBlog->featured_image!='')
                  	<img src="{{URL::asset($editBlog->featured_image)}}" width="200"><br/>
                  @endif 
                  	<input type="file" id="exampleInputFile" name="featured_image" accept="image/*">
                      <small class="text-danger">Upload image of size 800 X 400 at least</small>
                  </div> 
               </div>
               
               <div class="form-group">
                  <label for="categories" class="col-sm-2 control-label">Categories</label>
                  <div class="col-sm-10">
                  	@php
                    	$cat = [];
                        if($editBlog->categories!=''){
                        	$cat = explode(',', $editBlog->categories);
                        }
                    	
                    @endphp
                  	@foreach ($categories as $category)
                                    <input type="checkbox" name="categories[]" class="flat-red" value="{{ $category->id }}" {{ in_array($category->id,$cat) ? 'checked="checked"' : '' }}>{{ "&nbsp; ".$category->name }} <br/>
                               		@if(count($category->childs)>0)
				                        @include('admin/blog/manageBlogChild',['childs' => $category->childs, 'selectCategory'=>$editBlog->categories])
				                    @endif
                    @endforeach
                  </div>  
               </div>

{{--              <div class="form-group">--}}
{{--                  <label for="tags" class="col-sm-2 control-label">Tags</label>--}}
{{--                  <div class="col-sm-10">--}}
{{--                      @php--}}
{{--                          $all_tag = [];--}}
{{--                          if($editBlog->tags!=''){--}}
{{--                              $all_tag = explode(',', $editBlog->tags);--}}
{{--                          }--}}

{{--                      @endphp--}}
{{--                      @foreach ($tags as $tag)--}}
{{--                          <input type="checkbox" name="tags[]" class="flat-red" value="{{ $tag->id }}" {{ in_array($tag->id,$all_tag) ? 'checked="checked"' : '' }}>{{ "&nbsp; ".$tag->name }} <br/>--}}
{{--                          @if($tag)--}}
{{--                              @include('admin/blog/manageBlogChild',['childs' => $tag->childs, 'selectTag'=>$editBlog->tags])--}}
{{--                          @endif--}}
{{--                      @endforeach--}}
{{--                  </div>--}}
{{--              </div>--}}

              <div class="form-group">
                  <label class="col-sm-2 control-label" for="related_post">Related Post</label>
                  <div class="col-sm-10">
                      <input type="checkbox" name="related_post" id="related_post" class="flat-red" value="1" {{ (old('related_post') == 1 || $editBlog->related_post == 1) ? 'checked="checked"' : '' }}>{{ "&nbsp; Enable as a related post " }}
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-sm-2 control-label" for="featured_post">Featured Post</label>
                  <div class="col-sm-10">
                      <input type="checkbox" name="featured_post" id="featured_post" class="flat-red" value="1" {{ (old('featured_post') == 1 || $editBlog->featured_post == 1) ? 'checked="checked"' : '' }}>{{ "&nbsp; Enable as a featured post " }}
                  </div>
              </div>
              <div class="form-group">
                  <label for="status" class="col-sm-2 control-label">Visibility</label>
                   <div class="col-sm-10">
                        <select class="form-control" name="status">
                            <option value="1" {{ (old('status') == 1 || $editBlog->visibility == 1) ? 'selected="selected"' : '' }}>Enable</option>
                            <option value="2" {{ (old('status') == 2 || $editBlog->visibility == 2) ? 'selected="selected"' : '' }}>Disable</option>
                        </select>
                  </div>
              </div>

                  
                <hr/>
                <div class="form-group">
                  <label for="page_title" class="col-sm-2 control-label">Meta Title</label>
                  <div class="col-sm-10">
                  	<textarea class="form-control" rows="3" id="page_title" name="page_title" placeholder="Meta Title.">{{ $editBlog->page_title != '' ? $editBlog->page_title :  old('page_title') }}</textarea>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="page_keyword" class="col-sm-2 control-label">Meta Keyword</label>
                  <div class="col-sm-10">
                  	<textarea class="form-control" rows="3" id="page_keyword" name="page_keyword" placeholder="Meta Keyword.">{{ $editBlog->page_keyword != '' ? $editBlog->page_keyword :  old('page_keyword') }}</textarea>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="page_description" class="col-sm-2 control-label">Meta Description</label>
                  <div class="col-sm-10">
                  	<textarea class="form-control" rows="3" id="page_description" name="page_description" placeholder="Meta Description.">{{ $editBlog->page_description != '' ? $editBlog->page_description :  old('page_description') }}</textarea>
                  </div>
                </div>
                
                
				<div class="box-footer">
                	<button type="submit" class="btn btn-info pull-right">Update</button>
              	</div>
                
			</div>
            <!-- /.box-body -->
         </form>
           
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (left) -->
        <!-- right column -->
        
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
@endsection
@section('scripts')

<!-- CK Editor -->
<script src="{{ asset('assets/admin/plugins/ckeditor/ckeditor.js') }}"></script>

<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1',{
					extraPlugins: 'uploadimage',
					
					filebrowserBrowseUrl: "{{ asset('assets/admin/plugins/ckfinder/ckfinder.html') }}",
					filebrowserImageBrowseUrl: "{{ asset('assets/admin/plugins/ckfinder/ckfinder.html?type=Images') }}",
					filebrowserUploadUrl: "{{ asset('assets/admin/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}",
					filebrowserImageUploadUrl: "{{ asset('assets/admin/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}"
	});
  });
  $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
  });
  $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
  });
</script>

@stop