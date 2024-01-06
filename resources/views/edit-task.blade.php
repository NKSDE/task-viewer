<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" >
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="row mt-3">
        <div class="col-6">
            <form action="{{ route('update-task') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card center">
                <div class="card-header">
                    Update Task
                </div>
                <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                   
                    <div class="row mt-2">
                        <div class="col-2">
                            <Label>Name :</Label>
                        </div>
                        <div class="col-8">
                            <input type="hidden" name="task_id" value="{{ $task->id }}">
                            <input type="text" name="name" class="form-control" id="name" value="{{ $task->name }}">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-2">
                            <Label>Descrition :</Label>
                        </div>
                        <div class="col-8">
                            <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{ $task->description }}</textarea>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-2">
                            <Label>Priority :</Label>
                        </div>
                        <div class="col-8">
                            <select name="priority" id="priority" class="form-control">
                                <option value="Low" {{ $task->priority == 'Low' ? 'selected' : '' }}>Low</option>
                                <option value="Medium" {{ $task->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                                <option value="High " {{ $task->priority == 'High' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-4">
                            <img src="{{ asset('storage/task-image/'.$task->image) }}" width="50px" height="50px" alt="Image">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-2">
                            <Label>Image :</Label>
                        </div>
                        <div class="col-8">
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-3">
                            <Label>Completed :</Label>
                        </div>
                        <div class="col-8 d-flex">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="completed" id="Yes" value="1" {{ $task->compelted == true ? 'checked' : ''}} >
                                <label class="form-check-label" for="Yes">
                                  Yes
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="completed" id="No" value="0" {{ $task->compelted == false ? 'checked' : ''}} >
                                <label class="form-check-label" for="No">
                                  No
                                </label>
                              </div>
                        </div>
                    </div>
                    
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('task-list') }}" class="btn btn-primary" >Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>