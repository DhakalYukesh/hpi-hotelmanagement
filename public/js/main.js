let ham = document.querySelector(".ham"),
    nav = document.querySelector(".navbar");

ham.addEventListener("click", () => {
    nav.classList.add("responsiveNav");
});

// Defining variables for form close action.
// let formSignin = document.querySelector(".signin-form-container");

// Defining variables for responsive navigation.
let menu = document.querySelector("#menuBar");
let navbar = document.querySelector(".navbar");

// Defining variable for images switch.
let imgBtn = document.querySelectorAll(".image-btn");

window.onscroll = () => {
    menu.classList.remove("fa-times");
    navbar.classList.remove("active");
    formSignin.classList.remove("active");
};

// Defining setInterval() method to trigger the click event on each button every 7 seconds.
let i = 0;
let intervalId = setInterval(() => {
    imgBtn[i].click();
    i++;
    if (i >= imgBtn.length) {
        i = 0;
    }
}, 7000);

imgBtn.forEach((btn) => {
    btn.addEventListener("click", () => {
        document.querySelector(".navigator .active").classList.remove("active");
        btn.classList.add("active");
        let src = btn.getAttribute("data-src");
        document.querySelector("#image-slider").src = src;

        clearInterval(intervalId);
        intervalId = setInterval(() => {
            imgBtn[i].click();
            i++;
            if (i >= imgBtn.length) {
                i = 0;
            }
        }, 7000);
    });
});

menu.addEventListener("click", () => {
    menu.classList.toggle("fa-times");
    navbar.classList.toggle("active");
});