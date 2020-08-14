@extends('layouts.adminapp')

@section('content')  
		
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Blog Category</h3>
              <a href="{{ url('/admin/blogs/categories') }}" class="btn btn-warning pull-right">Back</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form" method="POST" action="{{ url('/admin/blogs/categories/edit/'.$editCategory->id) }}" enctype="multipart/form-data">
              {{ csrf_field() }}
                <!-- text input -->
                <div class="form-group{{ $errors->has('catname') ? ' has-error' : '' }}">
                  <label>Name</label>
                  <input type="text" class="form-control" name="catname" value="{{ $editCategory->name != '' ? $editCategory->name : old('catname') }}" placeholder="The name is how it appears on your site.">
                </div>
                <div class="form-group">
                  <label>Slug</label>
                  <input type="text" class="form-control" name="slug" value="{{ $editCategory->slug != '' ? $editCategory->slug : old('slug') }}" placeholder="The 'slug' is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.">
                </div>
                
                <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" rows="3" name="description" placeholder="The description is not prominent by default; however, some themes may show it.">{{ $editCategory->description != '' ? $editCategory->description :  old('description') }}</textarea>
                </div>
                
                <div class="form-group">
                  <label>Thumbnail</label>
                  @if(file_exists(public_path($editCategory->image)) &&  $editCategory->image!='')
                  <img src="{{URL::asset($editCategory->image)}}" width="70">
                  @endif<br/>
                  <input type="file" id="exampleInputFile" name="thumbnail" accept="image/*">
                </div>
                
                 <div class="form-group">
                  <label>Status</label>
                  <select class="form-control" name="status">
                  			<option value="1" {{ $editCategory->visibile_status == '1' ? 'selected="selected"' : '' }}>Enable</option>
                            <option value="2" {{ $editCategory->visibile_status == '2' ? 'selected="selected"' : '' }}>Disable</option>
                  </select>
                </div>

                <hr>

                <div class="form-group">
                  <label for="page_title" class="control-label">Meta Title</label>
                  <div class="">
                    <textarea class="form-control" rows="3" id="page_title" name="page_title" placeholder="Meta Title.">@if($editCategory->page_title != ""){{ $editCategory->page_title }}@else{{ old('page_title') }}@endif</textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label for="page_keyword" class="control-label">Meta Keyword</label>
                  <div class="">
                    <textarea class="form-control" rows="3" id="page_keyword" name="page_keyword" placeholder="Meta Keyword.">@if($editCategory->page_keyword != ""){{ $editCategory->page_keyword }}@else{{ old('page_keyword') }}@endif</textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label for="page_description" class="control-label">Meta Description</label>
                  <div class="">
                    <textarea class="form-control" rows="3" id="page_description" name="page_description" placeholder="Meta Description.">@if($editCategory->page_description != ""){{ $editCategory->page_description }}@else{{ old('page_description') }}@endif</textarea>
                  </div>
                </div>
                
				<div class="box-footer">
                	<button type="submit" class="btn btn-info pull-right">Update Blog Category</button>
              	</div>
                

              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (left) -->
        <!-- right column -->
        
        <!--/.col (right) -->
      </div>
      <!-- /.row -->

@endsection