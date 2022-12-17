let request = new XMLHttpRequest();
let word;

function requestData() { // fordert die Daten asynchron an
    "use strict";


    request.open("GET", "Exam22API.php?search="+word); // URL für HTTP-GET
    request.onreadystatechange = processData; //Callback-Handler zuordnen
    request.send(null); // Request abschicken
}

function processData() {
    "use strict";
    if (request.readyState === 4) { // Uebertragung = DONE
        if (request.status === 200) { // HTTP-Status = OK
            if (request.responseText != null)
                //ToDo - vervollständigen ***********
                processResponse(request.response);
            else console.error("Dokument ist leer");
        } else console.error("Uebertragung fehlgeschlagen");
    } // else; // Uebertragung laeuft noch
}

function wordClickHandler() {
    "use strict";
    word = window.getSelection().toString();
    if(word.length >= 2) {
        requestData();
    }
}

function processResponse(data){
    //3c
    "use strict";
    console.log(data["explanation"]);
    if(data) {
        let object = JSON.parse(data);
        let text = object.explanation;
        console.log(object.word);
        let element = document.getElementById("erklärungId");
        element.innerText = text;
    }
}

