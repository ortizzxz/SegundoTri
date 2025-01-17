document.addEventListener('DOMContentLoaded', function() {
    const section = document.querySelector('.heroGT2');
    const tabs = document.querySelectorAll('.nav-link');
  
    tabs.forEach(tab => {
      tab.addEventListener('show.bs.tab', function(event) {
        switch(event.target.id) {
          case 'pills-home-tab':
            section.style.backgroundImage = 'url("./img/displayGarage.jpg")';
            break;
          case 'pills-gt2-tab':
            section.style.backgroundImage = 'url("./img/GT2RS.jpg")';
            break;
          case 'pills-gt3-tab':
            section.style.backgroundImage = 'url("./img/GT3RS.webp")';
            break;
          case 'pills-918-tab':
            section.style.backgroundImage = 'url("./img/918.jpg")';
            break;
        }
      });
    });
  });
  