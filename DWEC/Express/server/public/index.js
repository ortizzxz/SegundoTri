window.onload = () => {
    const socket = io();    
    
    const sendBtn = document.getElementById('send');
    const messageInput = document.getElementById('data');
    const messagesContainer = document.getElementById('messages-container');
    let name = prompt('Escribe tu nombre: ');


    //envio mensaje al servidor
    sendBtn.addEventListener('click', () => {
        const messageText = messageInput.value.trim();
        if (messageText) {
            const messageData = { user: name, data: messageText };
            socket.emit('message', JSON.stringify(messageData));
            addMessageData(messageData, 'user');
            messageInput.value = '';
        }
    });

    // recibo mensaje del servidor
    socket.on('messageServidor', (data) => {
        const receivedData = JSON.parse(data);
        addMessageData(receivedData, 'other'); 
    });

    // funcion para agregar un mensaje a la interfaz
    function addMessageData(messageData, type) {
        const messageDiv = document.createElement('div');
        messageDiv.classList.add('message', type); // añadir clases para estilo
        messageDiv.textContent = `${messageData.user}: ${messageData.data}`;
        messagesContainer.appendChild(messageDiv);

        // desplazar automáticamente hacia el último mensaje
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
};