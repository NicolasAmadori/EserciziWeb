window.onload = function() {
    let rigaGiorni = document.querySelector("tr");
    let headers = document.querySelectorAll("th");

    headers.forEach(function(th) {
        th.addEventListener("click", function() {
            if(rigaGiorni.contains(th)) {
                let headersColonna = rigaGiorni.querySelectorAll("th");
                let colonnaCliccata;
                for(colonnaCliccata = 0; colonnaCliccata < headersColonna.length; colonnaCliccata++) {
                    if(headersColonna[colonnaCliccata] == th) {
                        break;
                    }
                }
                let righe = document.querySelectorAll("tr");
                for(let j = 1; j < righe.length; j++) {
                    let cella = righe[j].querySelectorAll("td")[colonnaCliccata];
                    switch(cella.style.backgroundColor) {
                        case "":
                            cella.style.backgroundColor = "rgb(255, 0, 0)";
                            break;
                        case "rgb(0, 255, 0)":
                            cella.style.backgroundColor = "rgb(0, 0, 255)";
                            break;
                        case "rgb(255, 0, 0)":
                            cella.style.backgroundColor = "";
                        break;
                        case "rgb(0, 0, 255)":
                            cella.style.backgroundColor = "rgb(0, 255, 0)";
                        break;
                    }
                }
            }
            else {
                let riga = th.parentElement;
                riga.querySelectorAll("td").forEach(function(td) {
                    switch(td.style.backgroundColor) {
                        case "":
                            td.style.backgroundColor = "rgb(0, 255, 0)";
                            break;
                        case "rgb(0, 255, 0)":
                            td.style.backgroundColor = "";
                            break;
                        case "rgb(255, 0, 0)":
                            td.style.backgroundColor = "rgb(0, 0, 255)";
                        break;
                        case "rgb(0, 0, 255)":
                            td.style.backgroundColor = "rgb(255, 0, 0)";
                        break;
                    }
                });
            }
        });
    });
}