document.addEventListener("DOMContentLoaded", startupCheckLogin);

function startupCheckLogin() {
    createCheckLoginDiv();
    fetchCheckLoginPage(treatLogin);
}

function createCheckLoginDiv() {
    let newDiv = document.createElement("div");
    newDiv.setAttribute("id", "checklogin");
    document.body.appendChild(newDiv);
}

function fetchCheckLoginPage() {
    fetch('backend/checklogin.php')
        .then(response => response.json())
        .then(data => treatLogin(data));
}

function treatLogin(data) {
    if (isUserLogged(data)) {
        document.querySelector("#checklogin").innerHTML = `${data.username}
        <a href='backend/logout.php'>logout</a>`;
    } else {
        fetchFormLogin();
    }
}

function isUserLogged(data) {
    return data.userid > 0;
}

function fetchFormLogin() {
    fetch('formlogin.html')
        .then(response => response.text())
        .then(data => {
            document.querySelector("#checklogin").innerHTML = data;
        });

}
