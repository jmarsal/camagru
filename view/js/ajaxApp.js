/**
 * Created by jmarsal on 3/7/17.
 */

function doNothink() {
    document.getElementById('menuFilter');
}

function ajaxPhoto(data64) {
    var xhr = getXMLHttpRequest(),
        container = document.getElementById('prev-image'),
        divInputName = document.createElement('div'),
        img = document.createElement('img'),
        del = document.createElement('img'),
        see = document.createElement('img'),
        countElems = document.querySelectorAll('#prev-image .container-prev img')
    ;

    //Path et id de la prev dans la nouvelle balise img
    divInputName.className = "div-namePhoto";
    //Path de l'img trash pour supprimer la prev
    del.className = "del-button";
    del.src = "../webroot/images/app/Trash.ico";
    del.id = "del-button";
    del.title = "Supprimer la photo ?";

    //Path de l'img see pour afficher l'image en grand
    see.src = "../webroot/images/app/Loupe.png";
    see.className = "see-button";
    see.id = "see-button";
    see.title = "Agrandir ?";

    xhr.onreadystatechange = function() {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText),
                //container = le container de toutes les prev
                divContainer = document.createElement('div'),
                divContainerAction = document.createElement('div')
            ;

            img.src = '../' + data.thumbnail;
            img.id = data.idMin;

            del.onclick = function() { delImg(data.idMin); };
            see.onclick = function () { enlargePhoto(data.idMin); };

            if (countElems.length >= 6){
                container.style.overflowY = "auto";
                container.classList.add('scroll-container-prev');
            } else {
                container.style.overflowY = "none";
                container.classList.remove('scroll-container-prev');
                if (countElems.length == 0){
                    container.style.display = "none";
                }
            }

            divContainerAction.className = "prev-action";

            divContainer.className = "container-prev";
            divContainer.id = "" + data.idMin + "";

            // divInputName.insertBefore(inputName, divInputName.childNodes[0]);

            divContainerAction.insertBefore(see, divContainerAction.childNodes[0]);
            divContainerAction.insertBefore(divInputName, divContainerAction.childNodes[1]);
            divContainerAction.insertBefore(del, divContainerAction.childNodes[2]);

            container.style.display = "block";
            container.insertBefore(divContainer,  container.childNodes[0]);

            var containerPrev = document.getElementById(data.idMin);
            containerPrev.insertBefore(img, containerPrev.childNodes[0]);
            containerPrev.insertBefore(divContainerAction, containerPrev.childNodes[1]);
        }
    };
    var tmp = "img64=" + data64 + "&countElem=" + countElems.length;
    xhr.open("post", "uploadAjax", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}

