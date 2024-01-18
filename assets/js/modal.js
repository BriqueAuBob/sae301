import { deleteAction } from './delete.js';

const getModals = () => {
    const modals = document.querySelectorAll('[data-toggle="modal"]');
    modals.forEach((element) => {
        if(element.hasEvent) return;
        element.addEventListener('click', (event) => {
            event.preventDefault();
            const target = element.dataset.modalId;
            const modal = document.getElementById(target);
            modal.classList.toggle('opacity-0');
            modal.classList.toggle('pointer-events-none');

            fetch(element.dataset.contentUrl).then((res) => res.text()).then((res) => {
                modal.querySelector("#" + target + '-content').innerHTML = res;
                loopDropdowns();
                getCloseButtons();
                getModals();
                deleteAction(document.querySelectorAll('.delete'), (button) => {
                    fetch('/homework/' + button.dataset.homeworkId, {
                        method: 'DELETE',
                    });
                    document.getElementById('card-homework-' + button.dataset.homeworkId).remove();
                    button.remove();

                    modalContent.classList.toggle('translate-y-8');
                    modalContent.classList.toggle('-translate-y-1/2');
                    modalContent.classList.toggle('scale-75');
                    modalContent.classList.toggle('opacity-0');
                    setTimeout(() => {
                        modal.classList.toggle('opacity-0');
                        modal.classList.toggle('pointer-events-none');
                    }, 300)
                })
            })

            const modalContent = modal.querySelector('.modal-content');
            modalContent.classList.toggle('translate-y-8');
            modalContent.classList.toggle('-translate-y-1/2');
            modalContent.classList.toggle('scale-75');
            modalContent.classList.toggle('opacity-0');
        });
        element.hasEvent = true;
    });
}
getModals();

const getCloseButtons = () => {
const closeButtons = document.querySelectorAll('[data-close-modal]');
    closeButtons.forEach((element) => {
        if(element.hasEvent) return;
        element.addEventListener('click', (event) => {
            const target = element.dataset.closeModal;
            const modal = document.getElementById(target);
            modal.classList.toggle('opacity-0');
            modal.classList.toggle('pointer-events-none');

            const modalContent = modal.querySelector('.modal-content');
            modalContent.classList.toggle('translate-y-8');
            modalContent.classList.toggle('-translate-y-1/2');
            modalContent.classList.toggle('scale-75');
            modalContent.classList.toggle('opacity-0');
        });
        element.hasEvent = true;
    });
}
getCloseButtons();

const loopDropdowns = () => {
    const dropdowns = document.querySelectorAll('[data-toggle="dropdown"]');
    dropdowns.forEach((dropdown) => {
        if(dropdown.hasEvent) return;
        dropdown.parentElement.addEventListener('click', (event) => {

            dropdown.classList.toggle('opacity-0');
            dropdown.classList.toggle('pointer-events-none');
            dropdown.classList.toggle('scale-90');
        });
        dropdown.hasEvent = true;
    });
}
loopDropdowns();