class Notes {
    constructor() {
        this.makeNewNoteFormDiv();
        this.makeNotesDiv();
    }

    makeNewNoteFormDiv() {
        this.newNoteFormDiv = document.createElement("div");
        this.newNoteFormDiv.innerHTML = `
        <form action="javascript:document.body.notes.insertNote()">
            <textarea name="notetext" placeholder="new note" id="newnotetext" cols="25" rows="3" maxlength="128" required></textarea>
            <input type="submit" value="insert note">
        </form>`;
        document.body.appendChild(this.newNoteFormDiv);
        this.createObserver();
    }

    createObserver() {
        this.loginDiv = document.querySelector("#login");
        const observer = new MutationObserver(() => {
            newNoteFormDisplay(this.loginDiv, this.newNoteFormDiv);
        });
        observer.observe(this.loginDiv, { subtree: true, childList: true });
    }

    insertNote() {
        const userid = this.loginDiv.getAttribute('userid');
        const form = this.newNoteFormDiv.querySelector("form");
        let data = new FormData();
        data.append('userid', userid);
        data.append('notetext', form.newnotetext.value);
        fetch('backend/newnote.php', { method: 'POST', body: data })
            .then(response => response.text())
            .then(data => {
                if (data == "1") {
                    this.fetchNotes();
                    form.newnotetext.value = "";
                }
            });
    }

    makeNotesDiv() {
        this.notesDiv = document.createElement("div");
        document.body.appendChild(this.notesDiv);
        this.fetchNotes();
    }
    
    fetchNotes() {
        fetch('backend/getnotes.php')
            .then(response => response.json())
            .then(data => {
                this.notesDiv.innerHTML = "";
                data.notes.forEach(note => {
                    this.notesDiv.innerHTML = formatNote(note) + this.notesDiv.innerHTML ;
                });
            });
    }
}

function newNoteFormDisplay(loginDiv, newNoteFormDiv) {
    if (loginDiv.getAttribute('userid') != '0') {
        newNoteFormDiv.style.display = "block";
    } else {
        newNoteFormDiv.style.display = "none";
    }
}

function formatNote(note) {
    return `    <div id="note${note.noteid}" userid="${note.userid}">
        <div class="username"">${note.username}</div>
        <div class="notetime">${note.notetime}</div>
        <div class="notetext">${note.notetext}</div>
    </div>`;
}

document.addEventListener("DOMContentLoaded", function () {
    document.body.notes = new Notes();
});
