/**
 * Created by jmarsal on 3/7/17.
 */

function getSrcImg(data) {
    finish = document.getElementById('form-cache-photo'),
        finish.addEventListener('click', function(ev) {
            ajaxPhoto(data);
        }, false);
}

function ajaxPhoto(data) {
    var xhr = getXMLHttpRequest();
    xhr.onreadystatechange = function() {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText),
                //container = le container de toutes les prev
                container = document.getElementById('prev-img'),
                //img = new prev
                img = document.createElement('img'),
                //del = img de trash
                del = document.createElement('img'),
                div = document.createElement('div')
                ;

            //Path et id de la prev dans la nouvelle balise img
            img.src = data.thumbnail;
            img.id = data.idMin;

            //Path de l'img trash pour supprimer la prev
            del.src = "../webroot/images/app/trash.png";
            del.className = "del-button";
            del.id = data.idMin;
            del.title = "Supprimer la photo ?";

            div.innerHTML += '<div class="container-prev" id="' + del.id + '" onclick="delImg(this)"></div>';

            container.style.display = "inline-flex";
            container.insertBefore(div,  container.childNodes[0]);
            containerPrev = document.getElementById(del.id);
            containerPrev.insertBefore(img, containerPrev.childNodes[0]);
            containerPrev.insertBefore(del, containerPrev.childNodes[1]);
        }
    };
    var tmp = "img64=" + data;
    xhr.open("post", "uploadAjax", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}

function delImg(element){
    var xhr = getXMLHttpRequest();

    xhr.onreadystatechange = function() {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            element.parentNode.removeChild(element);
        }
    };
    var tmp = "delImg=" + element.id;
    console.log(element.id);
    xhr.open("post", "delAjax", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}