document.getElementById('messageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const messageInput = document.getElementById('messageInput');
    const message = messageInput.value;
    if (message.trim() !== '') {
        const messageElement = document.createElement('div');
        messageElement.textContent = message;
        document.getElementById('messages').appendChild(messageElement);
        messageInput.value = '';
    }
});