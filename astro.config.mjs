import { defineConfig } from 'astro/config';
import myIntegration from './custom-integration';

// https://astro.build/config
export default defineConfig({
  integrations: [myIntegration()],
  vite: {
    optimizeDeps: {
      exclude: ['astro/runtime/client/dev-toolbar/entrypoint.js'],
    },
  },
});
