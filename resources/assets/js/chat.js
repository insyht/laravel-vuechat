function submitForm() {
    var http = new XMLHttpRequest();
    http.open("POST", "/chat", true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    var message = document.getElementById('message').value;
    var param = '_token=' + csrf_token + '&message=' + message;

    http.send(param);
    http.onload = function () {
        // do something
    }
}

document.getElementById('sendButton').addEventListener("click", submitForm);
