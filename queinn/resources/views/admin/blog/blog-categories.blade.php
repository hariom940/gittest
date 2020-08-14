@extends('layouts.adminapp')

@section('content')

      <div class="row">
        <!-- left column -->
        <div class="col-md-4">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Add New Blog Category</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form" method="POST" id="admin_login" action="{{ url('/admin/blogs/categories/add') }}" enctype="multipart/form-data">
              {{ csrf_field() }}
                <!-- text input -->
                <div class="form-group{{ $errors->has('catname') ? ' has-error' : '' }}">
                  <label>Name</label>
                  <input type="text" class="form-control" name="catname" value="{{ old('catname') }}" placeholder="The name is how it appears on your site.">
                </div>
                <div class="form-group">
                  <label>Slug</label>
                  <input type="text" class="form-control" name="slug" value="{{ old('slug') }}" placeholder="The 'slug' is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.">
                </div>
                
                <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" rows="3" name="description" placeholder="The description is not prominent by default; however, some themes may show it.">{{ old('description') }}</textarea>
                </div>
                
                <div class="form-group">
                  <label>Thumbnail</label>
                  <input type="file" id="exampleInputFile" name="thumbnail" accept="image/*">
                </div>
                
                <div class="form-group">
                  <label>Status</label>
                  <select class="form-control" name="status">
                  			<option value="1">Enable</option>
                            <option value="2">Disable</option>
                  </select>
                </div>

              <hr>

              <div class="form-group">
                  <label for="page_title" class="control-label">Meta Title</label>
                  <div class="">
                      <textarea class="form-control" rows="3" id="page_title" name="page_title" placeholder="Meta Title.">{{ old('page_title') }}</textarea>
                  </div>
              </div>

              <div class="form-group">
                  <label for="page_keyword" class="control-label">Meta Keyword</label>
                  <div class="">
                      <textarea class="form-control" rows="3" id="page_keyword" name="page_keyword" placeholder="Meta Keyword.">{{ old('page_keyword') }}</textarea>
                  </div>
              </div>

              <div class="form-group">
                  <label for="page_description" class="control-label">Meta Description</label>
                  <div class="">
                      <textarea class="form-control" rows="3" id="page_description" name="page_description" placeholder="Meta Description.">{{ old('page_description') }}</textarea>
                  </div>
              </div>
                
				<div class="box-footer">
                	<button type="submit" class="btn btn-info pull-right">Add New Blog Category</button>
              	</div>
                

              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-8">
        	<div class="box box-info">
            <!-- /.box-header -->
            <div class="box-body">
            <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th class="no-sort">Image</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Slug</th>
                  <th class="no-sort">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                   @foreach ($categories as $category)
                    <tr>
                    	<td>
                         
                        	@if (file_exists(public_path($category->image)) && $category->image!='')
                        		<img src="{{URL::asset($category->image)}} " alt="{{$category->image}}" width="50">
                            @else
                                <img src="{{ asset('assets/uploads/no_img.gif') }}" alt="{{$category->name}}" width="50">
                            @endif
                        </td>
                        <td>{{$category->name}}</td>
                        <td>{{$category->description}}</td>
                        <td>{{$category->slug}}</td>
                        <td>
                        	<a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit Category" href="{{ url('/admin/blogs/categories/edit').'/'.$category->id }}"> <i class="fa fa-edit"></i> </a>
                        	<a class="btn btn-danger btn-xs deleteBlogCategory" href="javascript:;" data-id="{{ $category->id }}" data-toggle="tooltip" title="Delete Category"> <i class="fa fa-remove"></i> </a> 	
                        </td>
                    </tr>
                        @if(count($category->childs)>0)
                            @include('admin/blog/listBlogChild',['childs' => $category->childs])
                        @endif
                    @endforeach 

                </tbody>
                <tfoot>
                <tr>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Slug</th>
                  <th></th>
                </tr>
                </tfoot>
              </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
@endsection