function createNotesDiv() {
    let notesDiv = document.createElement("div");
    notesDiv.setAttribute("id", "notes");
    document.body.appendChild(notesDiv);
}

function fetchNotes(formater) {
    fetch('backend/getnotes.php')
        .then(response => response.json())
        .then(data => formater(data.notes));
}

function notesFormater(listOfNotes) {
    let divNotes = document.querySelector("#notes");
    listOfNotes.forEach(function (note) {
        text = noteMessageFormater(note);
        divNotes.appendChild(text)
    })
}

function createDiv(klass) {
    let div = document.createElement("div");
    div.setAttribute("class", klass);
    return div;
}

function addText(elem, text) {
    textNode = document.createTextNode(text);
    elem.appendChild(textNode);
}

function createDivWithText(klass, text) {
    let div = createDiv(klass);
    addText(div, text);
    return div;
}

function noteMessageFormater(note) {
    let divNote = createDiv("note");
    let fields = {
        "noteuser": note.username,
        "notetime": note.notetime,
        "notetext": note.message,
    }
    for (let klass in fields) {
        let element = createDivWithText(klass, fields[klass]);
        divNote.appendChild(element);
    }
    return divNote;
}
