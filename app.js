/* ALERTE */

alert("Veuillez activer le son pour plus d'immersion");

/* SET INTERVAL */

let intervalD10 = true;

let animationZoom = setInterval(() => {
  if (intervalD10 === true) {
    d10.style.transform = "scale(1.2)";
    intervalD10 = false;
  } else if (intervalD10 === false) {
    d10.style.transform = "scale(1)";
    intervalD10 = true;
  }
}, 500);

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
  clearInterval(animationZoom);
  deg += 360;

  d10.style.transform = `rotate(${deg}deg)`;
  if (navHidden === true) {
    navBar.style.marginLeft = "0%";
    navHidden = false;
  } else if (navHidden === false) {
    navBar.style.marginLeft = "-100%";
    navHidden = true;
  }
  songDice();

  animationZoom = setInterval(() => {
    if (intervalD10 === true) {
      d10.style.transform = "scale(1.2)";
      intervalD10 = false;
    } else if (intervalD10 === false) {
      d10.style.transform = "scale(1)";
      intervalD10 = true;
    }
  }, 1000);
});

/* NAV BAR POST CLICK */

let navBar = document.querySelector(".nav-bar-postclick");

/* EVENT ICONES */

let manetteImage = document.querySelector(".jeu-vidéo-img");

const bruitageManette = new Audio();

const manette = () => {
  bruitageManette.src = "./Musiques/manette.ogg";
  bruitageManette.play();
};

manetteImage.addEventListener("mouseenter", () => {
  manette();
});

let crayonImage = document.querySelector(".écriture-img");

const bruitageCrayon = new Audio();

const crayon = () => {
  bruitageCrayon.src = "./Musiques/write.mp3";
  bruitageCrayon.play();
};

crayonImage.addEventListener("mouseenter", () => {
  crayon();
});

let basseImage = document.querySelector(".musique-img");

const bruitageBasse = new Audio();

const basse = () => {
  bruitageBasse.src = "./Musiques/slap.flac";
  bruitageBasse.play();
};

basseImage.addEventListener("mouseenter", () => {
  basse();
});

/* API */

const options = {
  method: "GET",
  headers: {
    "X-RapidAPI-Key": "bd3d712599msh8af5d3271a8f4ecp1b503cjsn48061c645dfb",
    "X-RapidAPI-Host": "rpg-items.p.rapidapi.com",
  },
};

fetch("https://rpg-items.p.rapidapi.com/item", options)
  .then((response) => response.json())
  .then((data) => {
    let randomItem = Math.floor(Math.random() * 359);
    const titleRpg = document.querySelector(".title-item");
    const typeRpg = document.querySelector(".type-item");
    const rarityRpg = document.querySelector(".rarity-item");
    const slotRpg = document.querySelector(".slot-item");

    titleRpg.innerHTML = data[randomItem].name;
    typeRpg.innerHTML = data[randomItem].type;
    rarityRpg.innerHTML = data[randomItem].rarity;
    slotRpg.innerHTML = data[randomItem].slot;
    console.log(data);
  })
  .catch((err) => console.error(err));
let récompense = document.querySelector(".coffre-fermé");
let récompenseCachée = document.querySelector(".récompense");

récompense.addEventListener("click", () => {
  récompense.style.display = "none";
  récompenseCachée.style.display = "flex";
});
