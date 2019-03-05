
<?php
$json_data = @file_get_contents( "http://sknt.ru/job/frontend/data.json" );
$json = json_decode( $json_data, true );
?>

<!DOCTYPE html>
<html>
<head>
<title>SkyNetApp</title>
<script src="https://code.jquery.com/jquery-1.10.1.min.js"></script>
<link rel="stylesheet" href="tstyle.css">
</head>
<body>

<!---->
<?php foreach ($json['tarifs'] as $key => $value): ?>
<div id="<?=$key?>" class="button"><div class="arrow-back"></div>&nbspТариф "<?=$json['tarifs'][$key]['title']?>"</div>   
<div id="<?=$key?>-p" class="first-page">
	
	<h2>Тариф "<?=$json['tarifs'][$key]['title']?>"</h2>
    <hr>
    <article>
    <p><span><?=$json['tarifs'][$key]['speed']?> М/б</span></p>
	<div class="arrow-forward"></div>
	<?php if ($key != 0):?>
    <?php foreach ($json['tarifs'][$key]['free_options'] as $ke => $value):?>

		<p><?=$json['tarifs'][$key]['free_options'][$ke]?></p>

   <?php endforeach;?>
<?php endif;?>
	</article>
	<hr>
	<a href='<?=$json['tarifs'][$key]['link']?>'>узнать подробнее на сайте www.sknt.ru</a>
</div>


	<?php foreach ($json['tarifs'][$key]['tarifs'] as $k => $value): ?>
		
	<div id="<?=$key?>-p-<?=$k?>"  class = "second-page"> 

		<h2><?=$json['tarifs'][$key]['tarifs'][$k]['title']?></h2>
		<hr>

		<p><?=$json['tarifs'][$key]['tarifs'][$k]['price']?><div class="arrow-forward"></div></p>
		<p><?=$json['tarifs'][$key]['tarifs'][$k]['speed']?></p>

    </div>

    <?php endforeach;?>

<?php endforeach; ?>

<script>

$('.first-page').on('click', function(){
	$('.first-page').hide();
	var $id = $(this).attr('id');	
	var $n = parseInt($id);
	for (var i = 0; i < 4; i++) {	
		$('#'+$id+'-'+i).show();
	}// end for
	$('#'+$n).show();
});// end function

$('.second-page').on('click', function(){
	$('.second-page').hide();
	var $id = $(this).attr('id');
	$('#'+$id).show();
	
});// end function

$('.button').on('click', function(){
	var $id = $(this).attr('id');
	if ($('.second-page:visible').length != 1) {
		$('.first-page').show();
		$('.second-page').hide();
		$(this).hide();
	}else { 
		for (var i = 0; i < 4; i++) {
		$('#'+ $id + '-p-'+i).show();

	}//end for
}
});//end function

</script>
</body>
</html>