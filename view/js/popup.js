/**
 * Created by jmarsal on 2/13/17.
 */

function showPopup(){
    document.getElementById("popup").style.display = "block";
    document.getElementById("overlay").style.display = "block";
}
showPopup();

function hidePopup(){
    document.getElementById("popup").style.display = "none";
    document.getElementById("overlay").style.display = "none";
}