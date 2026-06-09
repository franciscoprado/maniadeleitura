/**
 * Mobile menu toggle functionality
 */
(function () {
  var btn = document.getElementById('menu-toggle');
  var mobileMenu = document.getElementById('mobile-menu');
  var iconOpen = document.getElementById('icon-menu');
  var iconClose = document.getElementById('icon-close');
  if (!btn || !mobileMenu) return;
  btn.addEventListener('click', function() {
    var expanded = btn.getAttribute('aria-expanded') === 'true';
    btn.setAttribute('aria-expanded', String(!expanded));
    mobileMenu.classList.toggle('hidden');
    if (iconOpen && iconClose) {
      iconOpen.classList.toggle('hidden');
      iconClose.classList.toggle('hidden');
    }
  });

  // Optional: close the menu when a link is clicked (mobile)
  var links = mobileMenu.querySelectorAll('a');
  Array.prototype.forEach.call(links, function(link) {
    link.addEventListener('click', function() {
      if (!mobileMenu.classList.contains('hidden')) {
        mobileMenu.classList.add('hidden');
        btn.setAttribute('aria-expanded', 'false');
        if (iconOpen && iconClose) {
          iconOpen.classList.remove('hidden');
          iconClose.classList.add('hidden');
        }
      }
    });
  });
})();
