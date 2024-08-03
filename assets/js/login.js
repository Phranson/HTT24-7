const passwordElement = document.getElementById("password");
const userNameElement = document.getElementById("userName");
const passwordInputElement = document.querySelector("label[for='password']");
const textInputElement = document.querySelector("label[for='userName']");
const showPwElement = document.getElementById("showPw");
const sbmitBttn = document.getElementById("submit");
let passwordValidation = true;
let usernameValidation = true;

passwordElement.addEventListener("focus", () => {
    passwordInputElement.classList.add("hide");
});

passwordElement.addEventListener("blur", function () {
    passwordInputElement.classList.remove("hide");
    if (this.value == "") {
        passwordValidation = false;
    } else {
        passwordValidation = true;
    }
    inputChecker();
});
userNameElement.addEventListener("focus", () => {
    textInputElement.classList.add("hide");
});
userNameElement.addEventListener("blur", function () {
    textInputElement.classList.remove("hide");
    if (this.value == "") {
        usernameValidation = false;
    } else {
        usernameValidation = true;
    }
    inputChecker();
});
sbmitBttn.addEventListener("click", function (e) {
    if (userNameElement.value == "" || passwordInputElement.value == "") {
        e.preventDefault();
        pushMessage("Oops, it looks like you might have missed a spot! We need both your username and password to proceed. Please fill in both fields and try again. If you're running into any trouble, we're here to help—just reach out to our support team. Let's get you logged in and ready to explore!", "error");
        this.disabled = true;
        this.classList.add("disabled");
        this.value = "Please controll your inputs";
    }
});

showPwElement.addEventListener("change", () => {
    if (showPwElement.checked == true) {
        passwordElement.type = "text";
    } else {
        passwordElement.type = "password";
    }
})

function inputChecker() {

    if (usernameValidation && passwordValidation) {
        sbmitBttn.disabled = false;
        sbmitBttn.classList.remove("disabled");
        sbmitBttn.value = "Login";
    } else {
        sbmitBttn.disabled = true;
        sbmitBttn.classList.add("disabled");
        sbmitBttn.value = "Please controll your inputs";
    }
}
