/**
 * Created by jmarsal on 3/7/17.
 */

xhr.open("POST", "App/getFilter", true);
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.send("variable1=truc&variable2=bidule");
