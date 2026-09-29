import { defineConfig } from 'vite'

export default defineConfig({
    build: {
        rollupOptions: {
            input: {
                topics: 'blocks/topics/index.js',
                agenda: 'blocks/agenda/index.js',
                people: 'blocks/people/index.js',
                pricingTable: 'blocks/pricing-table/index.js',
                hero: 'blocks/hero/index.js',
                aboutUs: 'blocks/about-us/index.js',
                video: 'blocks/video/index.js',
                community: 'blocks/community/index.js',
                header: 'blocks/header/index.js',
                footer: 'blocks/footer/index.js',
                eventHero: 'blocks/event-hero/index.js',
                pageHero: 'blocks/page-hero/index.js',
                whyGive: 'blocks/why-give/index.js',
                giftOptions: 'blocks/gift-options/index.js',
                callToAction: 'blocks/call-to-action/index.js',
                faq: 'blocks/faq/index.js',
                contactBanner: 'blocks/contact-banner/index.js',
                registrationOptions: 'blocks/registration-options/index.js',
                whatsIncluded: 'blocks/whats-included/index.js',
                infoCards: 'blocks/info-cards/index.js',
                imageHero: 'blocks/image-hero/index.js',
                vision: 'blocks/vision/index.js',
                mission: 'blocks/mission/index.js',
                goals: 'blocks/goals/index.js',
                committee: 'blocks/committee/index.js',
            },
            output: {
                dir: 'build'
            }
        }
    }
});