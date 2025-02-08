document.addEventListener("DOMContentLoaded", function() {
    const burger = document.querySelector(".burger");
    const menu = document.querySelector(".menu");
    const links = document.querySelectorAll(".menu li");

    burger.addEventListener("click", function() {
        menu.classList.toggle("active");
        burger.classList.toggle("active");

        // Opóźniona animacja linków
        links.forEach((link, index) => {
            if (menu.classList.contains("active")) {
                link.style.animation = `fadeSlide 0.5s ease-out ${index * 0.1}s forwards`;
            } else {
                link.style.animation = "none";
            }
        });
    });

    // Zamknij menu po kliknięciu w link
    links.forEach(link => {
        link.addEventListener("click", () => {
            menu.classList.remove("active");
            burger.classList.remove("active");
        });
    });
});
