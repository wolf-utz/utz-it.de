import { defineConfig } from 'astro/config';

// https://astro.build/config
export default defineConfig({
    optimizeDeps: {
      exclude: [
        'astro/runtime/client/dev-toolbar/entrypoint.js'
      ]
    }
});
