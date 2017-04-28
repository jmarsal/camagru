/**
 * Created by jmarsal on 3/9/17.
 */

function changeFilter(filter){
    var xhr = getXMLHttpRequest(),
        filterOnVideo = document.getElementById("myvideo"),
        filterOnUpload = document.getElementById("imgUpload")
    ;

    xhr.onreadystatechange = function()
    {
        if((state = xhr.readyState) == 4 && xhr.status == 200) {
            toggleActiveClass(filter);
            var cacheTakePhoto = document.getElementById('buttonActionApp'),
                cacheChooseFilter = document.getElementById('chooseFilter')
            ;

            cacheTakePhoto.style.display = 'inline-flex';
            cacheChooseFilter.style.display = 'none';
            if (filterOnUpload.classList.contains('active')){
                filterOnUpload.style.filter = filter;
            } else {
                filterOnVideo.style.filter = filter;
            }
        }
    };

    var tmp = "filter=" + filter;
    xhr.open("post", "", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}

function toggleActiveClass(filter){
    var buttonIds = [
        'none',
        'blur(5px)',
        'brightness(0.4)',
        'grayscale(100%)',
        'hue-rotate(45deg)',
        'hue-rotate(135deg)',
        'hue-rotate(220deg)',
        'hue-rotate(320deg)',
        'invert(100%)',
        'sepia(60%)'
    ];

    if (!filter){
        filter = 'none';
    }
    for (i = 0; i < buttonIds.length; i++){
        var element = document.getElementById(buttonIds[i]);

        if (element.classList.contains("active")){
            element.classList.remove("active");
        }
    }

    document.getElementById(filter).classList.add("active");
}
