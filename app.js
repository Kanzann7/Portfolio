/* EVENT PLAY BUTTON*/
let playButton = document.querySelector(".play");

const menu = new Audio();

const menuSong = () => {
  menu.src = "./Musiques/menu.wav";
  menu.play();
};

playButton.addEventListener("click", () => {
  menuSong();
});

/* EVENT PAUSE BUTTON */

let pauseButton = document.querySelector(".pause");
const stopSong = () => {
  menu.pause();
};

pauseButton.addEventListener("click", () => {
  stopSong();
});

/* EVENTS d10 */

let d10 = document.querySelector(".d10");
const songDice = () => {
  const audio = new Audio();
  audio.src = "./Musiques/d10.mp3";
  audio.play();
};
let deg = 0;
let navHidden = true;

d10.addEventListener("click", () => {
  deg += 360;

  d10.style.transform = `rotate(${deg}deg)`;
  if (navHidden === true) {
    navBar.style.width = "100%";
    navBar.style.visibility = "visible";
    navHidden = false;
  } else if (navHidden === false) {
    navBar.style.width = "0%";
    navBar.style.visibility = "hidden";
    navHidden = true;
  }
  songDice();
});

/* NAV BAR POST CLICK */

let navBar = document.querySelector(".nav-bar-postclick");
