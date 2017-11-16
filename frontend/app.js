function getQueryVariable(variable)
{
       var query = window.location.search.substring(1);
       var vars = query.split("&");
       for (var i=0;i<vars.length;i++) {
               var pair = vars[i].split("=");
               if(pair[0] == variable){return pair[1];}
       }
       return(false);
}



/* Whitelist Functions */

function updateWhitelist(){
	$.get('/esx_webadmin/backend/functions.php?return=get_whitelist').done(function( data ){
		data = JSON.parse(data);
		$('#whitelisted table tbody').html('<tr><th>ID</th><th>Name</th><th>Last Connection</th><th>Actions</th></tr>');
		for (var i = 0; i < data.length; i++) {
			var add = "<tr> \
			<td>"+data[i]['identifier']+"</td> \
			<td>"+data[i]['firstname']+" "+data[i]['lastname']+"</td> \
			<td>"+data[i]['last_connexion']+"</td> \
			<td><a href=\"#\" class=\"label label-danger\">Remove</a></td> \
			</tr>"
			$('#whitelisted table tbody').append(add);
		}
	});

}

function whitelist(action, data){
	if (action == "add"){
		var execute = "add_to_whitelist";
		data['execute'] = execute;
		$.post('/esx_webadmin/backend/functions.php', data).done(function(resp){
			console.log(resp)
			updateWhitelist();
		})
	} else if (action == "remove"){

	}
}

$(function(){
	var page = getQueryVariable("p")
	if (page == "whitelist"){
		updateWhitelist();
	}
	/* Submitting Form */
	$('#addtowhitelist').submit(function( e ){
		e.preventDefault();
		var firstname = $('#firstname').val();
		var lastname = $('#lastname').val();
		var identifier = $('#identifier').val();
		$('#firstname').val('');
		$('#lastname').val('');
		$('#identifier').val('');
		var data = {'firstname': firstname, 'lastname': lastname, 'identifier': identifier};
		whitelist("add", data);
	});
});


/* HomePage */

$(function(){
	if (getQueryVariable("p") == false){
		refreshModals();
	}
	

});


function refreshModals(){
	$.get('/esx_webadmin/backend/functions.php?return=get_modules').done(function( data ){
			

		data = JSON.parse(data);
		data = data["homepage"];
		$('#modules').html("");



		for (var key in data) {
			var add = '<div class="col-md-3 col-sm-6 col-xs-12"> \
			<div class="info-box"> \
			<span class="info-box-icon bg-'+ data[key]["color"] +'"><i class="fa '+data[key]["icon"]+'"></i></span> \
			<div class="info-box-content"> \
			<span class="info-box-text">'+ data[key]["label"] +'</span> \
			<span class="info-box-number">'+data[key]["value"]+'</span> \
			</div></div></div> \
			'
			$('#modules').append(add);

		}
	});
}


/* Profile Page */

$(function(){
	if (getQueryVariable("p") == "profile"){
		var steamid = ""
		populateProfile();
	}


});


function populateProfile(){

}