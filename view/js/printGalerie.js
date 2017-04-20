/**
 * Created by jmarsal on 4/19/17.
 */

/*
    Click sur image de commentaires.
    Construit le container avec tous les messages, ainsi que le cote d'affichage et sa couleur.
 */

function commmentsClick(id) {
    var xhr = getXMLHttpRequest()
    ;

    xhr.onreadystatechange = function () {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText),
                containerDiv = document.getElementById("container-comments" + id),
                newcommentsDiv = document.getElementById("new-comments-container" + id),
                comments = data.comments,
                logins = data.logins,
                idCreateComments = 0,
                loginPrec = "",
                lastSetting = Array
            ;

            if (newcommentsDiv.style.display != "block"){
                newcommentsDiv.style.display = "block";

                //Check si il existe des message precedent, et si ils sont du meme user que celui qui est log
                if (!logins){
                    logins = new Array;
                    logins[0] = data.logSession;
                }

                for (i = 0; i < comments.length - 1; i++){
                    if (i == 0){
                        lastSetting = getModulo(data.logSession, data.logSession, logins[i], lastSetting, i);
                    }
                    else {
                        loginPrec = logins[i - 1];
                        lastSetting = getModulo(data.logSession, loginPrec, logins[i], lastSetting, i);
                    }
                    // console.log(comments.userComment);
                    constructCommentsInDocument(containerDiv, comments, logins, idCreateComments, i, lastSetting);
                    containerDiv.scrollTop = containerDiv.scrollHeight + 100;
                    idCreateComments++;
                }
            } else {
                newcommentsDiv.style.display = "none";
                removeContainerComments(id);
            }
        }
    };
    var tmp = "commentsGalerie=" + id;
    xhr.open("post", "getCommentsAjaxGalerie", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}

function checkIfMessAndUser(userLogin, firstUserComment) {
    if (userLogin && firstUserComment){
        var check = userLogin.search(firstUserComment);

        check = (check == 0) ? 0 : -1;
        return check;
    } else {
        return 0;
    }
}

function getModulo(userLogin, login1, login2, lastSettings, i) {

    if (i == 0){
        if ((checkIfMessAndUser(login1, login2)) == 0 && userLogin === login1){
            lastSettings['modulo'] = 0;
            return lastSettings;
        } else {
            lastSettings['modulo'] = 1;
            return lastSettings;
        }
    } else {
        if (lastSettings['modulo'] == 0 && login1 != login2){
            lastSettings['modulo'] = 1;
            return lastSettings;
        } else if (lastSettings['modulo'] == 0 && login1 == login2){
            lastSettings['modulo'] = 0;
            return lastSettings;
        } else if (lastSettings['modulo'] == 1 && login1 != login2){
            lastSettings['modulo'] = 0;
            return lastSettings;
        } else {
            lastSettings['modulo'] = 1;
            return lastSettings;
        }
    }
}

function constructCommentsInDocument(containerComments, comments, logins, id, i, lastSettings){ // containerDiv = conatiner-comments; sameUser = meme utilisateur que le premier comment ? 0 pour oui, -1 non
    var spanComment = document.createElement('div'),
        spanDate = document.createElement('span'),
        spanLogin = document.createElement('span'),
        containerInteract = document.createElement("div"),
        interactsDiv = document.createElement("div"),
        dateDiv = document.createElement("div"),
        loginDiv = document.createElement("div"),
        commentsDiv = document.createElement("div"),
        hrDiv = document.createElement("div"),
        hr = document.createElement('hr'),
        date = new Date(comments[i].created),
        formatDate = reformatDate(date)
    ;

    setHr(hrDiv, hr, lastSettings['modulo']);
    setContainerAllComments(containerInteract, id, lastSettings['modulo']);
    setTopPartComment(interactsDiv, id,  lastSettings['color1'], lastSettings['modulo']);
    setDateCreated(dateDiv, spanDate, formatDate, id);
    setLoginDiv(loginDiv, spanLogin, logins, id, i);
    setBottomPartComment(commentsDiv, spanComment, comments, i, id, lastSettings);

    containerComments.style.display = "block";
    setElementsInDocument(loginDiv, spanLogin, dateDiv, spanDate, interactsDiv, commentsDiv,
        spanComment, hrDiv, hr,  containerInteract, containerComments, i);
}