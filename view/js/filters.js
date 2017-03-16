/**
 * Created by jmarsal on 3/9/17.
 */

function changeFilter(filter){
    var xhr = getXMLHttpRequest();

    xhr.onreadystatechange = function()
    {
        if((state = xhr.readyState) == 4 && xhr.status == 200) {
            toggleActiveClass(filter);
            var cacheTakePhoto = document.getElementById('form-cache-photo'),
                takePhoto = document.getElementById('startbutton')
            ;
            cacheTakePhoto.style.display = 'block';
            cacheTakePhoto.style.cursor = 'pointer';
            takePhoto.style.display = 'block';
        }
    };

    var tmp = "filter=" + filter;
    xhr.open("post", "", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
    document.getElementById("myvideo").style.filter = filter;
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
