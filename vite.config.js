import { defineConfig } from 'vite'

export default defineConfig({
    build: {
        rollupOptions: {
            input: {
                topics: 'blocks/topics/index.js',
                agenda: 'blocks/agenda/index.js',
                people: 'blocks/people/index.js',
                pricingTable: 'blocks/pricing-table/index.js',
            }
        }
    }
});