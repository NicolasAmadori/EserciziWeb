window.onload = function() {
    let elenchi = document.getElementsByTagName("ul");
    for(let i = 1; i < elenchi.length; i++) {
        elenchi[i].hidden = true;
    }

    document.querySelectorAll("a").forEach(function(link) {
        link.addEventListener("click", function() {
            let prossimo = link.nextElementSibling;
            if(!prossimo) {
                document.querySelector("span").textContent = getHistory(link);
            }
            else if(prossimo.tagName.toLowerCase() === "ul") {
                prossimo.hidden = !prossimo.hidden;
            }
        });
    });
}

function getHistory(link) {
    let padre = link.parentElement;
    while(padre.tagName.toLowerCase() != "main") {
        padre = padre.parentElement;
        if(padre.tagName.toLowerCase() == "li") {
            return getHistory(padre.children[0])  + " - " + link.text;
        }
    }
    return link.text;
}