window.onload = function() {
    let main = document.querySelector("main");
    let table = document.createElement("table");
    table.id = "numeri";

    let row = table.insertRow();
    for (let i = 0; i < 9; i++) {
        let cell = row.insertCell(i);
        cell.textContent = i + 1;
    }
    main.appendChild(table);

    let cellaSelezionata = null;
    let tabellone = document.querySelector(".tabellone");
    tabellone.querySelectorAll("td").forEach(function(cella) {
        cella.addEventListener("click", function() {
            cellaSelezionata = cellaSelezionata == cella ? null : cella;
            tabellone.querySelectorAll("td").forEach(function(c) {
                c.style.backgroundColor = c == cellaSelezionata ? "#cacaca" : "";
            });
        });
    });

    let log = document.querySelector(".log");
    let numeri = document.querySelector("#numeri");
    numeri.querySelectorAll("td").forEach(function(cella) {
        cella.addEventListener("click", function() {
            if (!cellaSelezionata) {
                log.textContent = "Cella non selezionata";
            } else {
                log.textContent = "Numero inserito correttamente";
                cellaSelezionata.textContent = cella.textContent;
                cellaSelezionata.click();
            }
        });
    });
}