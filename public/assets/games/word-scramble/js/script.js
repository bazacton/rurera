const wordText = document.querySelector(".word"),
timeText = document.querySelector(".time b"),
gameTime = document.querySelector(".game-container").getAttribute('data-max_time'),
inputField = document.querySelector("input"),
refreshBtn = document.querySelector(".refresh-word"),
checkBtn = document.querySelector(".check-word");

let correctWord, timer, gameTimer;
let timerCounter = 0;

console.log(gameTime);
const initGameTimer = maxGameTime => {
    clearInterval(gameTimer);
    gameTimer = setInterval(() => {
        timerCounter++;
        if(maxGameTime > 0) {
            maxGameTime--;
            if( timerCounter >= 10){
                update_user_game_time(maxGameTime);
                timerCounter = 0;
            }
            return document.querySelector(".game-container").setAttribute('data-max_time', maxGameTime);
            //return gameTime = maxGameTime;
        }
        update_user_game_time(maxGameTime);
        alert(`Time off!!!!!!!!!!!!!`);

    }, 1000);
}

const initTimer = maxTime => {
    clearInterval(timer);
    timer = setInterval(() => {
        if(maxTime > 0) {
            maxTime--;
            return timeText.innerText = maxTime;
        }
        alert(`Time off! ${correctWord.toUpperCase()} was the correct word`);
        initGame();
    }, 1000);
}

const initGame = () => {
    initTimer(30);
    let randomObj = words[Math.floor(Math.random() * words.length)];
    let wordArray = randomObj.word.split("");
    for (let i = wordArray.length - 1; i > 0; i--) {
        let j = Math.floor(Math.random() * (i + 1));
        [wordArray[i], wordArray[j]] = [wordArray[j], wordArray[i]];
    }
    wordText.innerText = wordArray.join("");
    correctWord = randomObj.word.toLowerCase();;
    inputField.value = "";
    inputField.setAttribute("maxlength", correctWord.length);
}
initGame();
initGameTimer(gameTime);

const checkWord = () => {
    let userWord = inputField.value.toLowerCase();
    if(!userWord) return alert("Please enter the word to check!");
    if(userWord !== correctWord) return alert(`Oops! ${userWord} is not a correct word`);
    alert(`Congrats! ${correctWord.toUpperCase()} is the correct word`);
    initGame();
}

refreshBtn.addEventListener("click", initGame);
checkBtn.addEventListener("click", checkWord);