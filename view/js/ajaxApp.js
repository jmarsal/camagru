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
            // console.log(xhr.responseText);
            var data = JSON.parse(xhr.responseText),
                //img = new prev
                img = document.createElement('img'),
                //del = img de trash
                del = document.createElement('img'),
                //container = le container de toutes les prev
                container = document.getElementById('prev-img')
            ;
            //Path et id de la prev dans la nouvelle balise img
            img.src = data.thumbnail;
            img.id = data.id;

            //Path de l'img trash pour supprimer la prev
            del.src = "../webroot/images/app/trash.png";
            del.className = "del-button";
            del.id = data.id;
            del.title = "Supprimer la photo ?";
            del.onclick = delImg(data);

            container.style.display = "inline-flex";
            //creer div container-prev et onclick delImg dessus
            container.insertBefore(img, container.childNodes[0]);
            container.insertBefore(del,  container.childNodes[1]);
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
    xhr.open("post", "delAjax", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}