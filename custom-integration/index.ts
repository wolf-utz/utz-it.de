import type { AstroIntegration } from 'astro';

export default function nodeWorker(): AstroIntegration {
  const integration: AstroIntegration = {
    name: 'custom:dev-tools',
    hooks: {
      'astro:config:setup': ({ addDevToolbarApp }) => {
        addDevToolbarApp({
          id: 'custom:dev-tools',
          name: 'Development Tools',
          icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-code-xml"><path d="m18 16 4-4-4-4"/><path d="m6 8-4 4 4 4"/><path d="m14.5 4-5 16"/></svg>',
          entrypoint: new URL('./entrypoint.ts', import.meta.url),
        });
      },
    },
  };

  return integration;
}
