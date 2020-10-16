document.addEventListener("DOMContentLoaded", function () {
    document.body.login = new Login();
});

function logout() {
    document.body.login.logout();
}

function login() {
    document.body.login.login();
}

class Login {

    constructor() {
        this.makeDivLogin();
    }

    makeDivLogin() {
        this.loginDiv = document.createElement("div");
        this.loginDiv.setAttribute("id", "login");
        document.body.appendChild(this.loginDiv);
        this.fetchCheckLoginPage();
    }

    fetchCheckLoginPage() {
        fetch('auth/checklogin.php')
            .then(response => response.json())
            .then(data => {
                this.checkLogin(data);
            });
    }

    checkLogin(user) {
        if (user.userid > 0) {
            this.makeFormLogout(user);
            this.loginDiv.setAttribute("userid", user.userid);
        } else {
            this.makeFormLogin();
            this.loginDiv.setAttribute("userid", "0");
        }
    }

    makeFormLogout(user) {
        this.loginDiv.innerHTML = `${user.username}
        <a href="javascript:logout()">logout</a>`;
    }

    logout() {
        let data = new FormData();
        data.append('username', "");
        data.append('password', "");
        fetch('auth/checklogin.php', { method: "POST", body: data })
            .then(response => response.json())
            .then(data => {
                this.checkLogin(data);
            });
    }

    makeFormLogin() {
        this.loginDiv.innerHTML = `
        <form action="javascript:login()" id="loginform">
            <input type="text" size="6" name="username" placeholder="username">
            <input type="password" size="6" name="password" placeholder="password">
            <input type="submit" value="login">
        </form>`;
    }

    login() {
        const form = this.loginDiv.querySelector("form");
        let data = new FormData();
        data.append('username', form.username.value);
        data.append('password', form.password.value);
        fetch('auth/checklogin.php', { method: 'POST', body: data })
            .then(response => response.json())
            .then(data => {
                this.checkLogin(data);
            });
    }

}
