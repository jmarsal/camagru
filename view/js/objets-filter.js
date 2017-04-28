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

        imgObj.className = 'obj-img';
        imgObj.src = '../webroot/images/objets/' + filter + '.png';
        imgObj.id = 'imgObj';
        if (filter === 'beardMustaches'){
            imgObj.classList.add('beardMustaches');
        } else if (filter === "chapeauPirate"){
            imgObj.classList.add('chapeauPirate');
        } else if (filter === "dog"){
            imgObj.classList.add('dog');
        } else if (filter === "epee"){
            imgObj.classList.add('epee');
        } else if (filter === "epeeLaser"){
            imgObj.classList.add('epeeLaser');
        } else if (filter === 'largeMustache'){
            imgObj.classList.add('largeMustache');
        } else if (filter === 'lunette'){
            imgObj.classList.add('lunette');
        } else if (filter === 'monkey'){
            imgObj.classList.add('monkey');
        } else if (filter === 'policeHat'){
            imgObj.classList.add('policeHat');
        } else if (filter === 'prismaticMustache'){
            imgObj.classList.add('prismaticMustache');
        }
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