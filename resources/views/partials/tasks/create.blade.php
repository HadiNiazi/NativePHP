<div class="lg:col-span-1 lg:sticky lg:top-6 z-20">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Create New Task</h3>

        <form id="taskForm" class="space-y-4">
            @csrf
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
                        <option>Pending</option>
                        <option selected>In Progress</option>
                        <option>Completed</option>
                        <option>Cancelled</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                    <select id="taskPriority" name="priority" class="w-full border-2 border-gray-200 rounded-md px-3 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500">
                        <option>Low</option>
                        <option selected>Medium</option>
                        <option>High</option>
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
                <button type="submit" class="flex-1 bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2 rounded-md shadow">Create Task</button>
                <button type="reset" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 rounded-md shadow">Clear</button>
            </div>
        </form>
    </div>
</div>
