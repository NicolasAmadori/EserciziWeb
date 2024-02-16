let persons = [];

window.onload = function() {
    let btn = document.querySelector("button");
    let inputNome = document.querySelector("input[name='nome']");
    let inputCognome = document.querySelector("input[name='cognome']");
    let inputDataDiNascita = document.querySelector("input[name='data_nascita']");
    
    btn.addEventListener("click", function(event) {
        event.preventDefault();
        if(inputNome.value.length >= 2 && inputCognome.value.length >= 2 && inputDataDiNascita.value != "") {
            let p = new Persona(inputNome.value, inputCognome.value, inputDataDiNascita.value);
            p.infoPersonaConsole();
            p.infoPersonaDOM();
            persons.push(p);
            inputNome.value = "";
            inputCognome.value = "";
            inputDataDiNascita.value = "";
        }
        else {
            alert("Errore! Dati inseriti non validi");
        }
    });
}

class Persona {
    constructor(nome, cognome, dataDiNascita) {
      this.nome = nome;
      this.cognome = cognome;
      this.dataDiNascita = dataDiNascita;
    }

    infoPersonaConsole() {
        console.log("nome: " + this.nome + " cognome: " + this.cognome + " dataDiNascita: " + this.dataDiNascita);
    }

    infoPersonaDOM() {
        let person = this;
        let people = document.querySelector(".people");
        let card = document.createElement("div");
        card.classList.add("card");
        let h2 = document.createElement("h2");
        h2.textContent = this.nome + " " + this.cognome;
        let p = document.createElement("p");
        p.textContent = this.dataDiNascita;
        let span = document.createElement("span");
        span.textContent = "x";

        span.addEventListener("click", function() {
            people.removeChild(card);
            let i = persons.indexOf(person);
            persons.splice(i,1);
        });

        card.appendChild(h2);
        card.appendChild(p);
        card.appendChild(span);
        people.appendChild(card);
    }

    deleteFromArray() {
        console.log(this);
        let i = persons.indexOf(this);
        persons.splice(i,1);
    }
  }