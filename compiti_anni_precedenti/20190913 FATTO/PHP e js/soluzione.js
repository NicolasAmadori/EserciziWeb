window.onload = function() {
    let btn = document.querySelector("button");
    let xhttp = new XMLHttpRequest();

    xhttp.onload = function() {
        let body = document.querySelector("body");
        let table = body.querySelector("table");
        if (table) {
            body.removeChild(table);
        }
        body.appendChild(generaTabella(JSON.parse(xhttp.response)));
    }
    xhttp.open("GET", "index.php");
    xhttp.send();

    btn.addEventListener("click", function(event) {
        event.preventDefault();
        let inputs = document.querySelectorAll("input");
        params = "";
        inputs.forEach(function(input) {
            if (params != "") {
                params += "&";
            }
            params += input.id + "=" + input.value;
        });
        xhttp.open("POST", "index.php");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(params);

        xhttp.open("GET", "index.php");
        xhttp.send();
    });
}

function generaTabella(personaggi) {
    let table = document.createElement("table");
    let headersRow = document.createElement("tr");
    let chiavi = Object.keys(personaggi[0]);
    chiavi.forEach(function(chiave) {
        let header = document.createElement("th");
        header.textContent = chiave;
        header.id = chiave;
        header.scope = "col";
        headersRow.appendChild(header);
    });
    table.appendChild(headersRow);
    personaggi.forEach(function(personaggio) {
        let row = document.createElement("tr");
        chiavi.forEach(function(chiave) {
            let cell = document.createElement("td");
            cell.textContent = personaggio[chiave];
            cell.headers = chiave;
            row.appendChild(cell);
        });
        table.appendChild(row);
    });

    return table;
}