const modals = document.querySelectorAll('[data-toggle="modal"]');
modals.forEach((element) => {
    element.addEventListener('click', (event) => {
        event.preventDefault();
        const target = element.dataset.modalId;
        const modal = document.getElementById(target);
        modal.classList.toggle('opacity-0');
        modal.classList.toggle('pointer-events-none');

        const modalContent = modal.querySelector('.modal-content');
        modalContent.classList.toggle('translate-y-8');
        modalContent.classList.toggle('-translate-y-1/2');
        modalContent.classList.toggle('scale-75');
    });
});

const closeButtons = document.querySelectorAll('[data-close-modal]');
closeButtons.forEach((element) => {
    element.addEventListener('click', (event) => {
        event.preventDefault();
        const target = element.dataset.closeModal;
        const modal = document.getElementById(target);
        modal.classList.toggle('opacity-0');
        modal.classList.toggle('pointer-events-none');

        const modalContent = modal.querySelector('.modal-content');
        modalContent.classList.toggle('translate-y-8');
        modalContent.classList.toggle('-translate-y-1/2');
        modalContent.classList.toggle('scale-75');
    });
});