if (/\/profile\/.*\/groups$/.test(location.pathname)) {
    showUserGroups();
} else {
    showUserThreads();
}

function hideAllElements() {
    var ThreadsElement = document.getElementById('user-threads');
    var AboutElement = document.getElementById('user-about');
    var GroupsElement = document.getElementById('user-groups');

    ThreadsElement.classList.add('hidden');
    AboutElement.classList.add('hidden');
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

const UserThreadsButton = document.getElementById('show-user-threads');
UserThreadsButton.addEventListener('click', showUserThreads);

const UserAboutButton = document.getElementById('show-user-about');
UserAboutButton.addEventListener('click', showUserAbout);

const UserGroupsButton = document.getElementById('show-user-groups');
UserGroupsButton.addEventListener('click', showUserGroups);