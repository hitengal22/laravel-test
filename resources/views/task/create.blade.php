@extends('layout.default')

@section('content')
    <section style="width:100%">
      
      {{-- Dispaly Heading and Main Success & Error message --}}
      <div class="row col-lg-12 mt-3">
            <h3>Create a new task</h3>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('fail'))
                <div class="alert alert-danger">{{ session('fail') }}</div>
            @endif
        </div>

        {{-- Task Form --}}
        <form method="POST" action="{{ route('task.store') }}">
            @csrf
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <input type="text" class="form-control" placeholder="Please enter task name.." name="task"
                        required />
                    @error('task')
                        <div class="alret alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12">
                    <select class="form-control" name="priority" required>
                        <option value="">Please Select Priority</option>
                        <option value="High">High</option>
                        <option value="Medium">Medium</option>
                        <option value="Low">Low</option>
                    </select>
                    @error('priority')
                        <div class="alret alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </section>
@endsection
