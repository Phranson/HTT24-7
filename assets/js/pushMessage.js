function pushMessage(message, typeOfMessage) {
    let container = document.createElement("div");
    container.classList.add("messageContainer");
    document.body.appendChild(container);
    let messageBody = document.createElement("div");
    messageBody.classList.add(typeOfMessage);
    messageBody.classList.add("message");
    messageBody.innerHTML = message;
    container.appendChild(messageBody);
    setTimeout(() => { messageBody.style.opacity = 0; setTimeout(() => container.remove(), 1000) }, 5000);
}