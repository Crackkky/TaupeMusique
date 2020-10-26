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
			rep_elem.innerText = data.msg;
		},
	}).then(function (){ //si j'enleve ça, il y a un trigger deux fois de l'event ajax, WTF je sais pas pourquoi
		$("#reponse0").html(data.msg);
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
			2. on affiche les messages d'erreurs eventuelles
			 */
			rep_elem = document.getElementById("reponseEnr");
			//rep_elem.innerText = data.msg;
			i = 0
			$.each(data, function(key,value) {
				if(i==0){//juste pour ne pas mettre le premier message dans la liste à puce
					str+= data[key];
					i= i+1;
				} else {
					str+='<li>' + data[key] +'</li>'
				}
				rep_elem.innerHTML = "<span style=\"color: #ff0000; \"><ul>" + str + "</ul></span\">";
				/*
				alert("data:"+data);
				alert("key:"+key);
				alert("value:"+value);
				 */

			});
			;

		},
		error: function(data){
			alert("error");
			/*
			1. on recupere le conteneur d'affichage de message
			2. on affiche un message d'erreur
			3. on enumère tous les messages d'erreurs enregistré
			 */
			rep_elem = document.getElementById("reponseEnr");
			//rep_elem.innerText = data.msg;
			alert(data[0]);
			alert(data[1]);
			$.each(data, function(i,item) {
				str+='<li>' + item +'</li>'
				rep_elem.innerHTML('<span style="color: #ff0000; "><ul>' + str + '</ul></span">');
				rep_elem.fadeOut(5000);

			});
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
		cahce: false,
		success: function(data){
			location.reload();
		},
	});
};	

