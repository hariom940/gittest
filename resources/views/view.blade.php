@extends('master')
@section('content')

<div class="container">
	<div class="row">
		<h1> Simple Task Operation</h1> 
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading">
			 Student Detail
		</div>
		<div class="panel-body">
			@if ($errors->any())
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			@endif
			<form action="{{ route('update',$tasks->id) }}" method="get">
				{{ csrf_field() }}
				<div class="row">

					 <div class="form-group row">
						<div class="col-sm-1"> </div>
						<label class="col-sm-3" for="name"> Name </label>
						 <div class="col-sm-4">
						  {{ $tasks->name }}
						</div>
					</div> 


					<div class="form-group row">
						<div class="col-sm-1"> </div>
						<label class="col-sm-3" for="task_name">Task Name</label>
						 <div class="col-sm-4">
						 {{ $tasks->task_name }}
						</div>
					</div>    

					<div class="form-group row ">
						<div class="col-sm-1"> </div>
						<label class="col-sm-3" for="address">Sub Task</label>
						<div class="col-sm-4">
						{{ $tasks->sub_task }}
						</div>
						
					</div> 
	 				  
					<div class="form-group row">
						<div class="col-sm-1"> </div>
						<label class="col-sm-3" for="date">Start Date</label>
						<div class="col-sm-4">
						{{ $tasks->start_date }}
						</div>
					</div> 

					<div class="form-group row">
						<div class="col-sm-1"> </div>
						<label  class="col-sm-3" for="email">End Date</label>
						 <div class="col-sm-4">
						 {{ $tasks->end_date }}
						</div>
					</div>	

					<div class="form-group row">
						<div class="col-sm-1"> </div>
						<label  class="col-sm-3" for="email">Select Status</label>
						<div class="col-sm-4">
						@if($tasks->status =='1')         
							Pending       
						@elseif($tasks->status =='2')
							Complete      
						@endif
						</div>
					</div> 

					<div class="form-group row">
						<div class="col-sm-4"> </div> 
						<div class="col-sm-4"> 
							<a href="{{route('dashboard')}}" class="btn btn-danger">Back</a>
						</div>
					</div> 
 
					
					
					
				</form>
			</div>
		</div>
	</div>
	


	@endsection