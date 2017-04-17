/**
 * Created by jmarsal on 3/17/17.
 */

function changeFilterObjet(filter){
    var xhr = getXMLHttpRequest();

    xhr.onreadystatechange = function() {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            var imgObj = NewObjectImg(filter),
                ifExist = document.getElementById("imgObj"),
                cacheTakePhoto = document.getElementById('buttonActionApp'),
                cacheChooseFilter = document.getElementById('chooseFilter'),
                container = document.getElementById('booth')
                ;

            toggleActiveObjClass(filter);
            cacheTakePhoto.style.display = 'inline-flex';
            cacheChooseFilter.style.display = 'none';
            if (ifExist) {
                ifExist.parentNode.removeChild(ifExist);
            }
            if (imgObj) {
                container.insertBefore(imgObj, container.childNodes[0]);
            }
        }
    };
    var tmp = "objFilter=" + filter;
    xhr.open("post", "objFilterAjax", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}

function NewObjectImg(filter){

    if (filter === 'noneObj'){
        return null;
    } else {
        var imgObj = document.createElement('img'),
            enlarge = enlarge = document.getElementById('container-enlarge')
        ;

        if (filter === 'beardMustaches'){
            imgObj.style.width = '28%';
            imgObj.style.marginLeft = "500px";
            imgObj.style.marginTop = "500px";
        } else if (filter === "chapeauPirate"){
            imgObj.style.width = '60%';
            imgObj.style.marginLeft = "275px";
            imgObj.style.marginTop = "-25px";
        } else if (filter === "dog"){
            imgObj.style.width = '40%';
            imgObj.style.marginLeft = "-80px";
            imgObj.style.marginTop = "410px";
        } else if (filter === "epee"){
            imgObj.style.width = '30%';
            imgObj.style.marginLeft = "251px";
            imgObj.style.marginTop = "581px";
        } else if (filter === "epeeLaser"){
            imgObj.style.width = '40%';
            imgObj.style.marginLeft = "170px";
            imgObj.style.marginTop = "580px";
        } else if (filter === 'largeMustache'){
            imgObj.style.width = '18%';
            imgObj.style.marginLeft = "850px";
            imgObj.style.marginTop = "582px";
        } else if (filter === 'lunette'){
            imgObj.style.width = '24%';
            imgObj.style.marginLeft = "800px";
            imgObj.style.marginTop = "289px";
        } else if (filter === 'monkey'){
            imgObj.style.width = '18%';
            imgObj.style.marginLeft = "421px";
            imgObj.style.marginTop = "317px";
        } else if (filter === 'policeHat'){
            imgObj.style.width = '38%';
            imgObj.style.marginLeft = "643px";
            imgObj.style.marginTop = "-4px";
        } else if (filter === 'prismaticMustache'){
            imgObj.style.width = '22%';
            imgObj.style.marginLeft = "800px";
            imgObj.style.marginTop = "700px";
        }
        imgObj.src = '../webroot/images/objets/' + filter + '.png';
        imgObj.style.position = 'absolute';
        imgObj.style.zIndex = '55';
        imgObj.id = 'imgObj';
        if (enlarge){
            imgObj.style.display = 'none';
        }
    }

    return imgObj;
}

function toggleActiveObjClass(filter){
    var buttonIds = [
        'noneObj',
        'beardMustaches',
        'chapeauPirate',
        'dog',
        'epee',
        'epeeLaser',
        'largeMustache',
        'lunette',
        'monkey',
        'policeHat',
        'prismaticMustache'
    ];

    if (!filter){
        filter = 'noneObj';
    }
    for (i = 0; i < buttonIds.length; i++){
        var element = document.getElementById(buttonIds[i]);

        if (element.classList.contains("active")){
            element.classList.remove("active");
        }
    }

    document.getElementById(filter).classList.add("active");
}