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
        function initTaskForm() {
            const taskForm = document.getElementById('taskForm');

            if (!taskForm) return;

            taskForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const submitBtn = taskForm.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                const csrfToken = document.querySelector('input[name="_token"]').value;

                // Disable submit button
                submitBtn.disabled = true;
                submitBtn.textContent = 'Creating...';

                try {
                    const response = await fetch('/tasks', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (response.ok) {
                        showAlert('Success', data.message, 'success');
                        taskForm.reset();
                    } else {
                        let errorMessage = data.message || 'An error occurred while creating the task.';

                        if (data.errors) {
                            const errorList = Object.values(data.errors).flat().join(', ');
                            errorMessage = errorList;
                        }

                        showAlert('Error', errorMessage, 'danger');
                    }
                } catch (error) {
                    showAlert('Error', error.message || 'An error occurred', 'danger');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            });
        }

        function showAlert(title, message, type) {
            const alertContainer = document.getElementById('alertContainer');

            const alertHTML = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert" style="min-width: 320px;">
                    <strong>${title}:</strong> ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;

            const alertElement = document.createElement('div');
            alertElement.innerHTML = alertHTML;
            const alert = alertElement.firstElementChild;
            alertContainer.appendChild(alert);

            // Auto-dismiss after 5 seconds
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();

                setTimeout(function() {
                    alert.remove();
                }, 150);
            }, 5000);
        }

        // Initialize form when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initTaskForm);
        } else {
            initTaskForm();
        }
    </script>

    @vite(['resources/js/app.js'])
</body>
</html>
