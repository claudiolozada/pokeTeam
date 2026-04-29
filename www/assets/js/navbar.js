const openUserMenu = document.getElementById("openUserMenu");
const closeUserMenu = document.getElementById("closeUserMenu");
const userSideMenu = document.getElementById("userSideMenu");
const overlayMenu = document.getElementById("overlayMenu");

openUserMenu.addEventListener("click", () => {
    userSideMenu.classList.add("active");
    overlayMenu.classList.add("active");
});

closeUserMenu.addEventListener("click", () => {
    userSideMenu.classList.remove("active");
    overlayMenu.classList.remove("active");
});

overlayMenu.addEventListener("click", () => {
    userSideMenu.classList.remove("active");
    overlayMenu.classList.remove("active");
});