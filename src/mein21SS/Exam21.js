let request = new XMLHttpRequest();

function requestData() { // fordert die Daten asynchron an
    "use strict";
    let gameId = document.getElementById("gameId").value;
    console.log(gameId);
    request.open("GET", "Exam21API.php?gameId="+gameId); // URL für HTTP-GET
    request.onreadystatechange = processData; //Callback-Handler zuordnen
    request.send(null); // Request abschicken
}

function processData() {
    "use strict";
    if (request.readyState === 4) { // Uebertragung = DONE
        if (request.status === 200) { // HTTP-Status = OK
            if (request.responseText != null)
                //ToDo - vervollständigen ***********
                processResponse(request.responseText);
            else console.error("Dokument ist leer");
        } else console.error("Uebertragung fehlgeschlagen");
    } // else; // Uebertragung laeuft noch
}

function pollData() {
    "use strict";
    requestData();
    window.setInterval(requestData, 5000);
}

function processResponse(data){
    "use strict";
    let object = JSON.parse(data)[0];
    console.log(object);
    let amount = document.getElementById("playerAmount");
    amount.firstChild.nodeValue = object.playing;
}