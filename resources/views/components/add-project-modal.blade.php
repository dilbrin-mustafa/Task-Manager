<div id="add-project-modal" {{ $attributes->merge(['class' => 'fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50']) }}>
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
