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
    var xhr = getXMLHttpRequest()
        ;

    xhr.onreadystatechange = function () {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText),
                containerDiv = document.getElementById("container-comments" + id),
                newcommentsDiv = document.getElementById("new-comments-container" + id),
                comments = data.comments,
                logins = data.logins
            ;

            if (newcommentsDiv.style.display != "block"){
                newcommentsDiv.style.display = "block";

                for (i = 0; i < comments.length; i++){
                    if ((i % 2) != 0){
                        modulo = 0;
                        color1 = "250, 118, 33";
                        color2 = "243, 146, 55";
                    } else {
                        modulo = 1;
                        color1 = "115, 115, 104";
                        color2 = "47, 79, 79";
                    }

                    if (comments[i].userComment != null){
                        var spanComment = document.createElement('span'),
                            spanDate = document.createElement('span'),
                            spanLogin = document.createElement('span'),
                            hr = document.createElement('hr'),
                            date = new Date(comments[i].created),
                            containerInteract = document.createElement("div"),
                            interactsDiv = document.createElement("div"),
                            dateDiv = document.createElement("div"),
                            loginDiv = document.createElement("div"),
                            commentsDiv = document.createElement("div"),
                            hrDiv = document.createElement("div")
                            ;

                        var formatDate = convertDate(date);
                        var formatHours = convertHours(date);
                        formatDate = formatDate + ' à ' + formatHours;

                        hr.style.backgroundColor = "darkgrey";
                        hr.style.color = "darkgrey";
                        // hr.style.marginTop = "-1%";
                        hrDiv.className = "hr-div";
                        hrDiv.style.marginBottom = "1.7%";
                        hrDiv.style.width = "50%";
                        if (modulo == 0){
                            hrDiv.style.marginLeft = "0%";
                        } else {
                            hrDiv.style.marginLeft = "50%";
                        }

                        containerInteract.className = "container_message";
                        containerInteract.id = "container_message" + id;

                        interactsDiv.className = "container-interact";
                        interactsDiv.id = "container-interact" + id;
                        interactsDiv.style.background = "rgba(" + color1 + ",0.6)";
                        interactsDiv.style.marginBottom = "-1.1%";
                        interactsDiv.style.width = "50%";
                        if (modulo == 0){
                            interactsDiv.style.left = "-25%";
                            interactsDiv.style.borderRadius = "0px 20px 0px 0px";
                        } else {
                            interactsDiv.style.left = "25%";
                            interactsDiv.style.borderRadius = "20px 0px 0px 0px";
                        }

                        dateDiv.className = "date-comments";
                        dateDiv.id = "date-comments" + id;

                        loginDiv.className = "login-comments";
                        loginDiv.id = "login-comments" + id;

                        commentsDiv.className = "comments";
                        commentsDiv.id = "comments" + id;
                        commentsDiv.style.background = "rgba(" + color2 + ", 0.6)";
                        commentsDiv.style.borderLeft = "2px solid " + color1 + "";
                        commentsDiv.style.borderRight = "2px solid " + color2 + "";
                        commentsDiv.style.borderBottom = "6px solid " + color2 + "";
                        commentsDiv.style.width = "50%";
                        commentsDiv.style.textAlign = "left";
                        if (modulo == 0){
                            commentsDiv.style.marginLeft = "0%";
                            commentsDiv.style.borderRadius = "0px 0px 20px 0px";
                        } else {
                            commentsDiv.style.marginLeft = "50%";
                            commentsDiv.style.borderRadius = "0px 0px 0px 20px";
                        }

                        containerDiv.style.display = "block";

                        interactsDiv.style.display = "inline-block";
                        interactsDiv.style.width = "100%";

                        loginDiv.style.marginLeft = "-470px";

                        spanDate.style.position = "relative";
                        spanDate.style.right = "60px";
                        spanDate.innerHTML = "le " + formatDate;

                        spanLogin.style.position = "relative";
                        spanLogin.style.left = "70px";
                        //Probleme de recup d'id envoyer dans le json...
                        spanLogin.innerHTML = ""+logins[i] + " : ";

                        spanComment.style.display = "relative";
                        spanComment.innerHTML = comments[i].userComment;

                        loginDiv.insertBefore(spanLogin, loginDiv[0]);
                        dateDiv.insertBefore(spanDate, dateDiv[0]);

                        interactsDiv.insertBefore(loginDiv, interactsDiv[0]);
                        interactsDiv.insertBefore(dateDiv, interactsDiv[1]);

                        commentsDiv.insertBefore(spanComment, commentsDiv[0]);

                        hrDiv.insertBefore(hr, hrDiv[0]);

                        containerInteract.insertBefore(interactsDiv, containerInteract[0]);
                        containerInteract.insertBefore(hrDiv, containerInteract[1]);
                        containerInteract.insertBefore(commentsDiv, containerInteract[2]);

                        containerDiv.insertBefore(containerInteract, containerDiv[i]);
                    }
                }
            } else {
                // containerDiv.style.display = "none";
                newcommentsDiv.style.display = "none";

                var remove = document.getElementById("container-comments" + id),
                    galerie = document.getElementById("galerie-login" + id),
                    newContainer = document.createElement("div")
                ;
                newContainer.className = "container-comments";
                newContainer.id = "container-comments" + id;
                remove.parentNode.removeChild(remove);
                galerie.insertBefore(newContainer, galerie.lastElementChild.previousSibling);
            }

        }
    };
    var tmp = "commentsGalerie=" + id;
    xhr.open("post", "getCommentsAjaxGalerie", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}

function convertDate(inputFormat) {
    function pad(s) { return (s < 10) ? '0' + s : s; }
    var d = new Date(inputFormat);
    return [pad(d.getDate()), pad(d.getMonth()+1), d.getFullYear()].join('/');
}

function convertHours(inputFormat) {
    function pad(s) { return (s < 10) ? '0' + s : s; }
    var d = new Date(inputFormat);
    return [d.getHours(), d.getMinutes(), d.getSeconds()].join(':');
}