<!DOCTYPE html>
<html>
<head>
	<title>TV Licence Checker</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css">


	<script  src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.css">


	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
</head>
<body>

	<div class="container">
		<header>
			<h3>TV Licence Required</h3>
		</header>

		<p>Your cart contains item(s) that require a valid TV licence. Please enter your licence details below to continue.</p>

		<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<form method="POST" id="tvcheck">
					<div class="form-group">
                          <label class="control-label">Licence Type : </label>
                          <select id="licencetype" name="licencetype" class="form-control">
                          	<option value=""></option>
                          	<option value="business">Business</option>
                          	<option value="domestic">Domestic</option>
                          	<option value="dealer">Dealer</option>
                          </select>
					</div>
					<div id="extras"></div>


					<div class="form-group">
						<button type="submit" class="btn  btn-primary" id="btnsubmit">Submit</button>
					</div>

					<div id="results"></div>
				</form>
			</div>
		</div>

	</div>

	<script type="text/javascript">
		$('document').ready(function(){

			$('#licencetype').select2({placeholder:"Please Select Licence Type"});

			$('#licencetype').on('change',function(){

				var type = $(this).val();
				switch (type){
					case 'business':
					$('#extras').html('<div class="form-group"><label class="control-label">Company Registration Number</label><input type="text" name="reg_num" placeholder="Company Registration Number" class="form-control"></div>');
					$('#extras').append('<div class="form-group"><label class="control-label">TV Licence Number</label><input type="text" name="tvlicence" placeholder="Enter TV Licence Number" class="form-control"></div>');

					break;

					case 'domestic':
					$('#extras').html('<div class="form-group"><label class="control-label">Licence Holder ID</label><input type="text" name="holder_id" placeholder="Enter Licence Holder ID Number" class="form-control">');

					break ;

					case 'dealer':
					$('#extras').html('<div class="form-group"><label class="control-label">Company Registration Number</label><input type="text" name="reg_num" placeholder="Company Registration Number" class="form-control"></div>');
					$('#extras').append('<div class="form-group"><label class="control-label">TV Licence Number</label><input type="text" name="tvlicence" placeholder="Enter TV Licence Number" class="form-control"></div>');
					break;

					default : 

					$('#extras').empty();
				}


			});
			$('#tvcheck').validate({
				ignore : [],

				rules :{

					licencetype : {required:true},
					holder_id : {required:true},
					reg_num   : {required:true},
					tvlicence : {required:true}
				},
				messages : {
					licencetype : {required:"Please Select licence type"},
					holder_id  : {required:"Please enter licence holder's ID"},
					reg_num : {required:"Please enter Company registration number"},
					tvlicence: {required: "Please enter licence number"}
				},
				submitHandler : verifyLicence

			});

			function verifyLicence(){

				var formdata = $('#tvcheck').serialize();
				$.ajax({

					type : "POST",
					url  : "licence.php",
					data : formdata,
					dataType : "json",
					encode : true,
					beforeSend : function(){
						$('#btnsubmit').html('Processing...');
					},
					success : function(response){

						// console.log(response);
						$('#btnsubmit').html('Complete');
						var results = response.GetAccountResult.Header.Status.StatusCode;

							alert(results);

						switch(results){
							case '-4':
							$('#results').html('<div class="alert alert-danger">No TV licence found for your ID. <a href="https://paynow.tvlic.co.za/register.jsp" target="_blank">Apply for a TV Licence.</a></div>');
							break;

							case '-1' :

							$('#results').html('<div class="alert alert-danger">General Error</div>');
							break;

							case '-2':
							$('#results').html('<div class="alert alert-danger">Invalid API key</div>');
							break;

							case '0':

								$('#results').html('<div class="alert alert-success">Success valid tv licence, now we can checkout</div>');
								break;
						}
					},
					error: function(jqXHR, exception) {
						$('#btnsubmit').html('Complete');
			            if (jqXHR.status === 0) {
			                alert('Not connect.\n Verify Network.');
			            } else if (jqXHR.status == 404) {
			                alert('Requested page not found. [404]');
			            } else if (jqXHR.status == 500) {
			                alert('Internal Server Error [500].');
			            } else if (exception === 'parsererror') {
			                alert('Not connect.\n Verify Network..');
			            } else if (exception === 'timeout') {
			                alert('Time out error.');
			            } else if (exception === 'abort') {
			                alert('Ajax request aborted.');
			            } else {
			                alert('Uncaught Error.\n' + jqXHR.responseText);
			            }
			        }
				});
				return false;	
			}
		});
	</script>
	<style type="text/css">
		.error{
			color: #f00;
		}
	</style>
</body>
</html>