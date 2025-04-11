document.addEventListener('DOMContentLoaded', () => {
    const heroButton = document.querySelector('.btn-watch-now');
    heroButton.addEventListener('click', () => {
        alert('Starting your favorite show!');
    });

    const detailButtons = document.querySelectorAll('.btn-details');
    detailButtons.forEach(button => {
        button.addEventListener('click', () => {
            alert('Showing details!');
        });
    });
});
