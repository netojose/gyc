import Alpine from 'alpinejs'
import gycFaq from './faq.js'
import gycEventModal from './event-modal.js'
import gycEventsFilter from './events-filter.js'
import gycPeople from './people.js'
import gycCountdown from './countdown.js'
import initTilt from './tilt.js'
import initRegistrationOpens from './registration-opens.js'

window.Alpine = Alpine

Alpine.data('gycFaq', gycFaq)
Alpine.data('gycEventModal', gycEventModal)
Alpine.data('gycEventsFilter', gycEventsFilter)
Alpine.data('gycPeople', gycPeople)
Alpine.data('gycCountdown', gycCountdown)

Alpine.start()

initTilt()
initRegistrationOpens()
