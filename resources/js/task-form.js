// Task Form Handler using Fetch API
function initTaskForm() {
    const taskForm = document.getElementById('taskForm');
    
    if (!taskForm) return;
    
    taskForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        console.log('Form submitted');
        
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
            console.error('Error:', error);
            showAlert('Error', error.message || 'An error occurred', 'danger');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });
}

// Show Bootstrap alert that auto-dismisses after 5 seconds
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

