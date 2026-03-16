<div class="lg:col-span-2 space-y-6">
    <div class="bg-white rounded-xl shadow-lg p-6">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
            <h3 class="text-2xl font-bold text-gray-800">My Tasks</h3>
            <div class="flex gap-4 flex-wrap">
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium text-gray-600">Filter:</label>
                    <select id="taskFilter" class="border-2 border-gray-200 rounded-md px-2 py-1 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500">
                        <option value="All Tasks">All Tasks</option>
                        <option value="Pending">Pending</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium text-gray-600">Sort:</label>
                    <select id="taskSort" class="border-2 border-gray-200 rounded-md px-2 py-1 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500">
                        <option value="newest">Newest First</option>
                        <option value="due_date">Due Date</option>
                        <option value="priority">Priority</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Task Items Container -->
        <div id="tasksList" class="space-y-4">
            <!-- Tasks will be loaded here dynamically -->
            <div class="text-center py-8 text-gray-500">
                <p>Loading tasks...</p>
            </div>
        </div>
    </div>
</div>

<script>
    // Make loadTasks available globally
    window.loadTasks = loadTasks;
    window.addTaskToList = addTaskToList;
    window.updateTaskInList = updateTaskInList;

    function updateStats() {
        const checkboxes = document.querySelectorAll('#tasksList .taskCheckbox');
        const completed = document.querySelectorAll('#tasksList .taskCheckbox:checked');
        const totalEl = document.getElementById('statTotal');
        const completedEl = document.getElementById('statCompleted');
        if (totalEl) totalEl.textContent = checkboxes.length;
        if (completedEl) completedEl.textContent = completed.length;
    }

    // Load tasks when page loads
    document.addEventListener('DOMContentLoaded', function() {
        loadTasks();

        // Attach event listeners to filter and sort
        document.getElementById('taskFilter').addEventListener('change', loadTasks);
        document.getElementById('taskSort').addEventListener('change', loadTasks);
    });

    // Add event listeners to a task element
    function attachTaskListeners(taskElement, taskId) {
        const deleteBtn = taskElement.querySelector('.deleteTaskBtn');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function() {
                deleteTask(taskId);
            });
        }

        const editBtn = taskElement.querySelector('.editTaskBtn');
        if (editBtn) {
            editBtn.addEventListener('click', function() {
                window.editTask(taskId);
            });
        }

        const checkbox = taskElement.querySelector('.taskCheckbox');
        if (checkbox) {
            checkbox.addEventListener('change', function() {
                updateTaskStatus(taskId, this.checked);
            });
        }
    }

    // Add new task to the list (for create operation)
    function addTaskToList(task) {
        const tasksList = document.getElementById('tasksList');
        const taskHTML = createTaskElement(task);
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = taskHTML;
        const taskElement = tempDiv.firstElementChild;

        // Remove "no tasks" message if exists
        const noTasksMsg = tasksList.querySelector('.text-center');
        if (noTasksMsg) {
            noTasksMsg.remove();
        }

        // Add new task to the top
        tasksList.insertAdjacentElement('afterbegin', taskElement);

        // Attach listeners to the new element
        attachTaskListeners(taskElement, task.id);
        updateStats();
    }

    // Update existing task in the list (for update operation)
    function updateTaskInList(task) {
        const tasksList = document.getElementById('tasksList');
        const taskElement = tasksList.querySelector(`[data-task-id="${task.id}"]`)?.closest('.bg-gray-50');

        if (taskElement) {
            // Replace with updated HTML
            const taskHTML = createTaskElement(task);
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = taskHTML;
            const newElement = tempDiv.firstElementChild;

            taskElement.replaceWith(newElement);
            attachTaskListeners(newElement, task.id);
            updateStats();
        }
    }

    async function loadTasks() {
        const filter = document.getElementById('taskFilter').value;
        const sort = document.getElementById('taskSort').value;
        const tasksList = document.getElementById('tasksList');

        try {
            // Build query params
            const params = new URLSearchParams({
                status: filter,
                sort: sort
            });

            const response = await fetch(`/tasks?${params}`);
            const data = await response.json();

            if (data.success) {
                if (data.tasks.length === 0) {
                    tasksList.innerHTML = '<div class="text-center py-8 text-gray-500"><p>No tasks found</p></div>';
                    return;
                }

                tasksList.innerHTML = data.tasks.map(task => createTaskElement(task)).join('');

                // Attach event listeners to delete buttons
                document.querySelectorAll('.deleteTaskBtn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        deleteTask(this.dataset.taskId);
                    });
                });

                // Attach event listeners to edit buttons
                document.querySelectorAll('.editTaskBtn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        window.editTask(this.dataset.taskId);
                    });
                });

                // Attach event listeners to checkboxes
                document.querySelectorAll('.taskCheckbox').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        updateTaskStatus(this.dataset.taskId, this.checked);
                    });
                });

                updateStats();
            }
        } catch (error) {
            console.error('Error loading tasks:', error);
            tasksList.innerHTML = '<div class="text-center py-8 text-red-500"><p>Error loading tasks</p></div>';
        }
    }

    function createTaskElement(task) {
        const borderColor = {
            'High': 'border-red-500',
            'Medium': 'border-yellow-500',
            'Low': 'border-green-500'
        }[task.priority] || 'border-gray-500';

        const bgColor = {
            'High': 'bg-red-100 text-red-700',
            'Medium': 'bg-yellow-100 text-yellow-800',
            'Low': 'bg-green-100 text-green-800'
        }[task.priority] || 'bg-gray-100 text-gray-700';

        const statusColor = {
            'Pending': 'bg-blue-100 text-blue-800',
            'In Progress': 'bg-gray-200 text-gray-800',
            'Completed': 'bg-green-100 text-green-800',
            'Cancelled': 'bg-red-100 text-red-700'
        }[task.status] || 'bg-gray-100 text-gray-700';

        const isCompleted = task.status === 'Completed';
        const formatDate = (date) => {
            if (!date) return 'No date';
            return new Date(date).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
        };

        const daysAgo = (date) => {
            const now = new Date();
            const created = new Date(date);
            const diff = Math.floor((now - created) / (1000 * 60 * 60 * 24));
            if (diff === 0) return 'Today';
            if (diff === 1) return '1 day ago';
            if (diff < 7) return `${diff} days ago`;
            if (diff < 30) return `${Math.floor(diff / 7)} weeks ago`;
            return `${Math.floor(diff / 30)} months ago`;
        };

        return `
            <div class="bg-gray-50 border-l-4 ${borderColor} rounded-md p-4 hover:shadow-md transition-transform transform hover:translate-x-1">
                <!-- First Row: Title and Actions -->
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" class="taskCheckbox w-5 h-5 accent-indigo-500" data-task-id="${task.id}" ${isCompleted ? 'checked' : ''}>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h4 class="font-semibold text-gray-800 ${isCompleted ? 'line-through' : ''}">${escape(task.title)}</h4>
                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full ${bgColor}">${task.priority}</span>
                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full ${statusColor}">${task.status}</span>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button class="text-indigo-500 hover:bg-indigo-100 px-2 rounded editTaskBtn" data-task-id="${task.id}" title="Edit">✎</button>
                        <button class="text-red-500 hover:bg-red-100 px-2 rounded deleteTaskBtn" data-task-id="${task.id}" title="Delete">✕</button>
                    </div>
                </div>
                <!-- Second Row: Description -->
                ${task.description ? `<p class="text-gray-600 mt-3">${escape(task.description)}</p>` : ''}
                <!-- Third Row: Dates -->
                <div class="flex gap-6 text-gray-500 text-sm mt-2">
                    ${task.due_date ? `<span>📅 Due: ${formatDate(task.due_date)}</span>` : ''}
                    <span>Created: ${daysAgo(task.created_at)}</span>
                </div>
            </div>
        `;
    }

    async function deleteTask(taskId) {
        if (!confirm('Are you sure you want to delete this task?')) {
            return;
        }

        try {
            const response = await fetch(`/tasks/${taskId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ _method: 'DELETE' })
            });

            const data = await response.json();

            if (data.success) {
                showAlert('Success', 'Task deleted successfully!', 'success');
                loadTasks();
            } else {
                showAlert('Error', data.message || 'Error deleting task', 'danger');
            }
        } catch (error) {
            console.error('Error:', error);
            showAlert('Error', 'Network error occurred', 'danger');
        }
    }

    async function updateTaskStatus(taskId, isCompleted) {
        const status = isCompleted ? 'Completed' : 'Pending';

        try {
            const response = await fetch(`/tasks/${taskId}/status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ _method: 'PATCH', status })
            });

            const data = await response.json();

            if (data.success) {
                loadTasks();
            } else {
                showAlert('Error', data.message || 'Error updating task', 'danger');
            }
        } catch (error) {
            console.error('Error:', error);
            showAlert('Error', 'Network error occurred', 'danger');
        }
    }

    function escape(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function showAlert(title, message, type) {
        const alertContainer = document.getElementById('alertContainer');
        if (!alertContainer) return;

        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.setAttribute('role', 'alert');
        alertDiv.style.minWidth = '320px';
        alertDiv.innerHTML = `
            <strong>${title}:</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        alertContainer.appendChild(alertDiv);

        setTimeout(() => {
            try {
                new bootstrap.Alert(alertDiv).close();
            } catch (e) {
                alertDiv.remove();
            }
        }, 5000);
    }
</script>


            </div>
        </div>

        <!-- Task Stats -->
        <div class="bg-gray-100 rounded-md p-4 mt-4 flex justify-around font-semibold text-gray-700">
            <span>Total Tasks: <span id="statTotal">0</span></span>
            <span>Completed: <span id="statCompleted">0</span></span>
        </div>

    </div>
</div>
