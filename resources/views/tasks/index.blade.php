@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-xl shadow-2xl overflow-hidden">

        <div class="px-6 py-5 sm:px-8 sm:py-6 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <h1 class="text-3xl font-bold text-gray-900">
                    Task Manager
                </h1>

                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <form action="{{ route('tasks.index') }}" method="GET" id="project-filter-form" class="w-full sm:w-auto">
                        <select name="project_id"
                                class="w-full form-select block px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                onchange="document.getElementById('project-filter-form').submit()">
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}" {{ $project->id == $selectedProjectId ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                    <button type="button"
                            class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 shadow-md focus:outline-none focus:ring-2 focus:ring-green-500"
                            onclick="document.getElementById('add-project-modal').classList.remove('hidden')">
                        + Add Project
                    </button>
                </div>
            </div>
        </div>

        <div id="add-project-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6">
                <h2 class="text-xl font-bold mb-4">Add New Project</h2>
                <form action="{{ route('projects.store') }}" method="POST">
                    @csrf
                    <label for="project_name" class="block text-sm font-medium text-gray-700 mb-2">Project Name</label>
                    <input type="text" name="name" id="project_name"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 mb-4"
                           placeholder="e.g., Marketing Campaign" required>
                    <div class="flex justify-end gap-2">
                        <button type="button"
                                class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300"
                                onclick="document.getElementById('add-project-modal').classList.add('hidden')">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700">
                            Add Project
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <x-add-project-modal />
        <div class="px-6 py-5 sm:px-8 sm:py-6">

            @include('partials.validation-message')
            @include('partials.response-message')
            <form action="{{ route('tasks.store') }}" method="POST" class="mb-6">
                @csrf
                <input type="hidden" name="project_id" value="{{ $selectedProjectId }}">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">New Task</label>
                <div class="flex flex-col sm:flex-row gap-2">
                    <input type="text" name="name" id="name"
                           class="flex-grow form-input block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="e.g., Buy milk and cookies">
                    <button type="submit"
                            class="w-full sm:w-auto shrink-0 px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Add Task
                    </button>
                </div>
            </form>

            <ul id="task-list" class="space-y-3" data-project-id="{{ $selectedProjectId }}">
                @forelse ($tasks as $task)
                    <li class="task-item flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 px-5 py-4 bg-gray-50 rounded-lg border border-gray-200 shadow-sm cursor-move"
                        data-task-id="{{ $task->id }}">

                        <div class="task-view w-full sm:w-auto flex-grow flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <span class="task-name text-lg font-medium text-gray-800">{{ $task->name }}</span>
                        </div>

                        <form action="{{ route('tasks.update', $task) }}" method="POST" class="edit-form w-full sm:w-auto flex-grow flex items-center gap-2 hidden">
                            @csrf
                            @method('PUT')
                            <input type="text" name="name" value="{{ $task->name }}"
                                   class="flex-grow form-input block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <button type="submit" class="px-3 py-2 rounded-md text-sm font-medium text-white bg-green-600 hover:bg-green-700 shadow-sm">Save</button>
                            <button type="button" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300" onclick="toggleEdit(this, false)">Cancel</button>
                        </form>

                        <div class="task-item-right w-full sm:w-auto shrink-0 flex justify-end gap-2">
                            <button class="px-3 py-1.5 rounded-md text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 shadow-sm" onclick="toggleEdit(this, true)">
                                Edit
                            </button>

                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-md text-sm font-medium text-white bg-red-600 hover:bg-red-700 shadow-sm">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="text-center py-10 text-gray-500 italic">
                        No tasks for this project yet. Add one!
                    </li>
                @endforelse
            </ul>
        </div>
    </div>


    <script>
        // --- Edit Task Toggle ---
        function toggleEdit(buttonElement, isEditing) {
            const taskItem = buttonElement.closest('.task-item');
            const viewMode = taskItem.querySelector('.task-view');
            const editMode = taskItem.querySelector('.edit-form');
            const actionButtons = taskItem.querySelector('.task-item-right');

            if (isEditing) {
                // Hide view and actions, show edit form
                viewMode.classList.add('hidden');
                actionButtons.classList.add('hidden');
                editMode.classList.remove('hidden');
                editMode.querySelector('input[name="name"]').focus();
            } else {
                // Show view and actions, hide edit form
                viewMode.classList.remove('hidden');
                actionButtons.classList.remove('hidden');
                editMode.classList.add('hidden');
            }
        }

        // --- Drag-and-Drop Reordering ---
        document.addEventListener('DOMContentLoaded', function () {
            const taskList = document.getElementById('task-list');
            if (taskList) {
                new Sortable(taskList, {
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    onEnd: function (evt) {
                        const taskItems = taskList.querySelectorAll('.task-item');
                        const taskIds = Array.from(taskItems).map(item => {
                            return item.getAttribute('data-task-id');
                        });
                        sendNewOrder(taskIds);
                    }
                });
            }
        });

        function sendNewOrder(taskIds) {
            const reorderUrl = '{{ route("tasks.reorder") }}';

            axios.post(reorderUrl, {
                taskIds: taskIds,
                _token: '{{ csrf_token() }}'
            })
                .then(response => {
                    console.log('Order updated successfully');
                })
                .catch(error => {
                    console.error('Error updating order:', error);
                    alert('There was an error updating the task order.');
                });
        }
    </script>
@endsection
