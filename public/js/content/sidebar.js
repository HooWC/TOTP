// Selecting the sidebar and buttons
const sidebar = document.querySelector(".sidebar");
const sidebarOpenBtn = document.querySelector("#sidebar-open");
const sidebarCloseBtn = document.querySelector("#sidebar-close");
const sidebarLockBtn = document.querySelector("#lock-icon");

// Function to toggle the lock state of the sidebar
const toggleLock = () => {
    sidebar.classList.toggle("locked");
    // If the sidebar is not locked
    if (!sidebar.classList.contains("locked")) {
        sidebar.classList.add("hoverable");
        sidebarLockBtn.classList.replace("bx-lock-alt", "bx-lock-open-alt");
    } else {
        navbar.style.maxWidth = '72%';
        navbar.style.position = 'fixed';
        navbar.style.top = '0';
        navbar.style.left = '57%';
        navbar.style.transform = 'translateX(-50%)';
        sidebar.classList.remove("hoverable");
        sidebarLockBtn.classList.replace("bx-lock-open-alt", "bx-lock-alt");
    }
};

// Function to hide the sidebar when the mouse leaves
const hideSidebar = () => {
    if (sidebar.classList.contains("hoverable")) {
        sidebar.classList.add("close");
    }
};

// Function to show the sidebar when the mouse enter
const showSidebar = () => {
    if (sidebar.classList.contains("hoverable")) {
        sidebar.classList.remove("close");
    }
};

// Function to show and hide the sidebar
const toggleSidebar = () => {
    sidebar.classList.toggle("close");
};

// If the window width is less than 800px, close the sidebar and remove hoverability and lock
if (window.innerWidth < 800) {
    sidebar.classList.add("close");
    sidebar.classList.remove("locked");
    sidebar.classList.remove("hoverable");
}

const navbar = document.querySelector('.navbar');
var sidebarProfile = document.querySelector('.sidebar_profile');
sidebarLockBtn.addEventListener("click", toggleLock);
sidebar.addEventListener("mouseleave", function(){
    // width 100%
    if (!sidebar.classList.contains("locked")){
        navbar.style.maxWidth = '80%';
        navbar.style.removeProperty('position');
        navbar.style.removeProperty('top');
        navbar.style.removeProperty('left');
        navbar.style.transform = 'translateX(-57%)';
        sidebarProfile.style.display = 'none';
    }
    hideSidebar();
});
sidebar.addEventListener("mouseenter", function(){
    // wid 60%
    navbar.style.maxWidth = '72%';
    navbar.style.position = 'fixed';
    navbar.style.top = '0';
    navbar.style.left = '57%';
    navbar.style.transform = 'translateX(-50%)';
    sidebarProfile.style.display = 'block';
    showSidebar();
});
//sidebarOpenBtn.addEventListener("click", toggleSidebar);
sidebarCloseBtn.addEventListener("click", toggleSidebar);
