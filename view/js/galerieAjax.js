/**
 * Created by jbmar on 21/03/2017.
 */

function submitComment(id) {
    var xhr = getXMLHttpRequest(),
        getInput = document.getElementById("input-comment-text" + id).value //recupere l'imput
    ;

    xhr.onreadystatechange = function () {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText),
                containerDiv = document.getElementById("container-comments" + id),
                spanComment = document.createElement('span'),
                spanDate = document.createElement('span'),
                spanLogin = document.createElement('span'),

                containerInteract = document.createElement("div"),
                interactsDiv = document.createElement("div"),
                dateDiv = document.createElement("div"),
                loginDiv = document.createElement("div"),
                commentsDiv = document.createElement("div"),
                hrDiv = document.createElement("div"),
                hr = document.createElement('hr'),
                date = new Date(data.info.date),
                formatDate = reformatDate(date),
                getInput = document.getElementById("input-comment-text" + id),
                nbcomments = document.getElementById("comment-span" + id)
                ;

                var getLogColorsPreComment = containerDiv.lastChild;

                if (getLogColorsPreComment){ // recupere le dernier login et sa position (left or right)
                    var preSpanLog = getLogColorsPreComment.firstChild.firstChild.firstChild.innerHTML;
                    var moduloDivSpan = getLogColorsPreComment.firstChild.style.left;

                    moduloDivSpan = (moduloDivSpan == '-25%') ? 1 : 0;
                    preSpanLog = preSpanLog.substr(0, preSpanLog.length - 3);
                } else {
                    moduloDivSpan = 0;
                    preSpanLog = data.info.login;
                    whichColor = 0;
                }


            // Recuperer le comment precedent si il existe, donc le login + la couleur + modulo
            // setColorsGetModulo(logins, i, preSpanLog, moduloDivSpan, id)
            setColorsGetModulo(data.info, containerDiv.length, preSpanLog, moduloDivSpan, id);
            setHr(hrDiv, hr, modulo);
            setTopPartComment(interactsDiv, id,  color1, modulo);
            setDateCreated(dateDiv, spanDate, formatDate, id);
            if (!containerDiv){
                setBottomPartComment(commentsDiv, spanComment, data.info.comment, 0, id,  color1, color2, modulo);
                setLoginDiv(loginDiv, spanLogin, data.info.login, id, null);
            } else {
                setBottomPartComment(commentsDiv, spanComment, data.info.comment, null, id,  color1, color2, modulo);
                setLoginDiv(loginDiv, spanLogin, data.info.login, id, null);
            }
            containerDiv.style.display = "block";
            setElementsInDocument(loginDiv, spanLogin, dateDiv, spanDate, interactsDiv, commentsDiv,
                spanComment, hrDiv, hr,  containerInteract, containerDiv, containerDiv.length);
            containerDiv.scrollTop = containerDiv.scrollHeight + 100;
            getInput.value = "";
            nbcomments.innerHTML = data.nbComments;
        }
    };

    var tmp = "idPostGalerie=" + id + "&contentComment=" + getInput;
    xhr.open("post", "getNewCommentAjaxGalerie", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}

