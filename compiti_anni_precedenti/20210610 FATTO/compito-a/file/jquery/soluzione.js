window.onload = function() {
    let btn = document.querySelector("button");

    btn.addEventListener("click", function() {
        let xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            let main = document.querySelector("main");
            let data = JSON.parse(xhttp.response)["data"];
            for (let i = 0; i < data.length; i++) {
                main.appendChild(creaDiv(data[i]));
            }
        }
        xhttp.open("GET", "data.json");
        xhttp.send();
    });
}

function creaDiv(pokemon) {
    let div = document.createElement("div");
    let elenco = document.createElement("ul");
    for (let prop in pokemon) {
        let item = document.createElement("li");
        item.textContent = prop + ": " + pokemon[prop];
        elenco.appendChild(item);
    }
    let btnUp = document.createElement("button");
    let btnDown = document.createElement("button");
    btnUp.textContent = "Up";
    btnDown.textContent = "Down";

    btnUp.addEventListener("click", function() {
        let previous = div.previousSibling;
        if (previous) {
            document.querySelector("main").insertBefore(div, previous);
        }
    });

    btnDown.addEventListener("click", function() {
        let next = div.nextSibling;
        if (next) {
            document.querySelector("main").insertBefore(div, next.nextSibling);
        }
    });

    div.appendChild(elenco);
    div.appendChild(btnUp);
    div.appendChild(btnDown);
    return div;
}