(function () {
    const darkModeToggle = document.querySelector('.toggle-dark');
    const profileDropDownToggle = document.querySelector('.toggle-profile-dropdown');

    darkModeToggle.addEventListener('click', (event) => {
        event.preventDefault();
        if (localStorage.theme === 'dark') {
            localStorage.theme = 'light';
        }
        else {
            localStorage.theme = 'dark';
        }
        document.documentElement.classList.toggle('dark');
    })

    profileDropDownToggle.addEventListener('click', (event) => {
        //event.preventDefault();
        var dropDownMenu = document.querySelector('.profile-dropdown');
        dropDownMenu.classList.toggle('animated-hidden');
    })

    window.onclick = function (event) {
        if (!event.target.matches('.toggle-profile-dropdown') && !event.target.matches('.toggle-dark')) {
            var dropdownMenu = document.querySelector('.profile-dropdown');

            if (!dropdownMenu.classList.contains('animated-hidden')) {
                dropdownMenu.classList.add('animated-hidden');
            }
        }
    }

    var page = location.pathname.replace(/\/(?<=\/)(.*)\d(?=\/)/, "");
    page = page.replace(/(?!^)\/.*/, "");
    if (page.match(/.php$/)) {
        page = page.replace(/.php$/, "");
    }
    if (page === "/index") {
        page = "/";
    }
    document.getElementById(page).className += "-active";
})();