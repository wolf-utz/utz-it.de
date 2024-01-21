import { ScrollSpy } from 'bootstrap';

const mainNav: HTMLDivElement | null = document.querySelector('#mainNav');
const navbarToggler: HTMLButtonElement | null = document.querySelector('.navbar-toggler');

function navbarShrink() {
  if (!mainNav) {
    return;
  }
  if (window.scrollY === 0) {
    mainNav.classList.remove('navbar-shrink');
  } else {
    mainNav.classList.add('navbar-shrink');
  }
}

// Initially Shrink the navbar.
navbarShrink();

// Shrink the navbar when page is scrolled.
document.addEventListener('scroll', navbarShrink);

// Activate Bootstrap scrollspy on the main nav element.
if (mainNav) {
  new ScrollSpy(document.body, {
    target: '#mainNav',
    rootMargin: '0px 0px -40%',
  });
}

// Collapse responsive navbar when toggler is visible.
document.querySelectorAll('#navbarResponsive .nav-link').forEach((responsiveNavItem) => {
  responsiveNavItem?.addEventListener('click', () => {
    if (navbarToggler && window.getComputedStyle(navbarToggler).display !== 'none') {
      navbarToggler.click();
    }
  });
});
