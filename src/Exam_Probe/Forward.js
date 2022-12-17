let request = new XMLHttpRequest();

function requestData() { // fordert die Daten asynchron an
    "use strict";
    let url = document.getElementById("urlField").value;
    request.open("GET", "CalculateHash.php?URL="+url);
    request.onreadystatechange = processData;
    request.send(null);
}

function processData() {
    "use strict";
    if (request.readyState === 4) { // Uebertragung = DONE
        if (request.status === 200) { // HTTP-Status = OK
            if (request.responseText != null)
                updateView(request.responseText); // Daten verarbeiten
            else console.error("Dokument ist leer");
        } else console.error("Uebertragung fehlgeschlagen");
    } // else; // Uebertragung laeuft noch
}

// Ende des gegebenen Codes


function pollData() {
    "use strict";
    requestData();
}

function updateView(data) {
    "use strict";
    console.log(data);
    let dataObject = JSON.parse(data);
    //console.log(dataObject.hashValue);
    let hashField = document.getElementById("hashValue");
    hashField.firstChild.nodeValue = dataObject.hashValue;
}

