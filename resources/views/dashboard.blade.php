@extends('master')
@section('content')
<div class="container-fluid">
  <div class="container">

    <div class="col-md-12">
      <h3 class="login-heading mb-4">Welcome {{ ucwords(session('USER_NAME')) }}</h3>

      {{ csrf_field() }}
      
      <div class="panel-heading">
        <a href="{{ route('create') }}" class="btn btn-primary" type="submit">Add Task</a>
      </div>



      <table class="table table-bordered text-center">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Serial No.</th>
            <th scope="col">Task Name</th>
            <th scope="col">Person Name</th>
            <th scope="col">Start Date</th>
            <th scope="col">End Date</th>
            <th scope="col">Status</th>
            <th scope="col">Sub Task</th> 
            <th scope="col" width="20%">Action</th>
          </tr>
        </thead>
        <tbody>

          @foreach($tasks as $task)
          <tr>
            <th scope="row">{{$loop->index+1 }}</th>
            <td>{{$task->task_name}}</td>
            <td>{{$task->name}}</td>  
            <td>{{$task->start_date}}</td>
            <td>{{$task->end_date}}</td>
            <td> 
            @if($task->status =='1')         
                  Pending       
            @elseif($task->status =='2')
                  Complete      
            @endif
            </td>
            <td>{{$task->sub_task}}</td> 
            <td>
              <form method="post" action="{{ route('delete',$task->id)}}" class="delete_form">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <a href="{{ route('edit',$task->id)}}" class="btn btn-xs btn-primary">Edit</a>

                <a href="{{ route('view',$task->id)}}" class="btn btn-xs btn-success">View</a>

                <button class="btn btn-xs btn-danger" type="submit" onclick="return confirm('Are You Sure? Want to Delete It.');">Delete</button>
              </form>
            </td>

          </tr>

          @endforeach
        </tbody>
      </table>

    </div>
  </div>
</div>
@endsection