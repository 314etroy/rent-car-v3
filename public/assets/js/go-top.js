/*----------------------------- Scroll Up Button --------------------- */
if (typeof initBacktoTop !== "function") {
  const initBacktoTop = () => {
    const mybutton = document.querySelector('[data-toggle="back-to-top"]');

    window.addEventListener("scroll", function () {
      if (window.scrollY > 300) {
        mybutton.classList.add("flex");
        mybutton.classList.remove("hidden");
      } else {
        mybutton.classList.remove("flex");
        mybutton.classList.add("hidden");
      }
    });

    if (mybutton) {
      mybutton.addEventListener("click", function (e) {
        e.preventDefault();
        window.scrollTo({
          top: 0,
          behavior: "smooth",
        });
      });
    }
  };

  initBacktoTop();
}

const goTop = () =>
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