function setElementsInDocument(loginDiv, spanLogin, dateDiv, spanDate, interactsDiv, commentsDiv,
                               spanComment, hrDiv, hr, containerInteract, containerDiv, i){
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

function setBottomPartComment(commentsDiv, spanComment, comments, i, id) {
    // Ajouter une classe left ou right en fonction du modulo
    commentsDiv.className = "comments";
    commentsDiv.id = "comments" + id;
    commentsDiv.style.background = "rgba(" + color2 + ", 0.6)";
    commentsDiv.style.borderLeft = "2px solid " + color1 + "";
    commentsDiv.style.borderRight = "2px solid " + color2 + "";
    commentsDiv.style.borderBottom = "6px solid " + color2 + "";
    // commentsDiv.style.width = "50%";
    commentsDiv.style.textAlign = "left";
    if (modulo == 0){
        commentsDiv.style.marginLeft = "0%";
        commentsDiv.style.borderRadius = "0px 0px 20px 0px";
    } else {
        commentsDiv.style.marginLeft = "507px";
        commentsDiv.style.borderRadius = "0px 0px 0px 20px";
    }
    spanComment.style.display = "relative";
    spanComment.className = "span-comment";
    if (i != null){
        spanComment.innerHTML = comments[i + 1].userComment;
    } else {
        spanComment.innerHTML = comments;
    }
}

function setLoginDiv(loginDiv, spanLogin, logins, id, i){
    loginDiv.className = "login-comments";
    loginDiv.id = "login-comments" + id;
    loginDiv.style.marginLeft = "-405px";
    spanLogin.style.position = "relative";
    spanLogin.style.left = "70px";
    if (i != null){
        spanLogin.innerHTML = ""+logins[i] + " : ";
    } else {
        spanLogin.innerHTML = ""+logins + " : ";
    }
}

function setColorsGetModulo(logins, i, preSpanLog, moduloDivSpan, id){
    // Ajouter une classe left ou right en fonction du modulo
    // alert(id);

    if (logins && logins[i - 1] && !preSpanLog){
        var log = logins[i - 1],
            container = document.getElementById('container_message' + id)
        ;

        console.log(container);

        if (log !== logins[i]){
            whichColor = (whichColor == 0) ? 1 : 0;
            if (whichColor == 0){
                modulo = 0;
                color1 = "250, 118, 33";
                color2 = "243, 146, 55";
                whichColor = 0;
            } else {
                modulo = 1;
                color1 = "115, 115, 104";
                color2 = "47, 79, 79";
                whichColor = 1;
            }
        } else if (log === logins[i]) {
            if (whichColor == 0){
                modulo = 0;
                color1 = "250, 118, 33";
                color2 = "243, 146, 55";
                whichColor = 0;
            } else {
                modulo = 1;
                color1 = "115, 115, 104";
                color2 = "47, 79, 79";
                whichColor = 1;
            }
        }
    } else if (logins && preSpanLog){
        if (preSpanLog !== logins){
            whichColor = (moduloDivSpan == 0) ? 1 : 0;
            if (whichColor == 1){
                modulo = 0;
                color1 = "250, 118, 33";
                color2 = "243, 146, 55";
                whichColor = 0;
            } else {
                modulo = 1;
                color1 = "115, 115, 104";
                color2 = "47, 79, 79";
                whichColor = 1;
            }
        } else if (logins === preSpanLog) {
            if (whichColor == 0){
                modulo = 0;
                color1 = "250, 118, 33";
                color2 = "243, 146, 55";
                whichColor = 0;
            } else {
                modulo = 1;
                color1 = "115, 115, 104";
                color2 = "47, 79, 79";
                whichColor = 1;
            }
        }
    }
    else {
        if ((i % 2) == 0 || (whichColor && whichColor == 0)){
            if (container){
                if (container.classList.contains('right')){
                    container.classList.remove('right');
                }
                container.classList.add('left');
            }
            modulo = 0;
            color1 = "250, 118, 33";
            color2 = "243, 146, 55";
            whichColor = 0;
        } else if ((i % 2) == 1 || (whichColor && whichColor == 1)){
            if (container){
                if (container.classList.contains('left')){
                    container.classList.remove('left');
                }
                container.classList.add('right');
            }
            modulo = 1;
            color1 = "115, 115, 104";
            color2 = "47, 79, 79";
            whichColor = 1;
        }
    }
    return modulo + color1 + color2 + whichColor;
}

function setTopPartComment(interactsDiv, id,  color1, modulo){
    // Ajouter une classe left ou right en fonction du modulo
    interactsDiv.className = "container-interact";
    interactsDiv.id = "container-interact" + id;
    interactsDiv.style.background = "rgba(" + color1 + ",0.6)";
    interactsDiv.style.bottom = "-10px";
    // interactsDiv.style.width = "50%";
    interactsDiv.style.display = "inline-block";
    // interactsDiv.style.width = "100%";
    if (modulo == 0){
        interactsDiv.style.left = "-239px";
        interactsDiv.style.borderRadius = "0px 20px 0px 0px";
    } else {
        interactsDiv.style.left = "268px";
        interactsDiv.style.borderRadius = "20px 0px 0px 0px";
    }
}

function setContainerAllComments(containerInteract, id) {
    containerInteract.className = "container_message";
    containerInteract.id = "container_message" + id;
}

function setHr(hrDiv, hr, modulo) {
    // Ajouter une classe left ou right en fonction du modulo
    hrDiv.className = "hr-div";
    hrDiv.position = "relative";
    hrDiv.style.marginBottom = "1.7%";
    // hrDiv.style.width = "50%";
    if (modulo == 0){
        hrDiv.style.marginLeft = "0px";
    } else {
        hrDiv.style.marginLeft = "507px";
    }
    hr.style.backgroundColor = "darkgrey";
    hr.style.color = "darkgrey";
    hr.height = '1px';
}

function removeContainerComments(id){
    var remove = document.getElementById("container-comments" + id),
        galerie = document.getElementById("galerie-login" + id),
        newContainer = document.createElement("div")
        ;
    newContainer.className = "container-comments";
    newContainer.id = "container-comments" + id;
    remove.parentNode.removeChild(remove);
    galerie.insertBefore(newContainer, galerie.lastElementChild.previousSibling);
}