/**
 * AOS scroll animations, smooth in-page navigation, page fade-in.
 */
(function () {
  'use strict';

  function initAOS() {
    if (typeof AOS !== 'undefined') {
      AOS.init({
        duration: 850,
        easing: 'ease-out-cubic',
        once: true,
        offset: 64,
        delay: 0,
      });
    }
  }

  function smoothAnchors() {
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
      anchor.addEventListener('click', function (e) {
        var id = this.getAttribute('href');
        if (id.length <= 1) return;
        var target = document.querySelector(id);
        if (target) {
          e.preventDefault();
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });
    });
  }

  function pageFadeReady() {
    // Allow CSS transition after first paint
    requestAnimationFrame(function () {
      document.body.classList.add('page-ready');
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    initAOS();
    smoothAnchors();
    pageFadeReady();
  });
})();
