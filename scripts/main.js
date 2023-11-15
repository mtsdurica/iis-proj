(function () {
    const darkModeToggle = document.querySelector('.toggle-dark');
    const profileDropDownToggle = document.querySelector('.toggle-profile-dropdown');
    const showMoreToggle = document.querySelectorAll('.thread-text');
    const browseButton = document.querySelector('.browser-button');


    darkModeToggle.addEventListener('click', (event) => {
        event.preventDefault();
        if (localStorage.theme === 'dark') {
            localStorage.theme = 'light';
        }
        else {
            localStorage.theme = 'dark';
        }
        document.documentElement.classList.toggle('dark');
    });

    profileDropDownToggle.addEventListener('click', (event) => {
        event.preventDefault();
        var dropDownMenu = document.querySelector('.profile-dropdown');
        dropDownMenu.classList.toggle('animated-invisible');
    });

    showMoreToggle.forEach(function (item) {
        item.addEventListener('mouseover', (event) => {
            event.preventDefault();
            var showMoreElement = document.querySelector('#show-more-' + item.id);
            showMoreElement.classList.toggle('animated-invisible');
        });

        item.addEventListener('mouseout', (event) => {
            event.preventDefault();
            var showMoreElement = document.querySelector('#show-more-' + item.id);
            showMoreElement.classList.toggle('animated-invisible');
        });
    });


    window.onclick = (event) => {
        if (!event.target.matches('.toggle-profile-dropdown') && !event.target.matches('.toggle-dark')) {
            var dropdownMenu = document.querySelector('.profile-dropdown');

            if (!dropdownMenu.classList.contains('animated-invisible')) {
                dropdownMenu.classList.add('animated-invisible');
            }
        }
    };


    browseButton.addEventListener('click', () => {
        if (getPage() !== "/browse") {
            $('#\\/browse').toggleClass('header-element-active');
        }
        $('#hiddenButtonBrowseGroups').toggle("swing");
        $('#hiddenButtonBrowseUsers').toggle("swing");
        $('#hiddenDivider').toggle("swing");
    });

    // TODO: Rewrite to jQuery
    function getPage() {
        var page = location.pathname.replace(/\/(?<=\/)(.*)\d(?=\/)/, "");
        page = page.replace(/(?!^)\/.*/, "");
        if (page.match(/.php$/)) {
            page = page.replace(/.php$/, "");
        }
        if (page === "/index") {
            page = "/";
        }

        return page
    }

    document.getElementById(getPage()).className += "-active";
})();

// Admin Dashboard tabs animation
// Modified version of: https://www.w3schools.com/w3css/tryit.asp?filename=tryw3css_tabulators_animate
function openLink(evt, animName) {
    var i, x, tablinks;
    x = document.getElementsByClassName("city");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < x.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" bg-slate-200", "");
    }
    document.getElementById(animName).style.display = "block";
    evt.currentTarget.className += " bg-slate-200";
}
