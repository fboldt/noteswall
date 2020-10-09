document.addEventListener("DOMContentLoaded", startup);

function startup() {
    document.querySelector("h1").style.color = "blue";
    createDivNotesOnBody();
    fetchNotes(notesFormater);
}