function delImg(id){
    var xhr = getXMLHttpRequest();
    var imgs = document.getElementById(id);

    xhr.onreadystatechange = function() {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            var closeEnlarge = document.getElementById('container-enlarge'),
                replaceVideo = document.getElementById('myvideo'),
                upload = document.getElementById('imgUpload'),
                fileUpload = document.getElementById('file-upload'),
                cacheButtons = document.getElementById('buttonActionApp')
            ;

            if (closeEnlarge != null){
                closeEnlarge.parentNode.removeChild(closeEnlarge);
                if (fileUpload.classList.contains('upload')){
                    upload.style.display = 'block';
                    upload.classList.add('delImg');
                } else {
                    replaceVideo.style.display = "block";
                    cacheButtons.classList.add('delImg');
                }
                cacheButtons.style.display = 'inline-flex';
                cacheButtons.style.cursor = 'pointer';
            }
            imgs.parentNode.removeChild(imgs);
            var countElems = document.querySelectorAll('#prev-image .container-prev img');

            if (countElems.length <= 6){
                var container = document.getElementById('prev-image');

                container.style.overflowY = "hidden";
                container.classList.remove('scroll-container-prev');
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
                cacheTakePhoto = document.getElementById('buttonActionApp'),
                upload = document.getElementById('imgUpload'),
                fileUpload = document.getElementById('file-upload'),
                closeObjFilter = document.getElementById('imgObj'),
                containerAllFilters = document.getElementById('container-all-filters'),
                containerFilters = document.getElementById('filterHideButton'),
                containerObjs = document.getElementById('objHideButton')
            ;

            if (closeEnlarge != null){
                closeEnlarge.parentNode.removeChild(closeEnlarge);
            }
            if (closeObjFilter){
                closeObjFilter.style.display = 'none';
            }
            if (upload){
                upload.style.display = 'none';
            }
            if (upload.src === ""){
                fileUpload.classList.remove('active');
            } else {
                replaceVideo.classList.add('enlarge');
                fileUpload.style.display = 'none';
            }
            closeAllFilters();
            containerAllFilters.style.filter = "grayscale(100%)";
            containerFilters.onclick = function () { doNothink(); };
            containerObjs.onclick = function () { doNothink(); };

            container.className = "container-enlarge";
            container.id = "container-enlarge";

            img.src = '../' + data.idBig;
            img.className = "img-enlarge";

            close.src = "../webroot/images/app/close2.png";
            close.className = "close-enlarge";
            close.title = "Fermer photo ?";

            close.onclick = function () {
                var close = document.getElementById("container-enlarge"),
                    video = document.getElementById('myvideo'),
                    upload = document.getElementById('imgUpload'),
                    cacheTakePhoto = document.getElementById('buttonActionApp'),
                    closeObjFilter = document.getElementById('imgObj')
                    ;

                // replaceVideo.classList.remove('upload');
                // replaceVideo.classList.remove('enlarge');
                close.style.display = "none";
                replaceVideo.removeChild(close);
                fileUpload.classList.remove('active');

                containerFilters.onclick = function () { showHideFilter(); };
                containerObjs.onclick = function () { showHideObj(); };
                containerAllFilters.style.filter = "none";

                if (upload.src !== ""){
                    fileUpload.style.display = 'block';
                }
                if (upload.classList.contains("active")){
                    upload.style.display = 'inline-block';
                    video.style.display = 'none';
                } else {
                    video.style.display = "inline-block";
                    upload.style.display = 'none';
                }
                cacheTakePhoto.style.display = 'inline-flex';

                if (closeObjFilter){
                    closeObjFilter.style.display = 'block';
                }
            }

            cacheTakePhoto.style.display = 'none';
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

function uploadImg() {
    var pathFile = document.getElementById('my-file').files[0].name,
        getType = document.getElementById('my-file').files[0].type,
        validImage = ["image/gif", "image/jpeg", "image/png"],
        messFileOrError = document.getElementById('file-upload'),
        booth = document.getElementById('booth'),
        xhr = getXMLHttpRequest()
    ;

    messFileOrError.style.display = 'block';
    messFileOrError.classList.remove('upload');
    if (pathFile){
        var n = pathFile.lastIndexOf("\\"),
            path = pathFile.substr(n + 1),
            fileInput = document.getElementById('my-file'),
            reader = new FileReader()
        ;

        // Si l'image n'est pas au bon format
        if (validImage.indexOf(getType) < 0) {
            var err = "Mauvais Format ! Veuillez essayer avec un jpg, png ou gif...",
                tmp = "error=" + err
            ;

            xhr.open("post", "uploadPhotoAjax", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send(tmp);
            messFileOrError.innerHTML = err;

        //    Si c'est bon
        } else {
            // Si l'image a une taille correct
            booth.classList.add('upload');
            if (document.getElementById('my-file').files[0].size < 2100000){
                var filter = document.getElementById('myvideo').style.filter,
                    newImg = document.getElementById('imgUpload'),
                    backVideo = document.getElementById('back-to-video'),
                    takePhoto = document.getElementById('startbutton'),
                    uploadPhoto = document.getElementById('startbuttonUpload'),
                    divUploadButton = document.getElementById('uploadButton')
                ;
                document.getElementById('myvideo').style.display = 'none';
                divUploadButton.classList.add("active");

                if (newImg){
                    newImg.style.display = 'inline-block';
                    newImg.style.filter = filter;
                    newImg.classList.add("active");
                    booth.classList.add("active");
                }

                reader.addEventListener('load', function() {
                    var messFileImg = "image chargée : " + path;

                    xhr.onreadystatechange = function() {
                        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
                            newImg.setAttribute('src', reader.result);
                            backVideo.style.display = 'inline-block';
                            takePhoto.style.display = "none";
                            uploadPhoto.style.display = 'inline-block';
                            uploadPhoto.onclick = function () { ajaxPhoto(encodeURIComponent(reader.result)); };
                            messFileOrError.classList.add('upload');
                            messFileOrError.innerHTML = messFileImg;
                        }
                    };

                    var tmp = "messFileImg=" + messFileImg + "&file=" + pathFile +
                                "&src=" + encodeURIComponent(reader.result) + "&upload=ok";
                    xhr.open("post", "uploadPhotoAjax", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.send(tmp);
                });
                reader.readAsDataURL(fileInput.files[0]);

            } else {
                var err = "Fichier trop volumineux pour etre upload sur le serveur...",
                    tmp = "error=" + err
                ;

                xhr.open("post", "uploadPhotoAjax", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send(tmp);
                messFileOrError.innerHTML = err;
            }
        }

    }

}

function backCamera() {
    var container = document.getElementById('booth'),
        filter = document.getElementById('myvideo'),
        newImg = document.getElementById('imgUpload'),
        backVideo = document.getElementById('back-to-video'),
        takePhoto = document.getElementById('startbutton'),
        uploadPhoto = document.getElementById('startbuttonUpload'),
        divUploadButton = document.getElementById('uploadButton'),
        fileUpload = document.getElementById('file-upload'),
        xhr = getXMLHttpRequest()
    ;

    filter.style.display = 'block';
    filter.classList.add('back-video');
    newImg.style.display = 'none';
    newImg.classList.remove("active");
    newImg.src = "";
    fileUpload.style.display = 'none';
    fileUpload.classList.remove('active');
    container.classList.remove("active");
    container.classList.remove('upload');
    container.classList.remove('enlarge');
    backVideo.style.display = 'none';
    takePhoto.style.display = 'inline-block';
    uploadPhoto.style.display = 'none';
    divUploadButton.classList.remove("active");


    var tmp = "back=ok";
    xhr.open("post", "backCameraAjax", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}

function sendBase64ForTakePhoto(dataBase64) {
    if (dataBase64){
        dataBase64 = decodeURIComponent(dataBase64);
        dataBase64 = encodeURIComponent(dataBase64);
        ajaxPhoto(dataBase64);
    }
}