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
                img = document.createElement('img'),
                container = document.getElementById('prev-img')
            ;
            img.src = data.thumbnail;
            // img.id = data.id;
            container.insertBefore(img, container.childNodes[0]);
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