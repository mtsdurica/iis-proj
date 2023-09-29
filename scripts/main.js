(function() {
    const darkModeToggle = document.querySelector('.toggle-dark');

    darkModeToggle.addEventListener('click', (event) => {
        event.preventDefault();
        console.log()
        if(localStorage.theme === 'dark')
        {
            localStorage.theme = 'light';
        }
        else {
            localStorage.theme = 'dark';
        }
        document.documentElement.classList.toggle('dark');
    })

    var page = location.pathname.replace(/\/(?<=\/)(.*)\d(?=\/)/,"");
    page = page.replace(/(?!^)\/.*/, "");
    document.getElementById(page).className += "-active";
})();