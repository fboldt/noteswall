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
    fetch('backend/login.php')
        .then(response => response.json())
        .then(data => treatLogin(data));
}

function logout() {
    let data = new FormData();
    data.append('username', "");
    data.append('password', "");

    fetch('backend/login.php', { method: "POST", body: data })
        .then(response => response.json())
        .then(data => treatLogin(data));
}

function treatLogin(data) {
    if (isUserLogged(data)) {
        document.querySelector("#checklogin").innerHTML = `${data.username}
        <a href="javascript:logout()">logout</a>
        `;
    } else {
        fetchFormLogin();
    }
}

function isUserLogged(data) {
    return data.userid > 0;
}

function login() {
    const form = document.querySelector('#formlogin');
    let data = new FormData();
    data.append('username', form.username.value);
    data.append('password', form.password.value);

    fetch('backend/login.php', { method: 'POST', body: data })
        .then(response => response.json())
        .then(data => treatLogin(data));
}


function fetchFormLogin() {
    document.querySelector("#checklogin").innerHTML = `
    <form action="javascript:login()" id="formlogin">
        <input type="text" size="6" name="username" placeholder="username">
        <input type="password" size="6" name="password" placeholder="password">
        <input type="submit" value="login">
    </form>
        `;
}
