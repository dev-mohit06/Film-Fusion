// Show Video
let playButton = document.querySelector(".play-movie");
let Video = document.querySelector(".video-container");
let myvideo = document.getElementById("myvideo");
let closeButton = document.querySelector(".close-video");

playButton.addEventListener("click",()=>{
    Video.classList.add("show-video");
    myvideo.play();
});

closeButton.addEventListener("click",()=>{
    Video.classList.remove("show-video");
    myvideo.pause();
})