window.onload = function() {
    let btn = document.querySelector("button");
    let inputDiv = btn.parentElement.querySelector("div");
    let input = document.querySelector("input");


    btn.addEventListener("click", function() {
        inputDiv.innerHTML = "";
        let nCol = input.value;
        for (let i = 0; i < nCol; i++) {
            let input = document.createElement("input");
            input.type = "number";
            inputDiv.appendChild(input);
        }

        let newBtn = document.createElement("button");
        newBtn.textContent = "Genera Colonne";
        newBtn.addEventListener("click", function() {
            let inputValori = inputDiv.querySelectorAll("input");
            let somma = 0;
            inputValori.forEach(function(input) {
                somma += parseInt(input.value);
            });
            if (somma == 12) {
                let mainDiv = document.querySelector(".container-fluid");
                let row = document.createElement("div");
                row.classList.add("row");
                inputValori.forEach(function(input) {
                    let d = document.createElement("div");
                    d.classList.add("col-" + input.value);
                    row.appendChild(d);
                });
                mainDiv.appendChild(row);
                inputDiv.innerHTML = "";
            }
        });

        inputDiv.appendChild(newBtn);
    });
}