function loadpage(id){
    var params = new Object();
    params.id = id;
    loadXMLDoc("logement.php", params);
   // var newScript = document.createElement("script");
  //  newScript.src = "https://xill.tk/projet_gite/inc/calendrier.js";
   // document.getElementById("view").appendChild(newScript);
   // setTimeout( function(){loadIndispo(parseInt(id));},200);
}
function loadXMLDoc(page, params) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) {   // XMLHttpRequest.DONE == 4
           if (xmlhttp.status == 200) {
               //replace view element
               document.getElementById("view").innerHTML = xmlhttp.responseText;
               console.log(xmlhttp.responseText);
               document.getElementById("view").style.display = "flex";
               var newScript = document.createElement("script");
                newScript.src = "https://xill.tk/projet_gite/calcPrix.js";
                document.getElementById("view").appendChild(newScript);
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

