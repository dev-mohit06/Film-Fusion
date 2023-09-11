const sliderBar = document.querySelector(".aside")
const btnToggleMain = document.getElementById("menu-btn");
const btnToggleSub = document.getElementById("close-btn");

btnToggleMain.addEventListener('click',()=>{
    sliderBar.classList.add("visibel");
    sliderBar.classList.remove("none");
});
btnToggleSub.addEventListener('click',()=>{
    sliderBar.classList.add("none");
})