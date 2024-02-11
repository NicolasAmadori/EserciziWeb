// •	Al click sul bottone “Nuova partita” si dovrà:
// o	    Fare una richiesta alla pagina index.php. Alla risposta del server, creare una tabella 9*9, le cui celle compilata secondo quanto restituito dal server. 
// •	Al click sul bottone “Aggiungi” si dovrà:
// o	    Leggere gli input riga, colonna e valore.
// o	    Controllare che riga, colonna e valore siano compresi tra 1 e 9 ed in caso contrario visualizzare un messaggio di errore.
// o	    Aggiungere il valore nella tabella.
// •	Al click sul bottone “Valuta Soluzione” si dovrà:
// o	Leggere i numeri della tabella contenuto della tabella.
// o	Inviarli al server
// o	In base alla risposta, visualizzare uno dei due span.


window.onload = function() {
    let form = document.querySelector("form");
    let spanVittoria = document.querySelector(".win");
    let spanSconfitta = document.querySelector("#lose");
    let bottoni = document.querySelectorAll("button");
    let btnAggiungi = document.querySelector("input[name='submit']");

    //Nascondi
    form.hidden = true;
    spanVittoria.hidden = true;
    spanSconfitta.hidden = true;
    bottoni[1].hidden = true;

    //Bottone Nuova partita
    bottoni[0].addEventListener("click", function() {
        form.hidden = false;
        bottoni[1].hidden = false;

        let xhttp = new XMLHttpRequest();

        xhttp.onload = function() {
            let statoIniziale = JSON.parse(xhttp.response).statoIniziale
            createTable(statoIniziale);
        }

        xhttp.open("GET", "index.php");
        xhttp.send();

        form.querySelectorAll("input").forEach(function(input) {
            if (input.tagName.toLowerCase() != "input") {
                input.value = null;
            }
        });
    });

    btnAggiungi.addEventListener("click", function(event) {
        event.preventDefault();
        let riga = parseInt(document.querySelector("#riga").value);
        let colonna = parseInt(document.querySelector("#colonna").value);
        if (riga < 1 || riga > 9 || colonna < 1 || colonna > 9) {
            alert("Valori di riga o colonna non corretti!");
        } else {
            let value = document.querySelector("#valore").value;
            insertvalue(riga, colonna, value);
        }
    });

    bottoni[1].addEventListener("click", function() {
        let xhttp = new XMLHttpRequest();

        xhttp.onload = function() {
            let risultato = JSON.parse(xhttp.response).risultato
            spanVittoria.hidden = !risultato;
            spanSconfitta.hidden = risultato;
        }

        xhttp.open("POST", "index.php");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("stato=" + readTable() + "&idPartita=" + getCookie("idPartita"));
    });
}

function createTable(values) {
    const dimension = 9;
    let table = document.querySelector("table");
    table.innerHTML = "";
    for (let i = 0; i < dimension; i++) {
        let row = document.createElement("tr");
        for (let j = 0; j < dimension; j++) {
            let data = document.createElement("td");
            data.textContent = values[i * dimension + j];
            row.appendChild(data);
        }
        table.appendChild(row);
    }
}

function readTable() {
    let string = "";
    let table = document.querySelector("table");
    let rows = table.querySelectorAll("tr");
    rows.forEach(function(row) {
        let values = row.querySelectorAll("td");
        values.forEach(function(value) {
            string += value.textContent;
        });
    });
    return string;
}

function insertvalue(r, c, v) {
    let table = document.querySelector("table");
    let row = table.querySelectorAll("tr")[r - 1];
    let col = row.querySelectorAll("td")[c - 1];
    col.textContent = v;
}

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}