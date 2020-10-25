$(document).ready(function(){
	$('#reponse').hide();
	$('#logform').submit(function(e){
		e.preventDefault();
		formdata = $('#logform').serialize();
		alert("envoie des données");
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
			$('#reponse').innerHTML = data;
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
			$('#test').innerText="OSKOUUUUUUR";
			$('#reponse1').show();
			$.each(data, function(i,item) {
				if(item !== data.ok){
					str+='<li>' + item +'</li>'
				}
				$('#reponse1').innerHTML('<span style="color: #ff0000; "><ul>' + str + '</ul></span">');
				$('#reponse1').fadeOut(5000);

			});
			location.reload();
			*/
			$("#test").html("SUCCESS")
		},
		error: function(){
			$("#test").html("ERROR");
		}
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

