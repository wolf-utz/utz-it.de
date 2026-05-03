import { defineToolbarApp } from 'astro/toolbar';

export default defineToolbarApp({
  init(canvas) {
    canvas.innerHTML =
      '<astro-dev-toolbar-window>Hello world</astro-dev-toolbar-window>';
  },
});
