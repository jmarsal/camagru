/**
 * Created by jmarsal on 2/24/17.
 */
var sBar = document.getElementById("header__icon");
var body = document.getElementById("body");

function showhide() {
    var body = document.body;

    if (body.className.match(/(?:^|\s)width--sidebar(?!\S)/))
        body.className = '';
    else
        body.className = 'width--sidebar';
}

function showHideFilter() {
    var takeMenuFilter = document.getElementById('menuFilter'),
        objFilter = document.getElementById('objets-filter'),
        newFilters = objFilter,
        container = document.getElementById('container-all-filters')
    ;

    if (takeMenuFilter.style.display === 'none'){

        var checkObj = document.getElementById('menu-objets');

        if (checkObj.style.display === 'block'){
            checkObj.style.display = 'none';
        }
        container.removeChild(objFilter);
        takeMenuFilter.style.display = 'block';
        container.style.marginLeft = '120px';
        container.style.marginRight = '-160px';
        document.getElementById('none').style.animationName = "explode";
        document.getElementById('blur(5px)').style.animationName = "explode";
        document.getElementById('brightness(0.4)').style.animationName = "explode";
        document.getElementById('grayscale(100%)').style.animationName = "explode";
        document.getElementById('hue-rotate(45deg)').style.animationName = "explode";
        document.getElementById('hue-rotate(135deg)').style.animationName = "explode";
        document.getElementById('hue-rotate(220deg)').style.animationName = "explode";
        document.getElementById('hue-rotate(320deg)').style.animationName = "explode";
        document.getElementById('invert(100%)').style.animationName = "explode";
        document.getElementById('sepia(60%)').style.animationName = "explode";
        takeMenuFilter.insertBefore(newFilters, takeMenuFilter.lastChild);
        newFilters.style.marginLeft = '-10px';

    } else {
        var newFilters = document.getElementById('objets-filter'),
            objFilter = newFilters
        ;

        takeMenuFilter.removeChild(newFilters);
        takeMenuFilter.style.display = 'none';
        container.insertBefore(objFilter, container.lastChild);
        objFilter.style.marginLeft = '0px';
    }

}

function showHideObj() {
    var takeObj = document.getElementById('menu-objets'),
        filters = document.getElementById('filters'),
        newFilters = filters,
        container = document.getElementById('container-all-filters')
    ;

    if (takeObj.style.display === 'none'){
        var checkFilters = document.getElementById('menuFilter'),
            containerObj = document.getElementById('objets-filter')
        ;

        if (checkFilters.style.display === 'block') {
            container.removeChild(filters);
            container.insertBefore(newFilters, container.lastChild);
        }
        takeObj.style.display = 'block';
        document.getElementById('noneObj').style.animationName = "explode";
        document.getElementById('beardMustaches').style.animationName = "explode";
        document.getElementById('chapeauPirate').style.animationName = "explode";
        document.getElementById('dog').style.animationName = "explode";
        document.getElementById('epee').style.animationName = "explode";
        document.getElementById('epeeLaser').style.animationName = "explode";
        document.getElementById('largeMustache').style.animationName = "explode";
        document.getElementById('lunette').style.animationName = "explode";
        document.getElementById('monkey').style.animationName = "explode";
        document.getElementById('policeHat').style.animationName = "explode";
        document.getElementById('prismaticMustache').style.animationName = "explode";
        if (checkFilters.style.display === 'block'){
            checkFilters.style.display = 'none';
            container.insertBefore(containerObj, container.lastChild);
            containerObj.style.marginLeft = "0px";
        }
    } else {
        takeObj.style.display = 'none';
    }
}

function closeAllFilters() {
    var takeMenuFilter = document.getElementById('menuFilter'),
        objFilter = document.getElementById('menu-objets')
    ;

    if (takeMenuFilter.style.display === 'block'){
        showHideFilter();
    } else if (objFilter.style.display === 'block'){
        showHideObj();
    }
}























































