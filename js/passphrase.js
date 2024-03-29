function passphraseGen() {
  // Cryptographic replacement for Math.random()
  function randomNumberBetweenZeroAndOne() {
    var crypto = window.crypto || window.msCrypto;
    return crypto.getRandomValues(new Uint32Array(1))[0] / 4294967295;
  }

  function generatePassword(numberOfWords) {
    numberOfWords = parseInt(numberOfWords);

    // Empty array to be filled with wordlist
    var generatedPasswordArray = [];

    // Grab a random word, push it to the password array
    for (var i = 0; i < numberOfWords; i++) {
      var index = Math.floor(randomNumberBetweenZeroAndOne() * 7776);
      generatedPasswordArray.push(wordlist[index]);
    }

    return generatedPasswordArray.join(" ");
  }

  function setStyleFromWordNumber(passwordField, numberOfWords) {
    var baseSize = "40";

    if (numberOfWords == 12) {
      passwordField.setAttribute("style", "font-size: " + 20 + "px;");
    } else {
      var newSize = baseSize * (4 / numberOfWords);
      passwordField.setAttribute("style", "font-size: " + newSize + "px;");
    }
  }

  function convertSecondsToReadable(seconds) {
    var timeString = "";
    var crackabilityColor = "green";

    // Enumerate all the numbers
    var numMilliseconds = seconds * 1000;
    var numSeconds = Math.floor(seconds);
    var numMinutes = Math.floor(numSeconds / 60);
    var numHours = Math.floor(numSeconds / (60 * 60));
    var numDays = Math.floor(numSeconds / (60 * 60 * 24));
    var numYears = Math.floor(numSeconds / (60 * 60 * 24 * 365));
    var numCenturies = Math.floor(numSeconds / (60 * 60 * 24 * 365 * 100));

    if (numMilliseconds < 1000) {
      timeString = numMilliseconds + " milliseconds";
    } else if (numSeconds < 60) {
      timeString = numSeconds + " seconds";
    } else if (numMinutes < 60) {
      timeString = numMinutes + " minutes";
    } else if (numHours < 24) {
      timeString = numHours + " hours";
    } else if (numDays < 365) {
      timeString = numDays + " days";
    } else if (numYears < 100) {
      timeString = numYears + " years";
    } else {
      timeString = numCenturies + " centuries";
    }

    return timeString.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }

  function calculateAndSetCrackTime() {
    var timeToCrack = zxcvbn(passwordField.textContent);
    var readableCrackTime = convertSecondsToReadable(timeToCrack.crack_time);
    document.querySelector(".crack-time").innerHTML = readableCrackTime;
  }

  var selectField = document.getElementById("passphrase_select");
  var passwordField = document.getElementById("passphrase");
  var phraseButton = document.getElementById("btn-generatePp");
  var copyBtn2 = document.getElementById("copy2");

  // Initially run it upon load
  passwordField.textContent = generatePassword(4);
  setStyleFromWordNumber(passwordField, 4);
  calculateAndSetCrackTime();

  // Listen for a button click
  phraseButton.addEventListener("click", function () {
    var numberOfWords = selectField.options[selectField.selectedIndex].value;
    passwordField.textContent = generatePassword(numberOfWords);
    setStyleFromWordNumber(passwordField, numberOfWords);
    calculateAndSetCrackTime();
  });

  //Copy password to clipboard when copy button clicked
  copyBtn2.addEventListener("click", () => {
    const textarea = document.createElement("textarea");
    const password = passwordField.textContent;
    if (!password) {
      return;
    }
    textarea.value = password;
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand("copy");
    textarea.remove();
  });
}

passphraseGen();
