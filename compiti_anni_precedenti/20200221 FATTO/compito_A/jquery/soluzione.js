window.onload = function() {
    let button = document.querySelector("button");
    let p = document.querySelector("p");
    let table = document.querySelector("table");

    button.addEventListener("click", function() {
        p.textContent = "Caricamento dati in corso...";

        let xhttp = new XMLHttpRequest();

        xhttp.onload = function() {
            let data = JSON.parse(xhttp.response);
            let chiavi = Object.keys(data[0]);
            chiavi.push("azione")
            table.innerHTML = "";

            let thead = document.createElement("thead");
            let headersRow = document.createElement("tr");
            chiavi.forEach(function(chiave) {
                let header = document.createElement("th");
                header.textContent = chiave;
                header.id = chiave;
                header.scope = "col";
                headersRow.appendChild(header);
            });
            thead.appendChild(headersRow)
            table.appendChild(thead);

            let tbody = document.createElement("tbody");
            for (let i = 0; i < data.length; i++) {
                let row = document.createElement("tr");
                chiavi.forEach(function(chiave) {
                    let cell = document.createElement("td");
                    if (chiave == "colore_preferito") {
                        cell.style.backgroundColor = rgb2hex(data[i][chiave]);
                    } else if (chiave == "azione") {
                        let btn = document.createElement("button");
                        btn.textContent = "Modifica riga";
                        btn.addEventListener("click", function() {
                            buttonClicked(btn);
                        });
                        cell.appendChild(btn);
                    } else {
                        cell.textContent = data[i][chiave];
                    }

                    cell.headers = chiave;

                    row.appendChild(cell);
                });

                tbody.appendChild(row);
            }
            table.appendChild(tbody);
            p.textContent = "Caricamento dei dati avvenuto con successo.";
        }

        xhttp.open("GET", "sw_a.json");
        xhttp.send();
    });
}

function rgb2hex(orig) {
    let rgb = orig.replace(/\s/g, '').match(/^rgba?\((\d+),(\d+),(\d+)/i);
    return (rgb && rgb.length === 4) ? "#" +
        ("0" + parseInt(rgb[1], 10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[2], 10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[3], 10).toString(16)).slice(-2) : orig;
}

function buttonClicked(btn) {
    if (btn.textContent == "Modifica riga") {
        btn.textContent = "Conferma";
        let tr = btn.parentNode.parentNode;
        let tds = tr.querySelectorAll("td");
        tds.forEach(function(td) {
            if (td.headers != "azione") {
                let input = document.createElement("input");
                if (td.headers == "email") {
                    input.type = "email";
                } else if (td.headers == "colore_preferito") {
                    input.type = "color";
                    td.style.backgroundColor = "";
                } else {
                    input.type = "text";
                }
                td.innerHTML = "";
                td.appendChild(input);
            }
        });
    } else {
        btn.textContent = "Modifica riga";
        let tr = btn.parentNode.parentNode;
        let tds = tr.querySelectorAll("td");
        tds.forEach(function(td) {
            if (td.headers != "azione") {
                let input = td.querySelector("input");
                td.removeChild(input);
                if (td.headers == "colore_preferito") {
                    td.style.backgroundColor = input.value;
                } else {
                    td.textContent = input.value;
                }
            }
        });
    }
}