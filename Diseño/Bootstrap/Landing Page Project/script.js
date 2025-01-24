document.addEventListener("DOMContentLoaded", function () {
  const section = document.querySelector(".heroGT2");
  const tabs = document.querySelectorAll(".nav-link");
  const carContent = document.getElementById("carContent");
  const carInfoButtons = document.querySelectorAll(".car-info-btn");
  const closeInfoBtn = document.getElementById('closeInfoBtn');

  document.querySelectorAll('.toggle-btn').forEach(button => {
    button.addEventListener('click', function () {
      const targetId = this.getAttribute('data-bs-target');
      const targetElement = document.querySelector(targetId);
  
      // Listen for Bootstrap events to toggle button text
      targetElement.addEventListener('shown.bs.collapse', () => {
        button.textContent = 'Leer menos';
        button.style.backgroundColor = 'red';
      });
  
      targetElement.addEventListener('hidden.bs.collapse', () => {
        button.textContent = 'Leer más';
        button.style.backgroundColor = '#0D6EFD';
      });
    });
  });
  
  const carInfo = {
    GT2: {
      title: "Porsche GT2 RS",
      history:
        "El Porsche GT2 RS es conocido como el 911 más potente y rápido de la historia. Lanzado en 2017, este superdeportivo combina una potencia brutal de 700 CV con un peso ligero, lo que lo convierte en una máquina de circuito formidable. Su motor bóxer de seis cilindros biturbo de 3.8 litros le permite acelerar de 0 a 100 km/h en solo 2.8 segundos, alcanzando una velocidad máxima de 340 km/h.",
    },
    GT3: {
      title: "Porsche GT3 RS",
      history:
        "El Porsche GT3 RS representa la cúspide de la ingeniería de Porsche para uso en circuito. Con su motor atmosférico de alta revolución, chasis afinado para la pista y aerodinámica agresiva, el GT3 RS es la elección preferida de los puristas. La última generación, presentada en 2022, cuenta con 518 CV y una serie de innovaciones aerodinámicas, incluyendo un enorme alerón trasero ajustable y un sistema DRS (Drag Reduction System) inspirado en la Fórmula 1.",
    },
    918: {
      title: "Porsche 918 Spyder",
      history:
        "El Porsche 918 Spyder fue un hito en la historia de los superdeportivos híbridos. Producido entre 2013 y 2015, este vehículo combinaba un motor V8 de 4.6 litros con dos motores eléctricos, generando una potencia total de 887 CV. Capaz de alcanzar los 100 km/h en 2.6 segundos y con una velocidad máxima de 345 km/h, el 918 Spyder demostró que la tecnología híbrida podía ofrecer un rendimiento extraordinario sin comprometer la eficiencia.",
    },
  };

  carInfoButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const carKey = this.getAttribute("data-car");
      const car = carInfo[carKey];
      closeInfoBtn.style.display = "flex";

      if (car) {
        carContent.innerHTML = `
          <h3>${car.title}</h3>
          <p>${car.history}</p>
        `;
      }
    });
  });

  closeInfoBtn.addEventListener("click", function () {
    // Reset the content to the original message
    carContent.innerHTML = `<h3>Seleccione un modelo para ver detalles</h3>`;

    // Hide the close button again
    closeInfoBtn.style.display = "none";
  });

  tabs.forEach((tab) => {
    tab.addEventListener("show.bs.tab", function (event) {
      switch (event.target.id) {
        case "pills-home-tab":
          section.style.backgroundImage = 'url("./img/displayGarage.jpg")';
          break;
        case "pills-gt2-tab":
          section.style.backgroundImage = 'url("./img/GT2RS.jpg")';
          break;
        case "pills-gt3-tab":
          section.style.backgroundImage = 'url("./img/GT3RS.webp")';
          break;
        case "pills-918-tab":
          section.style.backgroundImage = 'url("./img/918.jpg")';
          break;
      }
    });
  });

  const carSelect = document.getElementById("carSelect");
  const carouselImages = document.getElementById("carousel-images");

  carSelect.addEventListener("change", function () {
    const selectedCar = carSelect.value;

    carouselImages.innerHTML = "";

    let imgSrc = "";
    if (selectedCar === "GT2RS") {
      imgSrc = "./img/GT2RS.jpg";
    } else if (selectedCar === "GT3RS") {
      imgSrc = "./img/GT3RS.webp";
    } else if (selectedCar === "918") {
      imgSrc = "./img/918.jpg";
    } else {
      imgSrc = "./img/displayGarage.jpg";
    }

    const newCarouselItem = document.createElement("div");
    newCarouselItem.classList.add("carousel-item", "active");
    newCarouselItem.innerHTML = `<img src="${imgSrc}" class="d-block w-100" alt="${selectedCar}">`;
    carouselImages.appendChild(newCarouselItem);
  });
});
