@extends('layout.default')
@section('css')
    <style>
        .task {
            border: 1px solid;
            border-radius: 13px;
            padding: 8px;
            margin: 5px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
        }

        .task>div.actions {
            display: flex;
            gap: 12px;
        }

        .drag {
            padding: 15px 0;
        }

        .high>.task {
            border-color: red;
        }

        .medium>.task {
            border-color: orange;
        }

        .low>.task {
            border-color: green;
        }
    </style>
@endsection
@section('content')
    <section style="width:100%">
        <div class="row">
            <div class="col-lg-12 mt-2">
                <a href="{{ route('task.create') }}" class="btn btn-primary" style="float: right">Add New</a>
            </div>
        </div>
        <div class="row">
            {{-- High Priority Box --}}
            <div class="col-lg-12 col-md-12 mt-3 mb-3">
                <h4>High Priority Tasks</h4>
                <div class="drag high" ondragover="allowDrop(event)" ondrop="drop(event, 'high')">
                    @if (isset($tasks['High']))
                        @foreach ($tasks['High'] as $task)
                            <div id="{{ $task['id'] }}" class="task" draggable="true" ondragstart="drag(event)">
                                {{ $task['task'] }}

                                {{-- Display Action Button --}}
                                <div class="actions">
                                    <a href="{{ route('task.show', $task['id']) }}">
                                        <i>Edit</i>
                                    </a>
                                    <form method="POST" action="{{ route('task.destroy', $task['id']) }}">
                                        @method('DELETE')
                                        @csrf
                                        <button style="background: white; border: 0;" type="submit">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- Medium Priority Box --}}
            <div class="col-lg-12 col-md-12 mt-3 mb-3">
                <h4>Medium Priority Tasks</h4>
                <div class="drag  medium" ondragover="allowDrop(event)" ondrop="drop(event, 'medium')">
                    @if (isset($tasks['Medium']))
                        @foreach ($tasks['Medium'] as $task)
                            <div id="{{ $task['id'] }}" class="task" draggable="true" ondragstart="drag(event)">
                                {{ $task['task'] }}

                                {{-- Display Action Button --}}
                                <div class="actions">
                                    <a href="{{ route('task.show', $task['id']) }}">
                                        <i>Edit</i>
                                    </a>
                                    <form method="POST" action="{{ route('task.destroy', $task['id']) }}">
                                        @method('DELETE')
                                        @csrf
                                        <button style="background: white; border: 0;" type="submit">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- Low priority Box  --}}
            <div class="col-lg-12 col-md-12 mt-3 mb-3 ">
                <h4>Low Priority Tasks</h4>
                <div class="drag low" ondragover="allowDrop(event)" ondrop="drop(event, 'low')">
                    @if (isset($tasks['Low']))
                        @foreach ($tasks['Low'] as $task)
                            <div id="{{ $task['id'] }}" class="task" draggable="true" ondragstart="drag(event)">
                                {{ $task['task'] }}

                                {{-- Display Action Button --}}
                                <div class="actions">
                                    <a href="{{ route('task.show', $task['id']) }}">
                                        <i>Edit</i>
                                    </a>
                                    <form method="POST" action="{{ route('task.destroy', $task['id']) }}">
                                        @method('DELETE')
                                        @csrf
                                        <button style="background: white; border: 0;" type="submit">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script type="text/javascript">
        // Allow element to drop
        function allowDrop(e) {
            e.preventDefault()
        }

        // Get & Set element Dragable event
        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
        }

        // Drop element
        function drop(ev, priority) {
            ev.preventDefault();
            var data = ev.dataTransfer.getData("text");
            ev.target.appendChild(document.getElementById(data));

            // Update Record in Database
            $.ajax({
                method: 'post',
                url: "{{ route('task.update-priority') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: data,
                    priority
                }
            })
        }
    </script>
@endsection
