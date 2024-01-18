import { startStimulusApp } from '@symfony/stimulus-bundle';
// import ModalController from './controllers/modal-controller.js';

const app = startStimulusApp();
// register any custom, 3rd party controllers here

// app.register('some_controller_name', SomeImportedController);
// app.register('modal', ModalController)
import './styles/app.css'
import './styles/calendar.css'

import './js/calendar.js'
import './js/delete.js'
import './js/isRead.js'
import './js/modal.js'