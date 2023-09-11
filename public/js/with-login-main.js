var swiper = new Swiper(".popular-content", {
    slidesPreView:1,
    spaceBetween: 10,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        280: {
            slidesPerView: 1,
            spaceBetween: 10,
        },
        320: {
            slidesPerView:2,
            spaceBetween:10,
        },
        510: {
          slidesPerView: 2,
          spaceBetween: 10,
        },
        758: {
          slidesPerView: 3,
          spaceBetween: 15,
        },
        900: {
          slidesPerView: 4,
          spaceBetween: 20,
        },
      },
});

var swiper = new Swiper(".home-content", {
    slidesPreView:1,
    spaceBetween: 10,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".home-swiper",
        clickable: true,
    },
    // breakpoints: {
    //     280: {
    //         slidesPerView: 1,
    //         spaceBetween: 10,
    //     },
    //     320: {
    //         slidesPerView:2,
    //         spaceBetween:10,
    //     },
    //     510: {
    //       slidesPerView: 2,
    //       spaceBetween: 10,
    //     },
    //     758: {
    //       slidesPerView: 3,
    //       spaceBetween: 15,
    //     },
    //     900: {
    //       slidesPerView: 4,
    //       spaceBetween: 20,
    //     },
    //   },
});
