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

/*var indispo = [
	"5 Juil",
	"25 Juin",
	"6 Juil",
	"30 Juin",
];*/
function creerCalendrier(indispo){
	//creer la table
	titre = document.createElement("h2");
	titre.style.position = "relative";
	titre.style.left = "42%";
	titre.style.right = "50%";
	titre.innerHTML = months[new Date().getMonth()];
	calendar.append(titre);
	table = document.createElement("table");
	calendar.append(table);
	//generer lun/mard/merc/jeudi....
	x = table.insertRow();
	for(i = 0; i < 7; i++){
		th = document.createElement("th");
		th.innerHTML = dayweek[((i+(new Date(new Date().getFullYear(), new Date().getMonth(), 1).getDay())-1)%7)];
		x.append(th);
	}
	x = table.insertRow();//yes !
	//jour d'avant du mois actuel
	let date = new Date();
	getCalendarXMonth(table, calendar, dayweek, new Date( date.getFullYear(), date.getMonth(), 1), indispo, "inactif")
	//mois acutelle
	getCalendarXMonth(table, calendar, dayweek, new Date(), indispo, "active");

	//mois suivant
	let xd = new Date();
	xd.setMonth(xd.getMonth()+1);
	xd.setDate(1);
	console.log(xd.getMonth());
	getCalendarXMonth(table, calendar, dayweek, xd, indispo, "active");
}
function getCalendarXMonth(table, calendar, dayweek, da, indispo, type){
	var todayD = da.getDay();
	var todayM = da.getMonth();
	var todayY = da.getYear();
	var todayDayOfMonth = da.getDate();
	
	//calcule nb jours avant la fin du mois
	var time = new Date(da.getFullYear());
	time.setMonth(time.getMonth() + 1);
	time.setDate(0);
	var days = time.getDate() > da.getDate() ? time.getDate() - da.getDate() : 0;
	if(type == "inactif")//then nb days to today
		{
			time = new Date();

			days = time.getDate() > da.getDate() ? time.getDate() - da.getDate() : 0;
		}
	//console.log(days);
	for(i = 0; i < days; i++){
		createDay(table, i, todayD, todayM, todayY, todayDayOfMonth,indispo,type);
	}
}

function createDay(table, i, todayDD, todayMM, todayYY, todayDayOfMonthh,indispo,type){		
	if((parseInt(todayDD-1)+i)%7 == (((new Date(new Date().getFullYear(), new Date().getMonth(), 1).getDay())-1)%7)){//SI jour de la semaine comme aujourd'hui !
		x = table.insertRow();
		el = x.insertCell(0);
		el.innerHTML = /*dayweek[(parseInt(todayDD-1)+i)%7] + " " + */(parseInt(todayDayOfMonthh) + i);//ajouter l'element

	}
	else{//(si pas lundi)
		el = x.insertCell();
		el.innerHTML = /*dayweek[(parseInt(todayDD-1)+i)%7] + " " + */(parseInt(todayDayOfMonthh) + i);
	}

	var de = new Date();
	de.setMonth(de.getMonth()+1, 1);
	if(type=="inactif"){
		el.classList.add("inactif");
	}
	for(j = 0; j < indispo.length;j++){//pour elements dans le tableau indispo
		var indi_tmp = indispo[j].split(" ");
		if(todayDayOfMonthh+i == new Date().getDate() && todayMM == new Date().getMonth()){
			el.classList.add("today");
		}
		if(de.getDate() == todayDayOfMonthh+i && de.getMonth() == todayMM)
			el.classList.add("firstDayNextMonth");
		if(indi_tmp != "")
			if(parseInt(indi_tmp[0]) == parseInt(todayDayOfMonthh+i)){
				if(indi_tmp[1] == months[(todayMM)]){//si le mois correspond
					el.classList.add("rouge");
					console.log("rouge");
				}
			}
	}
}

function loadXMLDocI(page, params) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) {   // XMLHttpRequest.DONE == 4
           if (xmlhttp.status == 200) {	
			creerCalendrier(xmlhttp.responseText.split("%%%"));
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
}