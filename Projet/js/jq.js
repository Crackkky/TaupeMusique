$(document).ready(function(){
	$('#reponse').hide();

	$('#logform').submit(function(e){

		e.preventDefault();
		//e.stopPropagation();
		formdata = $('#logform').serialize();
		submitForm(formdata);
	});

	$('#enregform').submit(function(e){
		e.preventDefault();
		formdata = $('#enregform').serialize();
		submitDetails(formdata);
	});

	$('#modiform').submit(function(e){
		e.preventDefault();
		formdata = $('#modiform').serialize();
		updateDetails(formdata);
	});

	$('#datePicker')
		.datepicker({
			format: 'dd/mm/yyyy',
			startDate: '01/01/1900',
			endDate: '12/30/2020'
		});

	$('#datePicker2')
		.datepicker({
			format: 'dd/mm/yyyy',
			startDate: '01/01/1900',
			endDate: '12/30/2020'
		});
});

function submitForm(formdata){
	$.ajax({
		type: 'POST',
		url: 'login.php',
		data: formdata,
		dataType: 'json',
		cache: false,
		success: function(data){
			rep_elem = document.getElementById("reponse0");
			if(data.msg == "L'utilisateur est maintenant connecté"){
				rep_elem.innerHTML = rep_elem.innerHTML = "<span style=\"color: #00ff00; \"><ul>" + data.msg + "</ul></span\">";
				//Pour les tests on enlève cette ligne
				window.location.reload();
			} else {
				rep_elem.innerHTML = rep_elem.innerHTML = "<span style=\"color: #ff0000; \"><ul>" + data.msg + "</ul></span\">";
			}
		},
	});
};

function submitDetails(formdata){
	var str = '';
	$.ajax({
		type: 'POST',
		url: 'enregistrer.php',
		data: formdata,
		dataType: 'json',
		cache: false,
		success: function(data){
			/*
			1. on recupere le conteneur d'affichage de message
			2.a on regarde si c'est un msg de succès => on affiche en vert
			2.b on regarde si c'est un msg d'echec : => on affiche en rouge
			 */
			rep_elem = document.getElementById("reponseEnr");
			//rep_elem.innerText = data.msg;
			i = 0
			$.each(data, function(key,value) {
				if(i==0){//juste pour ne pas mettre le premier message dans la liste à puce
					str+= data[key];
					i= i+1;
				} else { if(key=="FLAG"){ str+="";}else{ //on enleve les true/falses
					str+='<li>' + data[key] +'</li>'
					}
				}
				if(data["FLAG"]){ //data["FLAG"] = true | false en fonction de succes ou echec
					rep_elem.style.color = "green";
					rep_elem.innerHTML = "<span style=\"color: #00ff00; \"><ul>" + str + "</ul></span\">";
				} else {
					rep_elem.style.color = "red";
					rep_elem.innerHTML = "<span style=\"color: #ff0000; \"><ul>" + str + "</ul></span\">";
				}

			});

			;

		},
		error: function(data){
			/*
			1. on recupere le conteneur d'affichage de message
			2.a on regarde si c'est un msg de succès => on affiche en vert
			2.b on regarde si c'est un msg d'echec : => on affiche en rouge
			*/
			rep_elem = document.getElementById("reponseEnr");
			//rep_elem.innerText = data.msg;
			i = 0
			$.each(data, function(key,value) {
				if(i==0){//juste pour ne pas mettre le premier message dans la liste à puce
					str+= data[key];
					i= i+1;
				} else { if(key=="FLAG"){ str+="";}else{ //on enleve les true/falses
					str+='<li>' + data[key] +'</li>'
					}
				}
				if(data["FLAG"]){ //data["FLAG"] = true | false en fonction de succes ou echec
					rep_elem.style.color = "green";
					rep_elem.innerHTML = "<span style=\"color: #00ff00; \"><ul>" + str + "</ul></span\">";
				} else {
					rep_elem.style.color = "red";
					rep_elem.innerHTML = "<span style=\"color: #ff0000; \"><ul>" + str + "</ul></span\">";
				}

			});

			;
		}
	}).then(function(){
	});
};


function updateDetails(formdata){
	var str = '';
	$.ajax({
		type: 'POST',
		url: 'update.php',
		data: formdata,
		dataType: 'json',
		cache: false,
		success: function(data){
			window.location.reload();
		},
	});
};	

