function loadpage(id){
    var params = new Object();
    params.id = id;
    loadXMLDoc("logement.php", params);
}
function sendmail(id){
    var params = new Object();
    params.id = id;
    params.email = document.getElementById("email").value;
    params.date_debut = document.getElementById("date_debut").value;
    params.date_fin = document.getElementById("date_fin").value;
    params.nb_personnes = document.getElementById("nb_personnes").value;
    params.prix = document.getElementById("total").value;
    sendrequest(params);
    return false;
}
function sendrequest(params){
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) {   // XMLHttpRequest.DONE == 4
            if (xmlhttp.status == 200) {
                console.log("email envoyé !");
                console.log(xmlhttp.responseText);
            }
            else if (xmlhttp.status == 400) {
               alert('There was an error 400');
            }
            else {
                alert('something else other than 200 was returned');
            }
         }
     };
 //send get request to logement.php
     xmlhttp.open("POST", "sendmail.php", true);
     xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
     xmlhttp.send("id=" + params.id + "&email=" + params.email + "&date_debut="  + params.date_debut + "&date_fin=" + params.date_fin + "&nb_personnes=" + params.nb_personnes + "&prix=" + params.prix);
     return false;
}
function loadXMLDoc(page, params) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) {   // XMLHttpRequest.DONE == 4
           if (xmlhttp.status == 200) {
               //replace view element
               document.getElementById("view").innerHTML = xmlhttp.responseText;
              
               document.getElementById("view").style.display = "flex";
               var newScript = document.createElement("script");
                newScript.src = "https://xill.tk/projet_gite/calcPrix.js";
                document.getElementById("view").appendChild(newScript);
                newScript = document.createElement("script");
                newScript.src = "https://xill.tk/projet_gite/inc/calendrier.js";
                document.getElementById("view").appendChild(newScript);
                setTimeout( function(){
                    var indispo = [
                        "5 Juil",
                        "25 Juin",
                        "6 Juil",
                        "30 Juin",
                    ];
                    //var indispo = loadXMLDocI("inc/getIndispo.php", params);
                    loadXMLDocI("inc/getIndispo.php", params);
                },400);

               setTimeout(function(){
                   var rond = document.querySelector('.rond');
                   rond.addEventListener('click', closeWindow);
                
                   function closeWindow(){
                       view.setAttribute ("style" , "display:none; animation:out 3s ease 0s 1 normal forwards");
                   }
                },80);
           }
           else if (xmlhttp.status == 400) {
              alert('There was an error 400');
           }
           else {
               alert('something else other than 200 was returned');
           }
        }
    };
//send get request to logement.php
    xmlhttp.open("POST", page, true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("id=" + params.id);
    return false;
}