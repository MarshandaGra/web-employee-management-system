@extends('dashboard.layouts.main')

@section('content')
    <div class="container py-2">
        <div class="d-flex flex-column flex-md-row justify-content-between mb-4">
            <div class="dropdown mb-3 mb-md-0">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Pilih Kanban
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @forelse ($kanbanboards as $board)
                        <li><a class="dropdown-item" href="{{ route('kanbanboard.index', ['id' => $board->id]) }}">
                                {{ $board->name }}
                            </a>
                        </li>
                    @empty
                        <li><a class="dropdown-item">Not Available.</a></li>
                    @endforelse
                </ul>
            </div>

            <h1 class="text-center m-0">{{ $kanbanboard->name ?? 'Kanban Board' }}</h1>
            <button type="button" class="btn btn-outline-primary" @if (!isset($kanbanboard)) disabled @endif
                data-bs-toggle="modal" data-bs-target="#createTaskModalTodo{{ $kanbanboard->id ?? '' }}">
                Create Task
            </button>
        </div>
        <div class="row g-4">
            @isset($kanbanboard)
                @foreach (['todo' => 'To Do', 'progress' => 'In Progress', 'done' => 'Done'] as $status => $statusTitle)
                    <div class="col-md-12 col-lg-4">
                        <div class="card">
                            <div
                                class="card-header bg-{{ $status === 'todo' ? 'primary' : ($status === 'progress' ? 'warning' : 'success') }} text-white">
                                {{ $statusTitle }}
                            </div>
                            <div class="card-body">
                                @forelse ($$status as $task)
                                    @include('kanbanboard.partial.task-card', [
                                        'task' => $task,
                                        'nextStatus' =>
                                            $status === 'todo'
                                                ? 'progress'
                                                : ($status === 'progress'
                                                    ? 'done'
                                                    : ''),
                                    ])
                                    @include('kanbanboard.partial.edit-task-modal', [
                                        'modalId' => 'editTaskModal' . $task->id,
                                        'title' => 'Edit Task',
                                        'actionUrl' => route('kanbantasks.update', $task->id),
                                        'method' => 'patch',
                                        'buttonText' => 'Update Task',
                                        'task' => $task,
                                    ])
                                @empty
                                    <p class="text-center">No tasks available.</p>
                                @endforelse
                            </div>
                            <div class="card-footer text-center">
                                <button data-bs-toggle="modal"
                                    data-bs-target="#createTaskModal{{ ucfirst($status) }}{{ $kanbanboard->id ?? '' }}"
                                    class="btn btn-sm btn-outline-{{ $status === 'todo' ? 'primary' : ($status === 'progress' ? 'warning' : 'success') }}">
                                    + Add Task
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center">
                    <img src="{{ asset('assets/images/no-data.png') }}" alt="No Data" class="img-fluid"
                        style="width: clamp(150px, 50vw, 400px);">
                    <p class="mt-2">No Kanban Board Available.</p>
                </div>
            @endisset
        </div>
    </div>

    @foreach (['todo' => 'To Do', 'progress' => 'In Progress', 'done' => 'Done'] as $status => $statusTitle)
        @include('kanbanboard.partial.task-modal', [
            'modalId' => 'createTaskModal' . ucfirst($status) . ($kanbanboard->id ?? ''),
            'title' => 'Create New Task',
            'actionUrl' => route('kanbantasks.store'),
            'method' => 'post',
            'buttonText' => 'Create',
            'status' => $status,
            'task' => new \App\Models\KanbanTasks(),
        ])
    @endforeach
@endsection
