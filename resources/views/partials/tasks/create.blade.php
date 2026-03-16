<div class="lg:col-span-1 lg:sticky lg:top-6 z-20">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 id="formTitle" class="text-xl font-semibold text-gray-800 mb-4">Create New Task</h3>

        <form id="taskForm" class="space-y-4">
            @csrf
            <input type="hidden" id="taskId" name="taskId" value="">

            <!-- Title -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Task Title *</label>
                <input type="text" id="taskTitle" name="title" class="w-full border-2 border-gray-200 rounded-md px-3 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500" placeholder="Enter task title" required>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="taskDescription" name="description" rows="3" class="w-full border-2 border-gray-200 rounded-md px-3 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500" placeholder="Enter task description"></textarea>
            </div>

            <!-- Status & Priority -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="taskStatus" name="status" class="w-full border-2 border-gray-200 rounded-md px-3 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500">
                        <option value="Pending">Pending</option>
                        <option value="In Progress" selected>In Progress</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                    <select id="taskPriority" name="priority" class="w-full border-2 border-gray-200 rounded-md px-3 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500">
                        <option value="Low">Low</option>
                        <option value="Medium" selected>Medium</option>
                        <option value="High">High</option>
                    </select>
                </div>
            </div>

            <!-- Due Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Due Date</label>
                <input type="date" id="taskDueDate" name="due_date" class="w-full border-2 border-gray-200 rounded-md px-3 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500">
            </div>

            <!-- Actions -->
            <div class="flex gap-2">
                <button type="submit" id="formSubmitBtn" class="flex-1 bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2 rounded-md shadow">Create Task</button>
                <button type="button" id="formResetBtn" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 rounded-md shadow">Clear</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Function to reset form to create mode
    window.resetFormToCreate = function() {
        document.getElementById('taskId').value = '';
        document.getElementById('formTitle').textContent = 'Create New Task';
        document.getElementById('formSubmitBtn').textContent = 'Create Task';
        document.getElementById('taskForm').reset();
    };

    // Function to load task into form for editing
    window.editTask = async function(taskId) {
        try {
            const response = await fetch(`/tasks/${taskId}`);
            const data = await response.json();

            if (data.success) {
                const task = data.task;
                document.getElementById('taskId').value = taskId;
                document.getElementById('formTitle').textContent = 'Edit Task';
                document.getElementById('formSubmitBtn').textContent = 'Update Task';
                document.getElementById('taskTitle').value = task.title;
                document.getElementById('taskDescription').value = task.description || '';
                document.getElementById('taskStatus').value = task.status;
                document.getElementById('taskPriority').value = task.priority;
                document.getElementById('taskDueDate').value = task.due_date ? task.due_date.split('T')[0] : '';
            } else {
                window.showAlert('Error', 'Failed to load task', 'danger');
            }
        } catch (error) {
            console.error('Error:', error);
            window.showAlert('Error', 'Network error occurred', 'danger');
        }
    };

    // Handle clear button
    document.getElementById('formResetBtn').addEventListener('click', function() {
        window.resetFormToCreate();
    });
</script>

