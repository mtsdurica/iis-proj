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
    //var StatisticsElementGroup = document.getElementById('group-statistics');
    var MembersElementGroup = document.getElementById('group-members');
    var RequestsElementGroup = document.getElementById('group-requests');

    ThreadsElementGroup.classList.add('hidden');
    AboutElementGroup.classList.add('hidden');
    //StatisticsElementGroup.classList.add('hidden');
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

// function showGroupStatistics() {
//     hideAllElementsGroup();
//     var StatisticsElementGroup = document.getElementById('group-statistics');
//     StatisticsElementGroup.classList.remove('hidden');
// }

function showGroupRequests() {
    hideAllElementsGroup();
    var RequestsElementGroup = document.getElementById('group-requests');
    RequestsElementGroup.classList.remove('hidden');
}

const GroupThreadsButton = document.getElementById('show-group-threads');
GroupThreadsButton.addEventListener('click', showGroupThreads);

const GroupAboutButton = document.getElementById('show-group-about');
GroupAboutButton.addEventListener('click', showGroupAbout);

// const GroupStatisticsButton = document.getElementById('show-group-statistics');
// GroupStatisticsButton.addEventListener('click', showGroupStatistics);

const GroupMembersButton = document.getElementById('show-group-members');
GroupMembersButton.addEventListener('click', showGroupMembers);

const GroupRequestsButton = document.getElementById('show-group-requests');
GroupRequestsButton.addEventListener('click', showGroupRequests);