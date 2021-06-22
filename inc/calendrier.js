var calendar = document.getElementById("calendrier");
var dayweek = [
	"Lun",
	"Mar",
	"Mer",
	"Jeu",
	"Ven",
	"Sam",
	"Dim"
];
var months = [
	"Janv",
	"Fevr",
	"Mars",
	"Avril",
	"Mai",
	"Juin",
	"Juil",
	"Aou",
	"Sept",
	"Oct",
	"Nov",
	"Dec"
];

var indispo = [
	"5 Juil",
	"25 Juin",
	"6 Juil",
	"30 Juin",
];
function creerCalendrier(indispo){
	//creer la table
	table = document.createElement("table");
	//calendar.append(table);
	//generer lun/mard/merc/jeudi....
	x = table.insertRow();
	for(i = 0; i < 7; i++){
		th = document.createElement("th");
		th.innerHTML = dayweek[i];
		x.append(th);
	}
	x = table.insertRow();//yes !
	//mois acutelle
	getCalendarXMonth(table, calendar, dayweek, new Date());

	//mois suivant
	let xd = new Date();
	xd.setMonth(xd.getMonth()+1);
	xd.setDate(1);
	getCalendarXMonth(table, calendar, dayweek, xd);
}
function getCalendarXMonth(table, calendar, dayweek, da){
	var todayD = da.getDay();
	var todayM = da.getMonth();
	var todayY = da.getYear();
	var todayDayOfMonth = da.getDate();
	
	//calcule nb jours avant la fin du mois
	var time = new Date(da.getFullYear());
	time.setMonth(time.getMonth() + 1);
	time.setDate(0);
	var days = time.getDate() > da.getDate() ? time.getDate() - da.getDate() : 0;
	//console.log(days);
	for(i = 0; i < days; i++){
		createDay(table, i, todayD, todayM, todayY, todayDayOfMonth);
	}
}

function createDay(table, i, todayDD, todayMM, todayYY, todayDayOfMonthh){		
	if((parseInt(todayDD-1)+i)%7 == 0){//SI lundi !
		x = table.insertRow();
		el = x.insertCell(0);
		el.innerHTML = /*dayweek[(parseInt(todayDD-1)+i)%7] + " " + */(parseInt(todayDayOfMonthh) + i);//ajouter l'element
	}
	else{//si pas lundi
		el = x.insertCell();
		el.innerHTML = /*dayweek[(parseInt(todayDD-1)+i)%7] + " " + */(parseInt(todayDayOfMonthh) + i);
	}
	/*indispo.forEach(k =>{//pour chaque jour dans le tableau indispo
		var indi_tmp = k.split(" ");
		if(indi_tmp[0] == parseInt(todayDayOfMonthh+i)){//si le jours correspond
			if(indi_tmp[1] == months[(todayMM)]){//si le mois correspond
				el.classList.add("rouge");
			}
		}
	});*/
}



function loadIndispo(id){
    var params = new Object();
    params.id = id;
	var indispo = [
		"5 Juil",
		"25 Juin",
		"6 Juil",
		"30 Juin",
	];	
    //let indispo = loadXMLDoc("inc/getIndispo.php", params);
	//creerCalendrier(indispo);
}
function loadXMLDoc(page, params) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) {   // XMLHttpRequest.DONE == 4
           if (xmlhttp.status == 200) {
               return xmlhttp.responseText.split("%%%");
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