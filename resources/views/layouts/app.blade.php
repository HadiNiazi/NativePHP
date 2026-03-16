<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Tracker - Dashboard</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gradient-to-br from-indigo-500 to-purple-600 font-sans min-h-screen">

    <!-- Alert Container -->
    <div id="alertContainer" class="position-fixed top-0 end-0 p-3" style="z-index: 1050; min-width: 300px;"></div>

    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    @include('partials.footer')

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Task Form Handler (inline to ensure immediate execution) -->
    <script>
        let isSubmitting = false;

        function attachFormHandler() {
            const taskForm = document.getElementById('taskForm');
            if (!taskForm) return;

            // Remove before adding to prevent duplicate listeners
            taskForm.removeEventListener('submit', handleFormSubmit);
            taskForm.addEventListener('submit', handleFormSubmit);
        }

        async function handleFormSubmit(e) {
            e.preventDefault();

            if (isSubmitting) return;
            isSubmitting = true;

            const submitBtn = document.getElementById('formSubmitBtn');
            const originalText = submitBtn.textContent;

            submitBtn.disabled = true;
            submitBtn.textContent = originalText === 'Update Task' ? 'Updating...' : 'Creating...';

            try {
                // Get form values
                const taskId = document.getElementById('taskId').value;
                const title = document.getElementById('taskTitle').value.trim();
                const description = document.getElementById('taskDescription').value.trim();
                const status = document.getElementById('taskStatus').value;
                const priority = document.getElementById('taskPriority').value;
                const due_date = document.getElementById('taskDueDate').value || null;
                const csrfToken = document.querySelector('input[name="_token"]').value;

                // Validation
                if (!title) {
                    showAlert('Error', 'Title is required', 'danger');
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                    isSubmitting = false;
                    return;
                }

                // Determine if creating or updating
                const isEdit = taskId && taskId !== '';
                const url = isEdit ? `/tasks/${taskId}` : '/tasks';
                const actionMsg = isEdit ? 'updated' : 'created';

                const bodyData = {
                    title,
                    description,
                    status,
                    priority,
                    due_date
                };

                // Use POST with _method spoofing for updates (NativePhP compatibility)
                if (isEdit) {
                    bodyData._method = 'PUT';
                }

                // Send request
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(bodyData)
                });

                const data = await response.json();

                if (response.ok) {
                    showAlert('Success', `Task ${actionMsg} successfully!`, 'success');

                    // Add or update task in list without full reload
                    if (isEdit && window.updateTaskInList) {
                        window.updateTaskInList(data.task);
                    } else if (!isEdit && window.addTaskToList) {
                        window.addTaskToList(data.task);
                    }

                    // Reset form to create mode
                    if (window.resetFormToCreate) {
                        window.resetFormToCreate();
                    }

                    // Re-enable submit button
                    submitBtn.disabled = false;
                    isSubmitting = false;
                } else {
                    let errorMessage = data.message || 'An error occurred';
                    if (data.errors) {
                        errorMessage = Object.values(data.errors).flat().join(', ');
                    }
                    showAlert('Error', errorMessage, 'danger');
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                    isSubmitting = false;
                }
            } catch (error) {
                showAlert('Error', error.message || 'Network error occurred', 'danger');
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                isSubmitting = false;
            }
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

            // Auto-dismiss after 5 seconds
            setTimeout(() => {
                try {
                    new bootstrap.Alert(alertDiv).close();
                } catch (e) {
                    alertDiv.remove();
                }
            }, 5000);
        }

        // Initialize when DOM is ready
        document.addEventListener('DOMContentLoaded', attachFormHandler);
        if (document.readyState !== 'loading') {
            attachFormHandler();
        }
    </script>

    @vite(['resources/js/app.js'])
</body>
</html>
