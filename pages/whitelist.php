<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Whitelist
    <small>Add or remove players from whitelist</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Whitelist</li>
  </ol>
</section>

 <!-- Main content -->
<section class="content">
	<div class="row">
	<div class="col-xs-12">
		<div class="box box-success">
			<div class="box-header">
				<h3 class="box-title">Add a player to whitelist</h3>
			</div>
			<div class="box-body">
				<div class="row">
				<div class="col-xs-3">
                	<input type="text" class="form-control" placeholder="First Name">
                </div>
				<div class="col-xs-3">
                	<input type="text" class="form-control" placeholder="Last Name">
                </div>
				<div class="col-xs-5">
                	<input type="text" class="form-control" placeholder="Steam ID">
                </div>
                <div class="col-xs-1">
                  <button type="button" class="btn btn-success" style="width: 100%;">Add</button>
                </div>
                </div>
			</div>
		</div>
	</div>



	<div class="col-xs-12">
		<div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Whitelist</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div id="whitelisted">
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Last Connection</th>
                  <th>Actions</th>
                </tr>

                

                
              </tbody></table>
            </div>
            </div>
            <!-- /.box-body -->
          </div>
	</div>
	</div>
</section>


<script type="text/javascript">

	


	/*$.get('/url').done(function( data ){

		for (var i = 0; i < data.length; i++) {
			var add = "<tr> \
			<td>"+data[i]['id']+"</td> \
			<td>"+data[i]['firstname']+" "+data[i]['lastname']+"</td> \
			<td>"+data[i]['last_connexion']+"</td> \
			<td><a href=\"#\" class=\"label label-danger\">Remove</a></td> \
			</tr>"


			$('#whitelisted').append(add);

			//data[i]
		}






	});*/
	
</script>