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
                nbcomments = document.getElementById("comment-span" + id),
                lastSetting = Array,
                loginPrec
                ;

                var getLogColorsPreComment = containerDiv.lastChild;

                if (getLogColorsPreComment){ // recupere le dernier login et sa position (left or right)
                    var preSpanLog = getLogColorsPreComment.firstChild.firstChild.firstChild.innerHTML;

                    loginPrec = preSpanLog.substr(0, preSpanLog.length - 3);
                    lastSetting = getModulo(data.logSession, loginPrec, data.logSession, lastSetting, containerDiv.length);

                } else {
                    loginPrec = data.info.login;
                    lastSetting = getModulo(data.logSession, loginPrec, data.logSession, lastSetting, 0);
                }

            setHr(hrDiv, hr, lastSetting['modulo']);
            setContainerAllComments(containerInteract, id, lastSetting['modulo']);
            setTopPartComment(interactsDiv, id,  lastSetting['color1'], lastSetting['modulo']);
            setDateCreated(dateDiv, spanDate, formatDate, id);
            if (!containerDiv){
                setBottomPartComment(commentsDiv, spanComment, data.info.comment, 0, id,  lastSetting);
                setLoginDiv(loginDiv, spanLogin, data.info.login, id, null);
            } else {
                setBottomPartComment(commentsDiv, spanComment, data.info.comment, null, id,  lastSetting);
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

function setBottomPartComment(commentsDiv, spanComment, comments, i, id, lastSettings) {
    commentsDiv.className = "comments";
    commentsDiv.id = "comments" + id;
    if (lastSettings['modulo'] == 0){
        commentsDiv.classList.add('left');
    } else {
        commentsDiv.classList.add('right');
    }
    spanComment.className = "span-comment";
    if (i != null){
        spanComment.innerHTML = comments[i].userComment;
    } else {
        spanComment.innerHTML = comments;
    }
}

function setLoginDiv(loginDiv, spanLogin, logins, id, i){
    loginDiv.className = "login-comments";
    loginDiv.id = "login-comments" + id;
    if (i != null){
        spanLogin.innerHTML = ""+logins[i] + " : ";
    } else {
        spanLogin.innerHTML = ""+logins + " : ";
    }
}

function setTopPartComment(interactsDiv, id,  color1, modulo){
    interactsDiv.className = "container-login-date";
    interactsDiv.id = "container-login-date" + id;
    interactsDiv.style.background = "rgba(" + color1 + ",0.6)";
    if (modulo == 0){
        interactsDiv.classList.add('left');
    } else {
        interactsDiv.classList.add('right');
    }
}

function setContainerAllComments(containerInteract, id, modulo) {
    containerInteract.className = "container_message";
    containerInteract.id = "container_message" + id;
    if (modulo == 0){
        containerInteract.classList.add('left');
    } else {
        containerInteract.classList.add('right');
    }
}

function setHr(hrDiv, hr, modulo) {
    hrDiv.className = "hr-div";
    if (modulo == 0){
        hrDiv.classList.add('left');
    } else {
        hrDiv.classList.add('right');
    }
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