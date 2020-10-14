document.addEventListener("DOMContentLoaded", startupNewNoteForm);

function startupNewNoteForm() {
    createNewNoteFormDiv();
    makeNewNoteForm();
    createObserver();
}

function createNewNoteFormDiv() {
    let newNoteFormDiv = document.createElement("div");
    newNoteFormDiv.setAttribute("id", "newnoteform");
    document.body.appendChild(newNoteFormDiv);
}

function makeNewNoteForm() {
    document.querySelector("#newnoteform").innerHTML = `
<form action="javascript:insertNote()" id="insertnoteform">
    <textarea name="notetext" placeholder="new note" id="newnotetext" cols="25" rows="5" maxlength="128" required></textarea>
    <br>
    <input type="submit" value="insert note">
</form>`;
}

function insertNote() {
    const userid = document.querySelector("#login").getAttribute('userid');
    const form = document.querySelector("#insertnoteform");
    let data = new FormData();
    data.append('userid', userid);
    data.append('password', form.newnotetext.value);
    fetch('backend/newnote.php', { method: 'POST', body: data })
        .then(response => response.text())
        .then(data => console.log(data));
}

function createObserver() {
    const elementToObserve = document.querySelector("#login");
    const observer = new MutationObserver(function() {
        newNoteFormDisplay();
    });
    observer.observe(elementToObserve, {subtree: true, childList: true});
}

function newNoteFormDisplay() {
    newNoteForm = document.querySelector("#newnoteform");
    if (document.querySelector("#login").getAttribute('userid') != '0') {
        newNoteForm.style.display = "block";
    } else {
        newNoteForm.style.display = "none";
    }
}
