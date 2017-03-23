/**
 * Created by jbmar on 21/03/2017.
 */

function delImgDb(id) {
    var xhr = getXMLHttpRequest();

    xhr.onreadystatechange = function() {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            var remove = document.getElementById(id);

            if (remove) {
                remove.parentNode.removeChild(remove);
            }
        }
    };
    var tmp = "delImgGalerie=" + id;
    xhr.open("post", "delAjaxGalerie", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}

function likeImg(id) {
    var xhr = getXMLHttpRequest(),
        likeImg = document.getElementById("like-galerie" + id)
        ;

    xhr.onreadystatechange = function() {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText),
                likeSpan = document.getElementById("like-span" + id)
            ;
            if (likeImg) {
                if (likeImg.src.indexOf("none") == -1){
                    var replaceLike = likeImg.src.replace('like', 'nonelike');
                    likeImg.title = "j'aime";
                } else {
                    var replaceLike = likeImg.src.replace('nonelike', 'like');
                    likeImg.title = "j'aime plus";
                }
                likeImg.src = replaceLike;
                if (likeSpan){
                    likeSpan.firstChild.nodeValue = data.nbLike;
                }
            }
        }
    };
    var tmp = "likeImgGalerie=" + id;
    xhr.open("post", "likeAjaxGalerie", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}

function commmentsClick(id) {
    var xhr = getXMLHttpRequest(),
        containerDiv = document.getElementById("container-comments" + id),
        dateDiv = document.getElementById("date-comments" + id),
        loginDiv = document.getElementById("login-comments" + id),
        commentsDiv = document.getElementById("comments" + id)
        ;

    xhr.onreadystatechange = function () {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            //Recuperer en json l'auteur, la date, le commentaire
            var spanComment = document.createElement('span'),
                spanDate = document.createElement('span'),
                spanLogin = document.createElement('span')
            ;

            containerDiv.style.display = "block";
            containerDiv.style.paddingTop = "15px";
            containerDiv.style.paddingBottom = "15px";
            dateDiv.style.marginLeft = "-470px";
            // loginDiv.style.margin = "0% auto";
            // commentsDiv.style.margin = "0% auto";

            spanDate.style.display = "relative";
            // spanDate.style.margin = "0% auto";
            spanDate.innerHTML = "le 23/03/2017 ";

            spanLogin.style.display = "relative";
            // spanLogin.style.margin = "0% auto";
            spanLogin.innerHTML = "elodie : ";

            spanComment.style.display = "relative";
            // spanComment.style.margin = "0% auto";
            spanComment.innerHTML = "Cool !!";

            containerDiv.insertBefore(spanDate, containerDiv[2]);
            containerDiv.insertBefore(spanLogin, containerDiv[2]);
            containerDiv.insertBefore(spanComment, containerDiv[2]);
        }
    };
    var tmp = "commentsGalerie=click";
    xhr.open("post", "commentsAjaxGalerie", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}