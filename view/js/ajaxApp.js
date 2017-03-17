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
                //see = img see
                see = document.createElement('img'),
                //div = container pour chaque photos
                divContainer = document.createElement('div')
                ;

            //Path et id de la prev dans la nouvelle balise img
            img.src = '../' + data.thumbnail;
            img.id = data.idMin;

            //Path de l'img trash pour supprimer la prev
            del.className = "del-button";
            del.src = "../webroot/images/app/Trash.ico";
            del.id = "del-button";
            del.title = "Supprimer la photo ?";
            del.onclick = function() { delImg(data.idMin); };

            //Path de l'img see pour afficher l'image en grand
            see.src = "../webroot/images/app/Loupe.png";
            see.className = "see-button";
            see.id = "see-button";
            see.title = "Agrandir ?";
            see.onclick = function () {
                enlargePhoto(data.idMin);
            };

            divContainer.className = "container-prev";
            divContainer.id = "" + data.idMin + "";

            var countElems = document.querySelectorAll('#prev-img .container-prev img');
            if (countElems.length >= 12){
                container.style.overflowX = "scroll";
            } else  {
                container.style.overflowX = "none";
                if (countElems.length == 0){
                    container.style.display = "none";
                }
            }
            container.style.display = "inline-flex";
            container.insertBefore(divContainer,  container.childNodes[0]);

            var containerPrev = document.getElementById(data.idMin);
            containerPrev.insertBefore(img, containerPrev.childNodes[0]);
            containerPrev.insertBefore(see, containerPrev.childNodes[1]);
            containerPrev.insertBefore(del, containerPrev.childNodes[2]);
        }
    };
    var tmp = "img64=" + data;
    xhr.open("post", "uploadAjax", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}
//Probleme car efface meme si click sur image
function delImg(id){
    var xhr = getXMLHttpRequest();
    var imgs = document.getElementById(id);

    xhr.onreadystatechange = function() {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            var closeEnlarge = document.getElementById('container-enlarge'),
                replaceVideo = document.getElementById('myvideo'),
                cacheTakePhoto = document.getElementById('form-cache-photo')
            ;
            if (closeEnlarge != null){
                closeEnlarge.parentNode.removeChild(closeEnlarge);
                replaceVideo.style.display = "inline-block";
                cacheTakePhoto.style.display = 'block';
                cacheTakePhoto.style.cursor = 'pointer';
            }
            imgs.parentNode.removeChild(imgs);
            var countElems = document.querySelectorAll('#prev-img .container-prev img');

            if (countElems.length <= 12){
                var container = document.getElementById('prev-img');
                container.style.overflowX = "hidden";
                if (countElems.length == 0){
                    container.style.display = "none";
                }
            }
        }
    };
    var tmp = "delImg=" + id;
    xhr.open("post", "delAjax", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}

function enlargePhoto(id){
    var xhr = getXMLHttpRequest();

    xhr.onreadystatechange = function() {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText),
                replaceVideo = document.getElementById('booth'),
                closeEnlarge = document.getElementById('container-enlarge'),
                container = document.createElement('div'),
                img = document.createElement('img'),
                close = document.createElement('img'),
                cacheTakePhoto = document.getElementById('form-cache-photo'),
                closeObjFilter = document.getElementById('imgObj')
                ;

            if (closeEnlarge != null){
                closeEnlarge.parentNode.removeChild(closeEnlarge);
            }
            if (closeObjFilter){
                closeObjFilter.style.display = 'none';
            }

            container.className = "container-enlarge";
            container.id = "container-enlarge";
            container.style.display = "inline-block";
            container.style.zIndex = "50";

            img.src = '../' + data.idBig;
            img.className = "img-enlarge";

            close.src = "../webroot/images/app/close2.png";
            close.className = "close-enlarge";
            close.title = "Fermer photo ?";
            close.onclick = function () {
                var close = document.getElementById("container-enlarge"),
                    video = document.getElementById('myvideo'),
                    cacheTakePhoto = document.getElementById('form-cache-photo'),
                    closeObjFilter = document.getElementById('imgObj')
                    ;

                close.style.display = "none";
                close.style.border = "1px solid red";

                video.style.display = "inline-block";

                cacheTakePhoto.style.display = 'block';
                cacheTakePhoto.style.cursor = 'pointer';

                if (closeObjFilter){
                    closeObjFilter.style.display = 'block';
                }
            }

            cacheTakePhoto.style.display = 'none';
            cacheTakePhoto.style.cursor = 'none';
            var replace = document.getElementById('myvideo');
            replace.style.display = "none"
            replaceVideo.insertBefore(container, replaceVideo.childNodes[0]);
            var container = document.getElementById('container-enlarge');

            container.insertBefore(img, container.childNodes[0]);
            container.insertBefore(close, container.childNodes[1]);
        }
    };

    var tmp = "enlargeImg=" + id;
    xhr.open("post", "enlargeAjax", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}