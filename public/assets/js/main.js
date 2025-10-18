/*!

=========================================================
* Argon Dashboard Tailwind - v1.0.1
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard-tailwind
* Copyright 2022 Creative Tim (https://www.creative-tim.com)

* Coded by www.creative-tim.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

*/ var page = window.location.pathname
        .split("/")
        .pop()
        .split(".")[0],
    aux = window.location.pathname.split("/"),
    to_build = aux.includes("pages") || aux.includes("docs") ? "../" : "./",
    root = window.location.pathname.split("/");
function loadJS(b, c) {
    let a = document.createElement("script");
    a.setAttribute("src", b), a.setAttribute("type", "text/javascript"), a.setAttribute("async", c), document.head.appendChild(a);
}
function loadStylesheet(b) {
    let a = document.createElement("link");
    a.setAttribute("href", b), a.setAttribute("type", "text/css"), a.setAttribute("rel", "stylesheet"), document.head.appendChild(a);
}
aux.includes("pages") || (page = "dashboard"),
    loadStylesheet("/assets/css/perfect-scrollbar.css"),
    loadJS("/assets/js/perfect-scrollbar.js", !0),
    document.querySelector("[slider]") && loadJS("/assets/js/carousel.js", !0),
    document.querySelector("nav [navbar-trigger]") && loadJS("/assets/js/navbar-collapse.js", !0),
    document.querySelector("[data-target='tooltip']") && (loadJS("/assets/js/tooltips.js", !0), loadStylesheet("/assets/css/tooltips.css")),
    document.querySelector("[nav-pills]") && loadJS("/assets/js/nav-pills.js", !0),
    document.querySelector("[dropdown-trigger]") && loadJS("/assets/js/dropdown.js", !0),
    document.querySelector("[fixed-plugin]") && loadJS("/assets/js/fixed-plugin.js", !0),
    (document.querySelector("[navbar-main]") || document.querySelector("[navbar-profile]")) &&
        (document.querySelector("[navbar-main]") && loadJS("/assets/js/navbar-sticky.js", !0), document.querySelector("aside") && loadJS("/assets/js/sidenav-burger.js", !0)),
    document.querySelector("canvas") && loadJS("/assets/js/charts.js", !0),
    document.querySelector(".github-button") && loadJS("https://buttons.github.io/buttons.js", !0);

