/* ALERTE */

alert("Veuillez activer le son pour plus d'immersion");

/* SET INTERVAL */
let intervalD10 = true;
const animateZoom = () => {
  divD10.style.transform = intervalD10 ? "scale(1.2)" : "scale(1)";
  intervalD10 = !intervalD10;
};
let animationZoom = setInterval(animateZoom, 500);

/* EVENT PLAY BUTTON*/
let playButton = document.querySelector(".play");
const menu = new Audio();

const menuSong = (audiopass) => {
  menu.src = audiopass;
  menu.play();
};

playButton.addEventListener("click", (event) => {
  menuSong(event.currentTarget.dataset.src);
});

/* EVENT PAUSE BUTTON */

let pauseButton = document.querySelector(".pause");
const stopSong = () => {
  menu.pause();
};

pauseButton.addEventListener("click", () => {
  stopSong();
});

/* TOGGLE */
let togglePlay = document.querySelector(".button-play");
let togglePause = document.querySelector(".button-pause");

togglePlay.addEventListener("click", () => {
  togglePlay.style.display = "none";
  togglePause.style.display = "block";
});

togglePause.addEventListener("click", () => {
  togglePause.style.display = "none";
  togglePlay.style.display = "block";
});

/* EVENTS d10 */
const divD10 = document.querySelector("#div-d10");
const d10 = document.querySelector(".d10");
const navBar = document.querySelector(".nav-bar-postclick");
let deg = 0;
let navHidden = true;

const songDice = (audiopass) => {
  const audio = new Audio();
  audio.src = audiopass;
  audio.play();
};

const toggleNavBar = () => {
  navBar.style.marginLeft = navHidden ? "0%" : "-100%";
  navHidden = !navHidden;
};

d10.addEventListener("click", (event) => {
  clearInterval(animationZoom);
  deg += 360;

  d10.style.transform = `rotate(${deg}deg)`;
  toggleNavBar();
  songDice(event.currentTarget.dataset.src);

  animationZoom = setInterval(animateZoom, 500);
});

/* EVENT ICONS */
const addHoverSoundEvent = (element, audioSrc) => {
  const audio = new Audio();
  audio.src = audioSrc;

  element.addEventListener("mouseenter", () => {
    audio.play();
  });
};

const manetteImage = document.querySelector(".jeu-vidéo-img");
addHoverSoundEvent(manetteImage, manetteImage.dataset.src);

const crayonImage = document.querySelector(".écriture-img");
addHoverSoundEvent(crayonImage, crayonImage.dataset.src);

const basseImage = document.querySelector(".musique-img");
addHoverSoundEvent(basseImage, basseImage.dataset.src);

/* API */
const options = {
  method: "GET",
  headers: {
    "X-RapidAPI-Key": "bd3d712599msh8af5d3271a8f4ecp1b503cjsn48061c645dfb",
    "X-RapidAPI-Host": "rpg-items.p.rapidapi.com",
  },
};

const handleApiResponse = (data) => {
  const randomItem = Math.floor(Math.random() * 359);
  const titleRpg = document.querySelector(".title-item");
  const typeRpg = document.querySelector(".type-item");
  const rarityRpg = document.querySelector(".rarity-item");
  const slotRpg = document.querySelector(".slot-item");

  titleRpg.innerHTML = data[randomItem].name;
  typeRpg.innerHTML = data[randomItem].type;
  rarityRpg.innerHTML = data[randomItem].rarity;
  slotRpg.innerHTML = data[randomItem].slot;
  console.log(data);
};

fetch("https://rpg-items.p.rapidapi.com/item", options)
  .then((response) => response.json())
  .then(handleApiResponse)
  .catch((err) => console.error(err));

const récompense = document.querySelector(".coffre-fermé");
const récompenseCachée = document.querySelector(".récompense");

récompense.addEventListener("click", () => {
  récompense.style.display = "none";
  récompenseCachée.style.display = "flex";
});
