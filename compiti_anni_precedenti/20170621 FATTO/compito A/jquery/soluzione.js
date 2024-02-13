let selectedId = null;
let images;

window.onload = function() {

    let popup = document.querySelector(".popup");
    let sliderImages = document.querySelectorAll(".slider-image img");
    let pictureDiv = document.querySelector(".picture");
    let btnPrev = document.querySelector("#prev");
    let btnSucc = document.querySelector(".foll");
    let btnClose = document.querySelector(".close");
    popup.hidden = true;
    images = new Array(sliderImages.length);


    let i = 0;
    sliderImages.forEach(function(sliderImage) {
        images[i++] = sliderImage;
        sliderImage.addEventListener("click", function() {
            selectImage(pictureDiv, sliderImage);
            popup.hidden = false;
        });
    });

    btnClose.addEventListener("click", function() {
        popup.hidden = true;
        pictureDiv.innerHTML = "";
    });

    btnPrev.addEventListener("click", function() {
        selectedId = selectedId == 0 ? images.length - 1 : selectedId - 1;
        selectImage(pictureDiv, images[selectedId]);
    });

    btnSucc.addEventListener("click", function() {
        selectedId = selectedId == images.length - 1 ? 0 : selectedId + 1;
        selectImage(pictureDiv, images[selectedId]);
    });
}

function selectImage(div, image) {
    selectedId = images.indexOf(image);
    let copyImage = document.createElement("img");
    copyImage.src = image.src;
    copyImage.alt = image.alt;
    div.innerHTML = "";
    div.appendChild(copyImage);
}