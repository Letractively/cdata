<h1>Record locked</h1>



<h2>Another user is editing this record</h2>

<p>This record has already been opened by another user at:<br/><br/>
 <h3><?php echo date("d-m-y h:i", $time)." (".date_default_timezone_get().")";
;?></h3>
<h3><script language="javascript">
ourDate = new Date();
ourDate.setTime( <?php echo $time; ?>*1000 );
document.write("Local time is: "
+ ourDate.toLocaleString()
+ ".<br/>");
</script></h3>

<br/><br/>
It cannot be edited until released or saved by the user or after <?php echo $interval;?> minutes from the form opening.</p>

