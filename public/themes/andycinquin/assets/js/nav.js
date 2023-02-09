var navblock = document.getElementById("nav-block");
var btnNav = document.getElementById("btnNav");
var navRight = document.getElementById("nav-right");

btnNav.addEventListener('click', ()=>{
    swapNav();
})

navRight.addEventListener("click", () => {
    btnNav.click();
});

function swapNav() {
    if (!navblock.classList.contains("z-40")) {
        navblock.classList.add("z-40", "opacity-100", "pointer-events-auto", "-translate-y-[0vh]");
        navblock.classList.remove("-z-10", "opacity-0", "pointer-events-none", "-translate-y-[100vh]");
    } else {
        navblock.classList.remove("z-40", "opacity-100", "pointer-events-auto", "-translate-y-[0vh]");
        navblock.classList.add("-z-10", "opacity-0", "pointer-events-none", "-translate-y-[100vh]");
    }
}

document.querySelectorAll('.button-animated').forEach(button => button.innerHTML = '<div><span>' + button.textContent.trim().split('').join('</span><span>') + '</span></div>');
