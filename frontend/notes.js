document.addEventListener("DOMContentLoaded", function () {
    document.body.notes = new Notes();
});

class Notes {

    constructor() {
        this.makeNewNoteFormDiv();
        this.makeNotesDiv();
    }

    removeNote(noteid) {
        const userid = this.loginDiv.getAttribute('userid');
        let data = new FormData();
        data.append('userid', userid);
        data.append('noteid', noteid);
        fetch('backend/removenote.php', { method: 'POST', body: data })
            .then(response => response.text())
            .then(data => {
                if (data == "1") {
                    this.fetchNotes();
                }
            });
    }

    makeNewNoteFormDiv() {
        this.newNoteFormDiv = document.createElement("div");
        this.newNoteFormDiv.innerHTML = `
        <form action="javascript:document.body.notes.insertNote()">
            <textarea name="notetext" placeholder="new note" id="newnotetext" cols="25" rows="3" maxlength="128" required></textarea>
            <input type="submit" value="insert note">
        </form>`;
        document.body.appendChild(this.newNoteFormDiv);
        this.createLoginDivObserver();
    }

    createLoginDivObserver() {
        this.loginDiv = document.querySelector("#login");
        const observer = new MutationObserver(() => {
            newNoteFormDisplay(this.loginDiv, this.newNoteFormDiv);
            const userid = this.loginDiv.getAttribute('userid');
            toggleRemoveNoteLinkDisplay(userid);
        });
        observer.observe(this.loginDiv, { subtree: true, childList: true });
    }

    insertNote() {
        const userid = this.loginDiv.getAttribute('userid');
        const form = this.newNoteFormDiv.querySelector("form");
        let data = new FormData();
        data.append('userid', userid);
        data.append('notetext', form.newnotetext.value);
        fetch('backend/insertnote.php', { method: 'POST', body: data })
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
        this.createNotesDivObserver();
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

    createNotesDivObserver() {
        const observer = new MutationObserver(() => {
            const userid = this.loginDiv.getAttribute('userid');
            toggleRemoveNoteLinkDisplay(userid);
        });
        observer.observe(this.notesDiv, { subtree: true, childList: true });
    }
    
}

function toggleRemoveNoteLinkDisplay(userid) {
    let links = document.querySelectorAll(`.linkremovenote`);
    links.forEach(link => {
        if (link.getAttribute("userid") == userid) {
            link.style.display = "inline";
        } else {
            link.style.display = "none";
        }        
    })
}

function newNoteFormDisplay(loginDiv, newNoteFormDiv) {
    let userid = loginDiv.getAttribute('userid');
    if (userid != '0') {
        newNoteFormDiv.style.display = "block";
    } else {
        newNoteFormDiv.style.display = "none";
    }
}

function formatNote(note) {
    return `    <div id="note${note.noteid}" userid="${note.userid}">
        <div class="username"">${note.username}</div>
        <div class="notetime">${note.notetime}</div>
        <div class="notetext">
            ${note.notetext}
            <a href="javascript:document.body.notes.removeNote(${note.noteid})" class="linkremovenote" userid="${note.userid}" style="display: none">remove</a>
        </div>
    </div>`;
}
