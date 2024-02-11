/*
•	Al click sul bottone, deve essere visualizzata nella seconda tabella lo stato corrente della matrice. Se la tabella è già presente, va sostituita. NB: questo vi serve per controllare se la matrice e la prima tabella sono “allineate”.
*/
window.onload = function() {
    let primaTabella = document.querySelectorAll("table")[0];
    let secondaTabella = document.querySelectorAll("table")[1];
    let bottone = document.querySelector("button");

    let matrice = new Array(6);
    for (let i = 0; i < matrice.length; i++) {
        matrice[i] = new Array(7);
        let row = document.createElement("tr");
        for (let j = 0; j < matrice[i].length; j++) {
            let val = Math.floor(Math.random() * 2) + 1;
            let data = document.createElement("td");
            matrice[i][j] = data.textContent = val;
            data.style.backgroundColor = val == 1 ? "red" : "blue";
            data.style.color = "white";
            row.appendChild(data);

            data.addEventListener("click", function() {
                data.textContent = 0;
                data.style.backgroundColor = null;
                matrice[i][j] = 0;
            });
        }
        primaTabella.appendChild(row);
    }

    bottone.addEventListener("click", function() {
        secondaTabella.innerHTML = "";
        for (let i = 0; i < matrice.length; i++) {
            let row = document.createElement("tr");
            for (let j = 0; j < matrice[i].length; j++) {
                let data = document.createElement("td");
                matrice[i][j] = data.textContent = matrice[i][j];
                data.style.backgroundColor = matrice[i][j] == 1 ? "red" : matrice[i][j] == 2 ? "blue" : null;
                data.style.color = "white";
                row.appendChild(data);
            }
            secondaTabella.appendChild(row);
        }
    });
}