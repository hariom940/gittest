
@extends('master')
@section('content')
<div class="container-fluid">
  
        <div class="container">
          
            <div class="col-md-9 col-lg-8 mx-auto">
              <h3 class="login-heading mb-4">Welcome User Dashboard!</h3>
              
                   {{ csrf_field() }}
                    Welcome {{$task->name}}
                  <div class="card-body">
                    <a href="{{url('user_logout')}}" class="btn btn-primary">Logout</a>
                  </div>
                     <div class="panel-heading">
  <a href="{{ route('create') }}" class="btn btn-info" type="submit">Add</a>
      </div>
                  

<table class="table table-bordered text-center">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Serial No.</th>
      <th scope="col">Task Name</th>
      <th scope="col">Person Name</th>
      <th scope="col">Due Date</th>
      <th scope="col">Status</th>
    <th scope="col">Sub Task</th>
    <th scope="col">Date</th>
    <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
     
    <tr>
      <td>{{$task->id}}</td>
      <td>{{$task->task_name}}</td>
      <td>{{$task->name}}</td>
      <td>{{$task->Due_Date}}</td>
      <td>{{$task->Status}}to</td>
       <td>{{$task->sub_task}}</td>
      <td>{{$task->Date}}</td>
      <td>
      <form  method="post" action="#" class="delete_form">
                          {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <a href="#" class="btn btn-xs btn-primary">Edit</a>
                    
        <a href="#" class="btn btn-xs btn-success">View</a>

                        <button class="btn btn-xs btn-danger" type="submit" onclick="return confirm('Are You Sure? Want to Delete It.');">Delete</button>
                  </form>
      </td>
      
    </tr>
    
    
  </tbody>
</table>

    </div>
  </div>
</div>
 @endsection
