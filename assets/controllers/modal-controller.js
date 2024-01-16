import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    modal = null;

    connect() {
        this.modal = document.querySelectorAll('[data-toggle="modal"]');
        this.modal.forEach((element) => {
            element.addEventListener('click', (event) => {
                event.preventDefault();
                const target = element.dataset.modalId;
                const modal = document.getElementById(target);
                modal.classList.toggle('opacity-0');
                modal.classList.toggle('pointer-events-none');
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
            });
        });
    }
}
