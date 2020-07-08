@extends('master')
@section('content')

<div class="container">
	<div class="row">
		<h1> Simple Task Operation</h1>
		
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading">
			Create New Student
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
							<input type="text" class="form-control" placeholder="Enter person Name" name="name" id="name" value="{{ $tasks->name }}">
						</div>
					</div> 


					<div class="form-group row">
						<div class="col-sm-1"> </div>
						<label class="col-sm-3" for="task_name">Task Name</label>
						 <div class="col-sm-4">
							<input type="text" class="form-control" placeholder="Enter task Name" name="task_name" id="task_name" value="{{ $tasks->task_name }}">
						</div>
					</div>    
				<?php 
					$subTaskArray = explode(',',$tasks->sub_task); 
					$num = 0;
					foreach($subTaskArray as $key=>$val){
				?>
					<div class="form-group row subtask_<?php echo $key;?>">
						<div class="col-sm-1"> </div> 
						<label class="col-sm-3" for="address">	<?php if($num ==0){ echo "Sub Task"; }?></label> 
						<div class="col-sm-4">
							<input type="text" class="form-control" placeholder="sub task" name="sub_task[]" value="{{$val}}">
						</div>
						<div class="col-sm-1">
							<?php if($num ==0){ ?>
							<p><span class="glyphicon glyphicon-plus addSubTask" ></span></p> 
							<?php }else{ ?>
							<p><span onclick="removeTask(<?php echo $num;?>)" class="glyphicon glyphicon-minus" ></span></p>
							<?php } ?> 
						</div> 
					</div>  
					<?php $num++; } ?>	
				 
	 				 
	 				 <div class="subtaskdiv">
	 				 </div>	
                 
					<div class="form-group row">
						<div class="col-sm-1"> </div>
						<label class="col-sm-3" for="date">Date</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="date" id="date" value="{{ $tasks->start_date }}">
						</div>
					</div> 

					<div class="form-group row"> 
						<div class="col-sm-1"> </div>
						<label  class="col-sm-3" for="email">Due Date</label>
						 <div class="col-sm-4">
							<input type="text" class="form-control" placeholder="Email" name="due_date" id="due_date" value="{{ $tasks->end_date }}">
						</div>
					</div>	

					<div class="form-group row">
						<div class="col-sm-1"> </div>
						<label  class="col-sm-3" for="email">Select Status</label>
						 
						<div class="col-sm-4">
							<div class="dropdown">
								<select class="form-control" name ="status">
									<option value="">Status</option>
									<option value="1">pending</option>
									<option value="2">complete</option>
									<option value="3">overdue</option>
								</select> 
							</div>
						</div>
						 
					</div> 

					<div class="form-group row">
						<div class="col-sm-4"> </div> 
						<div class="col-sm-4">
							<button type="submit" class="btn btn-primary">Update</button>
						    <a href="{{route('dashboard')}}" class="btn btn-danger">Back</a>
						</div>
					</div> 
 
					
					
					
				</form>
			</div>
		</div>
	</div>
	
<script>
$(document).ready(function(){
	var num = '<?php echo count($subTaskArray)+1;?>';
  $(".addSubTask").click(function(){ 
  	 $('.subtaskdiv').append('<div class="form-group row subtask_'+num+'"><div>&nbsp;</div><div class="col-sm-1"> </div>	<label class="col-sm-3" for="address"> </label><div class="col-sm-4"><input type="text" class="form-control" placeholder="sub task" name="sub_task[]"></div><div class="col-sm-1"><p><span onclick="removeTask('+num+')" class="glyphicon glyphicon-minus" ></span></p> </div></div>  ');
  	 num++;
  });
 

});

function removeTask(id){
	 $('.subtask_'+id).hide();
}
	 
</script>

	@endsection