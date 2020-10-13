function createNewNoteFormDiv() {
    let newNoteFormDiv = document.createElement("div");
    newNoteFormDiv.setAttribute("id", "newnoteformdiv");
    document.body.appendChild(newNoteFormDiv);
}

function fetchNewNoteForm() {
    fetch('newnoteform.html')
        .then(res => {
            return res.text();
        })
        .then(data => {
            document.querySelector("#newnoteformdiv").innerHTML = data;
        });
}
