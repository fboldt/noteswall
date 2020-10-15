document.addEventListener("DOMContentLoaded", startupCheckLogin);

function startupCheckLogin() {
    createCheckLoginDiv();
    fetchCheckLoginPage(treatLogin);
}

function createCheckLoginDiv() {
    let login = document.createElement("div");
    login.setAttribute("id", "login");
    document.body.appendChild(login);
}

function fetchCheckLoginPage() {
    fetch('auth/checklogin.php')
        .then(response => response.json())
        .then(data => treatLogin(data));
}

function treatLogin(data) {
    if (userIsLogged(data)) {
        document.querySelector("#login").innerHTML = `${data.username}
        <a href="javascript:logout()">logout</a>`;
        document.querySelector("#login").setAttribute("userid", data.userid);
    } else {
        makeFormLogin();
        document.querySelector("#login").setAttribute("userid", "0");
    }
}

function userIsLogged(data) {
    return data.userid > 0;
}

function logout() {
    let data = new FormData();
    data.append('username', "");
    data.append('password', "");
    fetch('auth/checklogin.php', { method: "POST", body: data })
        .then(response => response.json())
        .then(data => treatLogin(data));
}

function makeFormLogin() {
    document.querySelector("#login").innerHTML = `
    <form action="javascript:login()" id="loginform">
        <input type="text" size="6" name="username" placeholder="username">
        <input type="password" size="6" name="password" placeholder="password">
        <input type="submit" value="login">
    </form>`;
}

function login() {
    const form = document.querySelector("#loginform");
    let data = new FormData();
    data.append('username', form.username.value);
    data.append('password', form.password.value);
    fetch('auth/checklogin.php', { method: 'POST', body: data })
        .then(response => response.json())
        .then(data => treatLogin(data));
}
