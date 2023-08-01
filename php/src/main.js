document.addEventListener('DOMContentLoaded', function() {
    setInterval(resultLog, 1000);

    function resultLog() {
        let preFS = document.getElementById('preFilesize');
        let aftFS = document.getElementById('aftFilesize');

        if (preFS.value === aftFS.value) {
            let xhr = new XMLHttpRequest();

            xhr.open('GET', 'chatlog.php?ajax=' + "OFF", true);
            xhr.send(null);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        aftFS.value = xhr.responseText;
                    }
                }
            }
        } else {
            let chatArea = document.getElementById('chat-area');
            let xhr = new XMLHttpRequest();

            xhr.open('GET', 'chatlog.php?ajax=' + "ON", true);
            xhr.send(null);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        chatArea.insertAdjacentHTML('afterbegin', xhr.responseText);

                        let chatAreaHeight = chatArea.scrollHeight;
                        chatArea.scrollTop = chatAreaHeight;
                    }
                } else {
                    chatArea.textContent = '';
                }
            }
        };
    };
}, false);