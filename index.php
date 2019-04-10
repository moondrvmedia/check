<?php
include "/home/tatevik/webapps/app-collier/check/db_connect/db_connnection.php";?>
<html>
    <head>
        <title>Check</title>
    </head>
    <body>
        <h2>Check the Telephone</h2>
        <form METHOD="POST"  id="check_phone">
           Enter the Telephone Number: <input type="text" name="phone" /> 
			<h2>Count specified rows</h2>
			Select the status: 
			<select id='status'>
				<?php
					$list = mysqli_query($conn,"SELECT DISTINCT(status) FROM `lead`");
					while ($row_ah = mysqli_fetch_assoc($list)) {
				?>
				<option value="<?php echo $row_ah['status']; ?>"><?php echo $row_ah['status']; ?></option>
				<?php 
					}
				?>		
			</select>
           <br/><br/>Select the date: <br/>
			From: <input id="date_timepicker_start" type="text" autocomplete="off" >
			To: <input id="date_timepicker_end" type="text" autocomplete="off" >
		   	<br/><br/><div id = "result"></div><br/>
           <input type="submit" value="Check"/>
        </form>		
    </body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="/jquery.datetimepicker.css"/ >
	<script src="../build/jquery.datetimepicker.full.min.js"></script>
	<script type="text/javascript">
		$(function(){
		 $('#date_timepicker_start').datetimepicker({
			 formatTime:'H',
		  onShow:function( ct ){
		   this.setOptions({
			maxDate:$('#date_timepicker_end').val()?$('#date_timepicker_end').val():false
		   })
		  },
		 });
		 $('#date_timepicker_end').datetimepicker({
		  onShow:function( ct ){
		   this.setOptions({
			minDate:$('#date_timepicker_start').val()?$('#date_timepicker_start').val():false
		   })
		  },
		 });
		});
		$("#check_phone").submit(function(event){
			event.preventDefault();
			var phone = $("input").val();
			var start = $("#date_timepicker_start").val();	
			var end = $("#date_timepicker_end").val();	
			var status = $("#status").val();
			var valid = /^[+]*[(]{0,1}[0-9]{1,3}[)]{0,1}[-\s\.\/0-9]*$/g;
			$("#result").empty();
			if((phone != '' && phone.match(valid)) || (phone == '' && start != ' '&& end != '')){
				$.ajax({
					type:'POST',
					url:'check.php',
					data: {phone:phone,start:start,end:end,status:status},
					success:function(data){						
						$("#result").append(data);
					}
				});				
			}else {
				alert('Not valid phone number');
			}
		});
	</script>

</html> 
