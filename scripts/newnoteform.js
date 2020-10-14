document.addEventListener("DOMContentLoaded", startupNewNoteForm);

function startupNewNoteForm() {
    createNewNoteFormDiv();
    fetchNewNoteForm();
}

function createNewNoteFormDiv() {
    let newNoteFormDiv = document.createElement("div");
    newNoteFormDiv.setAttribute("id", "newnoteform");
    document.body.appendChild(newNoteFormDiv);
}

function fetchNewNoteForm() {
    fetch('newnoteform.html')
        .then(res => {
            return res.text();
        })
        .then(data => {
            document.querySelector("#newnoteform").innerHTML = data;
        });
}

