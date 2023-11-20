if (/\/group\/.*\/members$/.test(location.pathname)) {
    showGroupMembers();
} else if (/\/group\/.*\/threads$/.test(location.pathname)) {
    showGroupThreads();
} else {
    showGroupThreads();
}

function hideAllElementsGroup() {
    var ThreadsElementGroup = document.getElementById('group-threads');
    var AboutElementGroup = document.getElementById('group-about');
    var StatisticsElementGroup = document.getElementById('group-statistics');
    var MembersElementGroup = document.getElementById('group-members');
    var RequestsElementGroup = document.getElementById('group-requests');

    ThreadsElementGroup.classList.add('hidden');
    AboutElementGroup.classList.add('hidden');
    StatisticsElementGroup.classList.add('hidden');
    MembersElementGroup.classList.add("hidden");
    if (RequestsElementGroup) {
        RequestsElementGroup.classList.add("hidden");
    }
}

function showGroupThreads() {
    hideAllElementsGroup();
    var ThreadsElementGroup = document.getElementById('group-threads');
    ThreadsElementGroup.classList.remove('hidden');
}

function showGroupMembers() {
    hideAllElementsGroup();
    var MembersElementGroup = document.getElementById('group-members');
    MembersElementGroup.classList.remove('hidden');
}

function showGroupAbout() {
    hideAllElementsGroup();
    var AboutElementGroup = document.getElementById('group-about');
    AboutElementGroup.classList.remove('hidden');
}

function showGroupStatistics() {
    hideAllElementsGroup();
    var StatisticsElementGroup = document.getElementById('group-statistics');
    StatisticsElementGroup.classList.remove('hidden');
}

function showGroupRequests() {
    hideAllElementsGroup();
    var RequestsElementGroup = document.getElementById('group-requests');
    RequestsElementGroup.classList.remove('hidden');
}

const GroupThreadsButton = document.getElementById('show-group-threads');
GroupThreadsButton.addEventListener('click', showGroupThreads);

const GroupAboutButton = document.getElementById('show-group-about');
GroupAboutButton.addEventListener('click', showGroupAbout);

const GroupStatisticsButton = document.getElementById('show-group-statistics');
GroupStatisticsButton.addEventListener('click', showGroupStatistics);

const GroupMembersButton = document.getElementById('show-group-members');
GroupMembersButton.addEventListener('click', showGroupMembers);

const GroupRequestsButton = document.getElementById('show-group-requests');
GroupRequestsButton.addEventListener('click', showGroupRequests);

document.addEventListener('DOMContentLoaded', function () {
    var profilePhotoElementGroup = document.getElementById('profile-photo-group');
    var coverPhotoElementGroup = document.getElementById('cover-photo-element-group');
    var changeProfilePhotoGroup = document.getElementById('change-profile-photo-group');
    var changeCoverPhotoGroup = document.getElementById('change-cover-photo-group');

    document.addEventListener('click', function (event) {

        if (profilePhotoElementGroup.contains(event.target)) {
            changeProfilePhotoGroup.classList.toggle('hidden');
            changeCoverPhotoGroup.classList.add('hidden');
        }

        else if (coverPhotoElementGroup.contains(event.target)) {
            changeCoverPhotoGroup.classList.toggle('hidden');
            changeProfilePhotoGroup.classList.add('hidden');
        }

        else {
            changeProfilePhotoGroup.classList.add('hidden');
            changeCoverPhotoGroup.classList.add('hidden');
        }
    });


    document.addEventListener('click', function () {
        closeMenuGroup('change-profile-photo-group');
        closeMenuGroup('change-cover-photo-group');
    });

    document.querySelector('.change-profile-photo-group').addEventListener('click', function (event) {
        changeProfilePhotoGroup();
        event.stopPropagation();
    });

    document.querySelector('.delete-profile-photo-group').addEventListener('click', function (event) {
        deleteProfilePhotoGroup();
        event.stopPropagation();
    });

    document.querySelector('.change-cover-photo-group').addEventListener('click', function (event) {
        changeCoverPhotoGroup();
        event.stopPropagation();
    });

    document.querySelector('.delete-cover-photo-group').addEventListener('click', function (event) {
        deleteCoverPhotoGroup();
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

function changeProfilePhotoGroup() {
    var fileInput = document.getElementById('profile-photo-input-group');
    fileInput.click();

    fileInput.onchange = function (event) {
        var file = event.target.files[0];
        var reader = new FileReader();

        reader.onload = function (e) {
            var profilePhotoGroup = document.getElementById('profile-photo-group');
            profilePhotoGroup.src = e.target.result;
        };

        reader.readAsDataURL(file);
    };
}

function deleteProfilePhotoGroup() {
    var profilePhotoGroup = document.getElementById('profile-photo-group');
    profilePhotoGroup.src = "./images/group_photo.jpg";
}

function changeCoverPhotoGroup() {
    var fileInput = document.getElementById('cover-photo-input-group');
    fileInput.click();

    fileInput.onchange = function (event) {
        var file = event.target.files[0];
        var reader = new FileReader();

        reader.onload = function (e) {
            var coverPhotoGroup = document.getElementById('cover-photo-group');
            coverPhotoGroup.src = e.target.result;
        };

        reader.readAsDataURL(file);
    };
}

function deleteCoverPhotoGroup() {
    var coverPhotoGroup = document.getElementById('cover-photo-group');
    coverPhotoGroup.src = "./images/cover_photo.jpg";
}