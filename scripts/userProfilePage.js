
showUserThreads();

function hideAllElements() {
    var ThreadsElement = document.getElementById('user-threads');
    var AboutElement = document.getElementById('user-about');
    var StatisticsElement = document.getElementById('user-statistics');
    var GroupsElement = document.getElementById('user-groups');

    ThreadsElement.classList.add('hidden');
    AboutElement.classList.add('hidden');
    StatisticsElement.classList.add('hidden');
    GroupsElement.classList.add("hidden")
}

function showUserThreads() {
    hideAllElements();
    var ThreadsElement = document.getElementById('user-threads');
    ThreadsElement.classList.remove('hidden');
}

function showUserGroups() {
    hideAllElements();
    var GroupsElement = document.getElementById('user-groups');
    GroupsElement.classList.remove('hidden');
}

function showUserAbout() {
    hideAllElements();
    var AboutElement = document.getElementById('user-about');
    AboutElement.classList.remove('hidden');
}

function showUserStatistics() {
    hideAllElements();
    var StatisticsElement = document.getElementById('user-statistics');
    StatisticsElement.classList.remove('hidden');
}

const UserThreadsButton = document.getElementById('show-user-threads');
UserThreadsButton.addEventListener('click', showUserThreads);

const UserAboutButton = document.getElementById('show-user-about');
UserAboutButton.addEventListener('click', showUserAbout);

const UserStatisticsButton = document.getElementById('show-user-statistics');
UserStatisticsButton.addEventListener('click', showUserStatistics);

const UserGroupsButton = document.getElementById('show-user-groups');
UserGroupsButton.addEventListener('click', showUserGroups);

showUserThreads();



document.addEventListener('DOMContentLoaded', function () {
    var profilePhotoElement = document.getElementById('profile-photo-element');
    var coverPhotoElement = document.getElementById('cover-photo-element');


    if (profilePhotoElement) {
        profilePhotoElement.addEventListener('click', function (event) {
            toggleMenuVisibility('change-profile-photo', 'change-cover-photo');
            event.stopPropagation();
        });
    }

    if (coverPhotoElement) {
        coverPhotoElement.addEventListener('click', function (event) {
            toggleMenuVisibility('change-cover-photo', 'change-profile-photo');
            event.stopPropagation();
        });
    }

    document.addEventListener('click', function () {
        closeMenu('change-profile-photo');
        closeMenu('change-cover-photo');
    });

    document.querySelector('.change-profile-photo').addEventListener('click', function (event) {
        changeProfilePhoto();
        event.stopPropagation();
    });

    document.querySelector('.delete-profile-photo').addEventListener('click', function (event) {
        deleteProfilePhoto();
        event.stopPropagation();
    });

    document.querySelector('.change-cover-photo').addEventListener('click', function (event) {
        changeCoverPhoto();
        event.stopPropagation();
    });

    document.querySelector('.delete-cover-photo').addEventListener('click', function (event) {
        deleteCoverPhoto();
        event.stopPropagation();
    });
});

function toggleMenuVisibility(showMenuId, hideMenuId) {
    var menuToShow = document.getElementById(showMenuId);
    var menuToHide = document.getElementById(hideMenuId);
    if (menuToShow) menuToShow.classList.toggle('hidden');
    if (menuToHide && !menuToHide.classList.contains('hidden')) {
        menuToHide.classList.add('hidden');
    }
}

function closeMenu(menuId) {
    var menuToClose = document.getElementById(menuId);
    if (menuToClose && !menuToClose.classList.contains('hidden')) {
        menuToClose.classList.add('hidden');
    }
}

function changeProfilePhoto() {
    var fileInput = document.getElementById('profile-photo-input');
    fileInput.click();

    fileInput.onchange = function (event) {
        var file = event.target.files[0];
        var reader = new FileReader();

        reader.onload = function (e) {
            var profilePhoto = document.getElementById('profile-photo');
            profilePhoto.src = e.target.result;
        };

        reader.readAsDataURL(file);
    };
}

function deleteProfilePhoto() {
    var profilePhoto = document.getElementById('profile-photo');
    profilePhoto.src = '';
}

function changeCoverPhoto() {
    var fileInput = document.getElementById('cover-photo-input');
    fileInput.click();

    fileInput.onchange = function (event) {
        var file = event.target.files[0];
        var reader = new FileReader();

        reader.onload = function (e) {
            var coverPhoto = document.getElementById('cover-photo');
            coverPhoto.src = e.target.result;
        };

        reader.readAsDataURL(file);
    };
}

function deleteCoverPhoto() {
    var coverPhoto = document.getElementById('cover-photo');
    coverPhoto.src = '';
}

