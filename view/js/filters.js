/**
 * Created by jmarsal on 3/9/17.
 */

function changeFilter(filter){
    var xhr = getXMLHttpRequest();

    xhr.onreadystatechange = function()
    {
        if((state = xhr.readyState) == 4 && xhr.status == 200) {
                switchColors(filter);
        }
    };

    function switchColors(filter){
        color = '#F39237';
        color_hover = '#e35c05';

        if (!filter){
            filter = 'none';
        }
        document.getElementById('none').style.background = color;
        document.getElementById('blur(5px)').style.background = color;
        document.getElementById('brightness(0.4)').style.background = color;
        document.getElementById('grayscale(100%)').style.background = color;
        document.getElementById('hue-rotate(45deg)').style.background = color;
        document.getElementById('hue-rotate(135deg)').style.background = color;
        document.getElementById('hue-rotate(220deg)').style.background = color;
        document.getElementById('hue-rotate(320deg)').style.background = color;
        document.getElementById('invert(100%)').style.background = color;
        document.getElementById('sepia(60%)').style.background = color;

        if (filter){
            document.getElementById(filter).style.background = color_hover;
        }
    }

    var tmp = "filter=" + filter;
    xhr.open("post", "", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
    document.getElementById("myvideo").style.filter = filter;
}
