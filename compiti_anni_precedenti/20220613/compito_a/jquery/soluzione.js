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
    let spans = document.querySelectorAll("span");
    let bottoni = document.querySelectorAll("button");
    let btnAggiungi = document.querySelector("input[name='submit']");

    //Nascondi
    form.hidden = true;
    spans.forEach(function(s) {
        s.hidden = true;
    });
    bottoni[1].hidden = true;

    //Bottone Nuova partita
    bottoni[0].addEventListener("click", function() {
        form.hidden = false;

        let xhttp = new XMLHttpRequest();

        xhttp.onload = function() {
            createTable(this.getAllResponseHeaders("data")); //data a caso
        }

        xhttp.open("GET", "index.php");
        xhttp.send();

        form.querySelectorAll("input").forEach(function(input) {
            if (input.tagName.toLowerCase() != "input") {
                input.value = null;
            }
        });
    });

    btnAggiungi.addEventListener("click", function() {

    });

    bottoni[1].addEventListener("click", function() {

    });
}

function createTable(values) {
    const dimension = 9;
    let table = document.getElementById("table");
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