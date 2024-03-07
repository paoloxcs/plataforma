var swiper = new Swiper(".slide-content", {
    slidesPerView: 1,
    spaceBetween: 0,
    loop: true,
    centerSlide: 'true',
    fade: 'true',
    grabCursor: 'true',
    pagination: {
      el: ".swiper-pagination-autor",
      clickable: true,
      dynamicBullets: true,
    },
    navigation: {
      nextEl: ".swiper-btn-next",
      prevEl: ".swiper-btn-prev",
    },
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,
    },
    breakpoints:{
        0: {
            slidesPerView: 1,
              spaceBetween: 20,
        },
        520: {
            slidesPerView: 2,
              spaceBetween: 20,
        },
        950: {
            slidesPerView: 3,
              spaceBetween: 20,
        },
        1200 :{
          slidesPerView: 4,
              spaceBetween: 20,
        },
    },
  });

  var swiper_colaborador = new Swiper(".slide-content-colaborador", {
    slidesPerView: 1,
    spaceBetween: 0,
    loop: true,
    centerSlide: 'true',
    fade: 'true',
    grabCursor: 'true',
    // pagination: {
    //   el: ".swiper-pagination-colaborador",
    //   clickable: true,
    //   dynamicBullets: true,
    // },
    // navigation: {
    //   nextEl: ".swiper-button-next",
    //   prevEl: ".swiper-button-prev",
    // },
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,
    },
    breakpoints:{
      0: {
        slidesPerView: 1,
        spaceBetween: 0 ,
      },
      640: {
        slidesPerView: 2,
        spaceBetween: 8,
      },
      768: {
          slidesPerView: 2,
          spaceBetween: 8,
      },
      1024: {
          slidesPerView: 3,
          spaceBetween: 16,
      },
      1280: {
          slidesPerView: 4,
          spaceBetween: 16,
      },
    },
  });

  
  var swiper_empresa = new Swiper(".slide-content-empresa", {
    slidesPerView: 1,
    spaceBetween: 0,
    loop: true,
    centerSlide: 'true',
    fade: 'true',
    grabCursor: 'true',
    // pagination: {
    //   el: ".swiper-pagination-empresa",
    //   clickable: true,
    //   dynamicBullets: true,
    // },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,
    },
    breakpoints:{
      0: {
        slidesPerView: 1,
        spaceBetween: 0 ,
      },
      640: {
        slidesPerView: 2,
        spaceBetween: 8,
      },
      768: {
          slidesPerView: 2,
          spaceBetween: 8,
      },
      1024: {
          slidesPerView: 3,
          spaceBetween: 16,
      },
      1280: {
          slidesPerView: 4,
          spaceBetween: 16,
      },
    },
  });

    var swiper_sector_colaborador = new Swiper(".slide-content-sector_colab", {
      slidesPerView: 4,
      spaceBetween: 25,
      loop: true,
      centerSlide: 'true',
      fade: 'true',
      grabCursor: 'true',
      // pagination: {
      //   el: ".swiper-pagination-sector_colab",
      //   clickable: true,
      //   dynamicBullets: true,
      // },
      navigation: {
        nextEl: ".swiper-btn_sectcolab-next",
        prevEl: ".swiper-btn_sectcolab-prev",
      },
      // autoplay: {
      //   delay: 2500,
      //   disableOnInteraction: false,
      // },
      breakpoints:{
          0: {
              slidesPerView: 2,
          },
          520: {
              slidesPerView: 2,
          },
          950: {
              slidesPerView: 3,
          },
          1200 :{
            slidesPerView: 4,
          },
      },
    });
  
    var swiper_curso_rubro = new Swiper(".slide-content-curso_rubro", {
      slidesPerView: 1,
      spaceBetween: 0,
      loop: true, 
      centerSlide: 'true',
      fade: 'true',
      grabCursor: 'true',
      // pagination: {
      //   el: ".swiper-pagination-colaborador",
      //   clickable: true,
      //   dynamicBullets: true,
      // },
      navigation: {
        nextEl: ".swiper-btn_cursosrubro-next",
        prevEl: ".swiper-btn_cursosrubro-prev",
      },
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
      breakpoints:{
        0: {
          slidesPerView: 1,
          spaceBetween: 0 ,
        },
        640: {
          slidesPerView: 2,
          spaceBetween: 8,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 8,
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 16,
        },
        1280: {
            slidesPerView: 4,
            spaceBetween: 32,
        },
      },
    }); 

    //RUBROS 
    var swiper_arquitectura_y_diseno = new Swiper(".slide-content-arquitectura-y-diseno", {
      slidesPerView: 1,
      spaceBetween: 0, 
      grabCursor: 'true',
      // pagination: {
      //   el: ".swiper-pagination-colaborador",
      //   clickable: true,
      //   dynamicBullets: true,
      // },
      navigation: {
        nextEl: ".swiper-btn-next",
        prevEl: ".swiper-btn-prev",
      },
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
      breakpoints:{
        0: {
          slidesPerView: 1,
          spaceBetween: 0 ,
        },
        640: {
          slidesPerView: 2,
          spaceBetween: 8,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 8,
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 16,
        },
        1280: {
            slidesPerView: 4,
            spaceBetween: 32,
        },
      },
    }); 

    var swiper_construccion = new Swiper(".slide-content-construccion", {
        slidesPerView: 1,
        spaceBetween: 0, 
        grabCursor: 'true',
        // pagination: {
        //   el: ".swiper-pagination-colaborador",
        //   clickable: true,
        //   dynamicBullets: true,
        // },
        navigation: {
          nextEl: ".swiper-btn-next",
          prevEl: ".swiper-btn-prev",
        },
        autoplay: {
          delay: 2500,
          disableOnInteraction: false,
        },
        breakpoints:{
          0: {
            slidesPerView: 1,
            spaceBetween: 0 ,
          },
          640: {
            slidesPerView: 2,
            spaceBetween: 8,
          },
          768: {
              slidesPerView: 3,
              spaceBetween: 8,
          },
          1024: {
              slidesPerView: 3,
              spaceBetween: 16,
          },
          1280: {
              slidesPerView: 4,
              spaceBetween: 32,
          },
        },
    });

    var swiper_mineria = new Swiper(".slide-content-mineria", {
        slidesPerView: 1,
        spaceBetween: 0, 
        grabCursor: 'true',
        // pagination: {
        //   el: ".swiper-pagination-colaborador",
        //   clickable: true,
        //   dynamicBullets: true,
        // },
        navigation: {
          nextEl: ".swiper-btn-next",
          prevEl: ".swiper-btn-prev",
        },
        autoplay: {
          delay: 2500,
          disableOnInteraction: false,
        },
        breakpoints:{
          0: {
            slidesPerView: 1,
            spaceBetween: 0 ,
          },
          640: {
            slidesPerView: 2,
            spaceBetween: 8,
          },
          768: {
              slidesPerView: 3,
              spaceBetween: 8,
          },
          1024: {
              slidesPerView: 3,
              spaceBetween: 16,
          },
          1280: {
              slidesPerView: 4,
              spaceBetween: 32,
          },
        },
    });  
    //RUBROS 
     
    var swiper_rubro = new Swiper(".slide-content-rubro", {
      slidesPerView: 1,
      spaceBetween: 0, 
      // pagination: {
      //   el: ".swiper-pagination-colaborador",
      //   clickable: true,
      //   dynamicBullets: true,
      // },
      navigation: {
        nextEl: ".swiper-btn_rubro-next",
        prevEl: ".swiper-btn_rubro-prev",
      },
      // autoplay: {
      //   delay: 2500,
      //   disableOnInteraction: false,
      // },
      breakpoints:{
        0: {
          slidesPerView: 1,
          spaceBetween: 0 ,
        },
        640: {
          slidesPerView: 2,
          spaceBetween: 8,
        },
        768: {
            slidesPerView: 2,
            spaceBetween: 8,
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 32,
        },
        1280: {
            slidesPerView: 4,
            spaceBetween: 32,
        },
      },
    }); 


    var swiper_benef = new Swiper(".slide-content-benef", { 
      slidesPerView: 1,
      spaceBetween: 0,
      loop: true,
      centerSlide: 'true',
      fade: 'true',
      grabCursor: 'true',
      pagination: {
        el: ".swiper-pagination-benef",
        clickable: true,
        dynamicBullets: true,
      },
      // navigation: {
      //   nextEl: ".swiper-btn-next",
      //   prevEl: ".swiper-btn-prev",
      // },
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      }, 
    });
  
    
    var swiper_contenido = new Swiper(".slide-content-contenido", {
      slidesPerView: 1,
      spaceBetween: 0,
      loop: false,
      centerSlide: 'true',
      fade: 'true',
      grabCursor: 'true',
      // pagination: {
      //   el: ".swiper-pagination-autor",
      //   clickable: true,
      //   dynamicBullets: true,
      // },
      navigation: {
        nextEl: ".swiper-btn-next",
        prevEl: ".swiper-btn-prev",
      },
      // autoplay: {
      //   delay: 2500,
      //   disableOnInteraction: false,
      // },
      breakpoints:{
          0: {
              slidesPerView: 1,
              spaceBetween: 10,
          },
          520: {
              slidesPerView: 2,
              spaceBetween: 20,
          },
          950: {
              slidesPerView: 3,
              spaceBetween: 20,
          },
          1200 :{
            slidesPerView: 4,
              spaceBetween: 20,
          },
      },
    });