console.log("TEST LOADING SCRIPT");
setTimeout(function(){
    var nb_personne = document.getElementById("nb_personnes");
    var nb_nuits;
    var prix_base = document.getElementById("prix_base");
    var prix_total = document.getElementById("total"); 
    var date_debut = document.getElementById("date_debut");
    var date_fin = document.getElementById("date_fin");
        date_debut.addEventListener("change", function(){
            prix_total.value = calcPrix(date_debut, date_fin, nb_personne.value, prix_base.value);
        });
        date_fin.addEventListener("change", function(){
            prix_total.value = calcPrix(date_debut, date_fin, nb_personne.value, prix_base.value);
        });
    if(nb_personne && prix_base){
        //if(nb_nuits)
        nb_personne.addEventListener("input", function(){
            if(nb_personne.value != ""){
                if(!isNaN(nb_personne.value)){
                    if(parseInt(nb_personne.value) > parseInt(nb_personne.max)){
                        nb_personne.value = nb_personne.max;
                    }
                    prix_total.value = calcPrix(date_debut, date_fin, nb_personne.value, prix_base.value);
                }
            }
        } );
    }

},100);
function calcPrix(date1, date2, nb_personne, prix_base){
    // To calculate the time difference of two dates
    date1tmp = date1;
    date1 = date1.valueAsDate;
    date2tmp = date2;
    date2 = date2.valueAsDate;
    var Difference_In_Time = date2.getTime() - date1.getTime();
    //change min date2
    
    var newmin = date1;
    newmin.setDate( newmin.getDate() + 1 );
    var dd = newmin.getDate();//cannot book for the same day
    var mm = newmin.getMonth()+1; //January is 0 so need to add 1 to make it 1!
    var yyyy = newmin.getFullYear();
    if(dd<10){
    dd='0'+dd
    } 
    if(mm<10){
    mm='0'+mm
    } 

    newmin = yyyy+'-'+mm+'-'+dd;
    date2tmp.setAttribute("min", newmin);

    // To calculate the no. of days between two dates
    if(nb_personne == "")
        nb_personne = 1;
    var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
    //change nbnuit
    if(Difference_In_Days<0){
        date2tmp.setAttribute("value", newmin);
        date2tmp.setAttribute("min", newmin);
        Difference_In_Days = 1;
    }
    document.getElementById("nbnuit").innerHTML = Difference_In_Days;
    
    return (Math.round((parseInt(prix_base,10) + (parseInt(nb_personne, 10) * 1.20))*Difference_In_Days * 100) / 100).toFixed(2);
//return keep2decimal((prix_base + nbperson*1.20 )*diff_date);

}
