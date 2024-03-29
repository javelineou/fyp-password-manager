// Clear the concole on every refresh
// console.clear();
function passGen() {
  // Object of all the function names that we will use to create random letters of password
  const randomFunc = {
    lower: getRandomLower,
    upper: getRandomUpper,
    number: getRandomNumber,
    symbol: getRandomSymbol,
  };

  // Random more secure value
  function secureMathRandom() {
    return (
      window.crypto.getRandomValues(new Uint32Array(1))[0] /
      (Math.pow(2, 32) - 1)
    );
  }

  // Generator Functions
  // All the functions that are responsible to return a random value taht we will use to create password.
  function getRandomLower() {
    return String.fromCharCode(Math.floor(Math.random() * 26) + 97);
  }
  function getRandomUpper() {
    return String.fromCharCode(Math.floor(Math.random() * 26) + 65);
  }
  function getRandomNumber() {
    return String.fromCharCode(Math.floor(secureMathRandom() * 10) + 48);
  }
  function getRandomSymbol() {
    const symbols = '~!@#$%^&*()_+{}":?><;.,';
    return symbols[Math.floor(Math.random() * symbols.length)];
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

  //Calculate crack time
  function calculateAndSetCrackTime2() {
    var timeToCrack = zxcvbn(resultEl.innerText);
    var readableCrackTime = convertSecondsToReadable(timeToCrack.crack_time);
    document.querySelector(".crack-time-2").innerHTML = readableCrackTime;
  }

  // The Viewbox where the result will be shown
  const resultEl = document.getElementById("result");
  // The input length, will use to change the length of the password
  var lengthEl = document.getElementById("length");

  //Minimum of length is 8. If length is lower than 8, auto set to 8.
  if (lengthEl < 8) {
    lengthEl = 8;
  }

  // Checkboxes representing the options that is responsible to create differnt type of password based on user
  const uppercaseEl = document.getElementById("uppercase");
  const lowercaseEl = document.getElementById("lowercase");
  const numberEl = document.getElementById("number");
  const symbolEl = document.getElementById("symbol");

  // Button to generate the password
  const generateBtn = document.getElementById("btn-generatePw");
  //Button to copy the password
  const copyBtn = document.getElementById("copy");
  // Result viewbox container
  const resultContainer = document.querySelector(".result");

  // Initially run it upon load
  resultEl.innerText = generatePassword(16, true, true, true, false);
  calculateAndSetCrackTime2();

  //Copy password to clipboard when copy button clicked
  copyBtn.addEventListener("click", () => {
    const textarea = document.createElement("textarea");
    const password = resultEl.innerText;
    if (!password) {
      return;
    }
    textarea.value = password;
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand("copy");
    textarea.remove();
  });

  // When Generate is clicked, Password id generated.
  generateBtn.addEventListener("click", () => {
    const length = +lengthEl.value;
    const hasLower = lowercaseEl.checked;
    const hasUpper = uppercaseEl.checked;
    const hasNumber = numberEl.checked;
    const hasSymbol = symbolEl.checked;
    generatedPassword = true;
    resultEl.innerText = generatePassword(
      length,
      hasLower,
      hasUpper,
      hasNumber,
      hasSymbol
    );
    calculateAndSetCrackTime2();
  });

  // Function responsible to generate password and then returning it.
  function generatePassword(length, lower, upper, number, symbol) {
    let generatedPassword = "";
    const typesCount = lower + upper + number + symbol;
    const typesArr = [{ lower }, { upper }, { number }, { symbol }].filter(
      (item) => Object.values(item)[0]
    );
    if (typesCount === 0) {
      return "";
    }
    for (let i = 0; i < length; i++) {
      typesArr.forEach((type) => {
        const funcName = Object.keys(type)[0];
        generatedPassword += randomFunc[funcName]();
      });
    }
    return generatedPassword.slice(0, length);
  }

  // function that handles the checkboxes state, so at least one needs to be selected. The last checkbox will be disabled.
  function disableOnlyCheckbox() {
    let totalChecked = [uppercaseEl, lowercaseEl, numberEl, symbolEl].filter(
      (el) => el.checked
    );
    totalChecked.forEach((el) => {
      if (totalChecked.length == 1) {
        el.disabled = true;
      } else {
        el.disabled = false;
      }
    });
  }

  [uppercaseEl, lowercaseEl, numberEl, symbolEl].forEach((el) => {
    el.addEventListener("click", () => {
      disableOnlyCheckbox();
    });
  });
}

passGen();
