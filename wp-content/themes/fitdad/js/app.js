window.onscroll = function () { topMenuClasses() };
window.onload = function () { 
    if (document.getElementById("hpLogo") == null) { 
        topMenuLight(); 
    }

    wpfWpColumnsToBsRow();
    wpfWpColumnToBsColumn();
};

var topNavigation = document.getElementById("topNavigation");
var brandLink = document.getElementById("brandLink");

function topMenuLight() {
    // Show the brand link
    brandLink.classList.add("brandlink-show");

    // Make the navigation bar light
    topNavigation.classList.remove("bg-dark");
    topNavigation.classList.remove("navbar-dark");
    topNavigation.classList.add("bg-light");
    topNavigation.classList.add("navbar-light");
}

function topMenuDark() {
    // Hide the brand link
    brandLink.classList.remove("brandlink-show");

    // Make the navigation bar dark
    topNavigation.classList.add("bg-dark");
    topNavigation.classList.add("navbar-dark");
    topNavigation.classList.remove("bg-light");
    topNavigation.classList.remove("navbar-light");
}

function topMenuClasses() {
    if (document.getElementById("hpLogo") != null) {
        if (window.pageYOffset > (hpLogo.offsetTop + hpLogo.offsetHeight) - topNavigation.offsetHeight) {
            topMenuLight();
        }
        else {
            topMenuDark();
        }
    }
}

function wpfWpColumnsToBsRow() {
    var elements = document.getElementsByClassName("wpf-wpcols-bsrow");

    for (var counter = 0; counter < elements.length; counter++) {
        elements[counter].classList.remove("wp-block-columns");
        elements[counter].classList.add("row");
    }
}

function wpfWpColumnToBsColumn() {
    var elements = document.getElementsByClassName("wpf-wpcol-bscol");

    for (var counter = 0; counter < elements.length; counter++) {
        elements[counter].classList.remove("wp-block-column");
        elements[counter].style.removeProperty("flex-basis");
    }
}