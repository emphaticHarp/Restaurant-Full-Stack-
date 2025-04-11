document.addEventListener('DOMContentLoaded', () => {
    const checkButton = document.getElementById('check-password');
    const updateButton = document.getElementById('update-password');
    const newPasswordFields = document.getElementById('new-password-fields');
    const errorModal = document.getElementById('error-modal');
    const successModal = document.getElementById('success-modal');
    
    checkButton.addEventListener('click', async () => {
        const currentPassword = document.getElementById('current-password').value;

        if (currentPassword.trim() === '') {
            showError('Please enter the current password.');
            return;
        }

        try {
            const response = await fetch('password_action.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ currentPassword })
            });
            const data = await response.json();

            if (data.status === 'error') {
                showError(data.message);
            } else if (data.status === 'success') {
                newPasswordFields.style.display = 'block'; // Show the new password fields
            }
        } catch (error) {
            showError('An error occurred. Please try again later.');
        }
    });

    updateButton.addEventListener('click', async () => {
        const newPassword = document.getElementById('new-password').value;

        if (newPassword.trim() === '') {
            showError('Please enter the new password.');
            return;
        }

        try {
            const response = await fetch('password_action.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ newPassword })
            });
            const data = await response.json();

            if (data.status === 'error') {
                showError(data.message);
            } else if (data.status === 'success') {
                showSuccess(data.message);
            }
        } catch (error) {
            showError('An error occurred. Please try again later.');
        }
    });

    function showError(message) {
        const errorMessage = errorModal.querySelector('#error-message');
        errorMessage.textContent = message;
        errorModal.style.display = 'block';
    }

    function showSuccess(message) {
        const successMessage = successModal.querySelector('p');
        successMessage.textContent = message;
        successModal.style.display = 'block';
    }

    document.getElementById('close-error-modal').addEventListener('click', () => {
        errorModal.style.display = 'none';
    });

    document.getElementById('close-success-modal').addEventListener('click', () => {
        successModal.style.display = 'none';
    });
});
