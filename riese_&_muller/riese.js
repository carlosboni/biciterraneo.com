var video = document.getElementById("myVideo");
var btn = document.getElementById("myBtn");

function myFunction() {
  if (video.paused) {
    video.play();
    btn.innerHTML = "&#124;&#32;&#124;";
  } else {
    video.pause();
    btn.innerHTML = "&#187;";
  }
}