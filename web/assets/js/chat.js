let clientInput = document.getElementById('clientInput');
let chatWrapper = document.getElementById('chatWrapper');

const chat = new WebSocket('ws://localhost:8080');

chat.onopen = () => {
    console.log('Connection has been opened');
};

chat.onclose = (event) => {
    if (event.wasClean) {
        console.log('Connection has been disconnected');
    } else {
        console.log('Connection has been killed');
    }
    console.log(`Code: ${event.code} reason: ${event.reason}`);
};

chat.onmessage = (event) => {
    console.log(event.data);
    let data = JSON.parse(event.data);
    let newMessage = '<div class="message"><b>Рандоманый юзер: </b><p>' + data.message + '</p></div>';
    chatWrapper.innerHTML += newMessage;
};

chat.onerror = (error) => {
    console.log(`Error: ${error.message}`)
};


function onSendMessage() {
    json = {
      username: 'Pavel Laikov',
      message: clientInput.value
    };
    chat.send(JSON.stringify(json));
    let userMessage = '<div class="message"><b>Я: </b><p>' + clientInput.value + '</p></div>';
    chatWrapper.innerHTML += userMessage;
}
