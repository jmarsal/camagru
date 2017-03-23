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
        interactsDiv = document.getElementById("container-interact" + id),
        dateDiv = document.getElementById("date-comments" + id),
        loginDiv = document.getElementById("login-comments" + id),
        commentsDiv = document.getElementById("comments" + id),
        newcommentsDiv = document.getElementById("new-comments-container" + id)
        ;

    xhr.onreadystatechange = function () {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText),
                comments = data.comments,
                logins = data.logins
            ;

            console.log('id_post = '+ id);
            console.log(logins);
            //Recuperer en json l'auteur, la date, le commentaire

            if (newcommentsDiv.style.display != "block"){
                //
                newcommentsDiv.style.display = "block";

                for (i = 0; i < comments.length; i++){
                    if (comments[i].userComment != null){
                        var spanComment = document.createElement('span'),
                            spanDate = document.createElement('span'),
                            spanLogin = document.createElement('span'),
                            hr = document.createElement('hr'),
                            date = new Date(comments[i].created)
                            ;

                        containerDiv.style.display = "block";

                        interactsDiv.style.display = "inline-block";
                        interactsDiv.style.width = "100%";

                        loginDiv.style.marginLeft = "-470px";

                        spanDate.style.position = "relative";
                        spanDate.style.right = "60px";
                        spanDate.innerHTML = date;

                        spanLogin.style.position = "relative";
                        spanLogin.style.left = "70px";
                        //Probleme de recup d'id envoyer dans le json...
                        spanLogin.innerHTML = ""+logins[i] + " : ";

                        spanComment.style.display = "relative";
                        spanComment.innerHTML = "Cool !!";

                        loginDiv.insertBefore(spanLogin, loginDiv[0]);
                        dateDiv.insertBefore(spanDate, dateDiv[0]);

                        interactsDiv.insertBefore(loginDiv, interactsDiv[0]);
                        interactsDiv.insertBefore(dateDiv, interactsDiv[1]);

                        commentsDiv.insertBefore(spanComment, commentsDiv[0]);

                        containerDiv.insertBefore(interactsDiv, containerDiv[0]);
                        containerDiv.insertBefore(hr, containerDiv[1]);
                        containerDiv.insertBefore(commentsDiv, containerDiv[2]);
                    }
                }
            } else {
                containerDiv.style.display = "none";
                newcommentsDiv.style.display = "none";
            }

        }
    };
    var tmp = "commentsGalerie=" + id;
    xhr.open("post", "getCommentsAjaxGalerie", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}