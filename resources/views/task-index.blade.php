<!DOCTYPE html>
<html>
<head>
	<title>List</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" >
	<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-12">
				@if (Session::has('success'))
					<div class="alert alert-success">{{ Session::get('success') }}</div>
				@elseif(Session::has('error'))
					<div class="alert alert-danger">{{ Session::get('error') }}</div>
				@endif
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<b>Task List</b>
				<a href="{{ route('add-task') }}">Add Task</a>
			</div>
		</div>

		<div class="row mt-3">
			<div class="col-4">
				<div class="card">
					<div class="card-header">High Priority</div>
				</div>
				<div class="card-body priority-sec" data-priority="High">
					@if(!empty($highPriorityTask)) 
						@foreach($highPriorityTask as $task)
							<div class="card taskDrag" data-task-priority="High" data-task-id = "{{ $task->id }}">
								<div class="card-body">
									<h5 class="card-title">{{ $task->name }}</h5>
									<p class="card-text">
										{{ $task->description }}
										@if(!empty($task->image))
										<img src="{{ asset('storage/task-image/'.$task->image) }}" width="50px" height="50px">
										@endif
									</p>
									<a href="{{ route('edit-task', ['task_id' => $task->id ]) }}" class="btn btn-primary">Edit</a>
									<button class="btn btn-primary deleteTask" >Delete</button>
								</div>
							</div>
						@endforeach
					@endif
				</div>
			</div>
			<div class="col-4">
				<div class="card">
					<div class="card-header">Medium Priority</div>
				</div>
				<div class="card-body  priority-sec" data-priority="Medium">
					@if(!empty($mediumPriorityTask))
						@foreach($mediumPriorityTask as $task)
							<div class="card taskDrag " data-task-priority="Medium" data-task-id = "{{ $task->id }}">
								<div class="card-body">
									<h5 class="card-title">{{ $task->name }}</h5>
									<p class="card-text">
										{{ $task->description }}
										@if(!empty($task->image))
										<img src="{{ asset('storage/task-image/'.$task->image) }}" width="50px" height="50px">
										@endif
									</p>
									<a href="{{ route('edit-task', ['task_id' => $task->id ]) }}" class="btn btn-primary">Edit</a>
									<button class="btn btn-primary deleteTask" >Delete</button>
								</div>
							</div>
						@endforeach
					@endif
				</div>
			</div>
			<div class="col-4">
				<div class="card">
					<div class="card-header">Low Priority</div>
				</div>
				<div class="card-body  priority-sec" data-priority="Low">
					@if(!empty($lowPriorityTask))
						@foreach($lowPriorityTask as $task)
							<div class="card taskDrag" data-task-priority="Low" data-task-id = "{{ $task->id }}">
								<div class="card-body">
									<h5 class="card-title">{{ $task->name }}</h5>
									<p class="card-text">{{ $task->description }}
										@if(!empty($task->image))
										<img src="{{ asset('storage/task-image/'.$task->image) }}" width="50px" height="50px">
										@endif
									</p>
									<a href="{{ route('edit-task', ['task_id' => $task->id ]) }}" class="btn btn-primary">Edit</a>
									<button class="btn btn-primary deleteTask" >Delete</button>
								</div>
							</div>
						@endforeach
					@endif
				</div>
			</div>
		</div>
	</div>
<body>
	<script>
		$('.taskDrag').draggable({revert:'invalid',connectToSortable: ".priority-sec"});
		
		$('.priority-sec').sortable({
			update:function(event,ui){
				$(this).sortable('toArray');
			}
		});
		$('.priority-sec').droppable({
			accept: ".taskDrag",
      drop: function( event, ui ) {
		dropedTask = ui.draggable;
        var task_id = $(dropedTask).attr('data-task-id');
        var task_priority = $(dropedTask).attr('data-task-priority');
		var task_new_priority = $(dropedTask).parent('.priority-sec').attr('data-priority');
		token  = '{{  csrf_token() }}';
		$.ajax({
			url:'{{ route("update-task-priority") }}',
			method:'POST',
			data:{task_id:task_id,task_priority:task_priority,task_new_priority:task_new_priority,_token:token},
			success:function(){
			 console.log('success');
			}
		});
      }
    });
	$(document).on('click','.deleteTask',function(){
		if(confirm('Are You Sure ? ')) {
			var task_id = $(this).parents('.taskDrag').attr('data-task-id');
			currentObject = $(this);
			token  = '{{  csrf_token() }}';
			$.ajax({
				url:'{{ route("delete-task") }}',
				method:'POST',
				data:{task_id:task_id,_token:token},
				success:function(res){
					$(currentObject).parents('.taskDrag').remove();
				}
			});
		}
	});
	
	</script>
</html>