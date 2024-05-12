/*=============== SWIPER CATEGORIES ===============*/
var swiperCategories = new Swiper(".categories__container", {
  spaceBetween: 24,
  loop: true,

  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },

  breakpoints: {
    320: {
      slidesPerView: 3,
      spaceBetween: 16,
    },
    768: {
      slidesPerView: 5,
      spaceBetween: 18,
    },
    1400: {
      slidesPerView: 6,
      spaceBetween: 24,
    },
  },
});

/*=============== PRODUCTS TABS ===============*/
const tabs = document.querySelectorAll("[data-target]");
const tabContents = document.querySelectorAll("[content]");

tabs.forEach((tab) => {
  tab.addEventListener("click", () => {
    const target = document.querySelector(tab.dataset.target);
    tabContents.forEach((tabContent) => {
      tabContent.classList.remove("active-tab");
    });
    target.classList.add("active-tab");
    tabs.forEach((tab) => {
      tab.classList.remove("active-tab"); // Menghapus kelas active-tab dari semua tab
    });
    tab.classList.add("active-tab"); // Menambahkan kelas active-tab ke tab yang diklik

    // Menambahkan kode untuk mengubah warna tombol saat diklik
    tabs.forEach((tab) => {
      tab.classList.remove("active-button"); // Menghapus kelas active-button dari semua tab
    });
    tab.classList.add("active-button"); // Menambahkan kelas active-button ke tab yang diklik
  });
});

$(document).ready(function () {
  $(".pagination__link").click(function () {
    $(".pagination__link").removeClass("active");
    $(this).addClass("active");
    var target = $(this).data("target");
    // Lakukan sesuatu dengan target, misalnya tampilkan konten yang sesuai dengan target
    console.log("Tautan dengan target " + target + " diklik.");
  });
});
