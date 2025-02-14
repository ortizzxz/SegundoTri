document.addEventListener('DOMContentLoaded', () => {
  const menuToggle = document.querySelector('.menu-toggle');
  const navbarLinks = document.querySelector('.navbar-links');

  menuToggle.addEventListener('click', (event) => {
    event.stopPropagation();
    navbarLinks.classList.toggle('active');
  });

  document.addEventListener('click', (event) => {
    if (navbarLinks.classList.contains('active') && !navbarLinks.contains(event.target)) {
      navbarLinks.classList.remove('active');
    }
  });
});

