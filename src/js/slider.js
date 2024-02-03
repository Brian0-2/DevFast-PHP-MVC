import Swiper, { Navigation } from "swiper";
import "swiper/css";
import "swiper/css/navigation";
(function () {

document.addEventListener("DOMContentLoaded", function () {
  const sliders = document.querySelectorAll(".swiper");

  sliders.forEach((slider) => {
    const opciones = {
      slidesPerView: 1,
      freeMode: true,
      navigation: {
        nextEl: slider.querySelector(".swiper-button-next"),
        prevEl: slider.querySelector(".swiper-button-prev"),
      },
      pagination: {
        el: slider.querySelector(".swiper-pagination"), // Elemento HTML para la paginación
        type: "progressbar", // Puedes usar 'bullets', 'fraction', 'progressbar', etc.
        clickable: true,
      },
      on: {
        init: function () {
          updateSliderCount(this);
        },
        slideChange: function () {
          updateSliderCount(this);
        },
      },
      breakpoints: {
        768: {
          slidesPerView: 2,
          spaceBetween: 10,
        },
        1024: {
          slidesPerView: 3,
          spaceBetween: 15,
        },
        1200: {
          slidesPerView: 4,
          spaceBetween: 20,
        },
      },
    };

    function updateSliderCount(swiper) {
      const totalSlides = swiper.slides.length;
      const activeIndex = swiper.activeIndex + 1;
      const sliderCountElement = slider.querySelector(".slider-count");
      if (sliderCountElement) {
        sliderCountElement.textContent = `${activeIndex} / ${totalSlides}`;
      }
    }

    Swiper.use([Navigation]);
    new Swiper(slider, opciones);
  });
});
})();