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



$(function(){
	var page = getQueryVariable("p")

	if (page == "whitelist"){
		updateWhitelist();
	}




	$('#addtowhitelist').click(function(){
		var firstname = $('#firstname').val();
		var lastname = $('#lastname').val();
		var identifier = $('#identifier').val();

		$('#firstname').val('');
		$('#lastname').val('');
		$('#identifier').val('');


		$.post('/esx_webadmin/backend/functions.php?execute=add_to_whitelist', {'firstname': firstname, 'lastname': lastname, 'identifier': identifier}).done(function(resp){
			updateWhitelist();
		})


	});


});