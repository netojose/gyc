import Alpine from 'alpinejs'
import gycFaq from './faq.js'
import gycEventModal from './event-modal.js'

window.Alpine = Alpine

Alpine.data('gycFaq', gycFaq)
Alpine.data('gycEventModal', gycEventModal)

Alpine.start()
