
<?php
$json_data = @file_get_contents( "http://sknt.ru/job/frontend/data.json" );
$json = json_decode( $json_data, true );

?>

<!DOCTYPE html>
<html>
<head>
<title>SkyNetApp</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<script src="https://code.jquery.com/jquery-1.10.1.min.js"></script>
<link rel="stylesheet" href="tstyle.css">
</head>
<body>

<!---->
<?php foreach ($json['tarifs'] as $key => $value): ?>
<div id="<?=$key?>-b" class="button"><div class="arrow-back"></div>&nbspТариф "<?=$json['tarifs'][$key]['title']?>"</div>   
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

	<div id="<?=$json['tarifs'][$key]['tarifs'][$k]['ID']?>"  class = "second-page"> 
		<h2 class="third">Тариф "<?=$json['tarifs'][$key]['title']?>"</h2>
		<hr class="third">
		<h2><?=$json['tarifs'][$key]['tarifs'][$k]['pay_period']?>&nbsp мес.</h2>
		<hr class="sale">
		<p><b><?=($json['tarifs'][$key]['tarifs'][$k]['price'])/($json['tarifs'][$key]['tarifs'][$k]['pay_period'])?>&nbsp &#x20BD &#47 мес</b></p>
		<p>разовый платёж - <?=$json['tarifs'][$key]['tarifs'][$k]['price']?> &#x20BD<div class="arrow-forward"></div></p>
		<p class="third">со счёта спишется - <?=$json['tarifs'][$key]['tarifs'][$k]['price']?> &#x20BD</p>
		<p class="third">вступит в силу - сегодня</p>
		<p class="third">активно до - <?=gmdate("d.m.Y",(int)($json['tarifs'][$key]['tarifs'][$k]['new_payday']))?></p>

		<?php if ($json['tarifs'][$key]['tarifs'][$k]['pay_period'] != 1):?>
		
		<p class="sale">cкидка - <?=(($json['tarifs'][$key]['tarifs'][0]['price'])-($json['tarifs'][$key]['tarifs'][$k]['price'])/($json['tarifs'][$key]['tarifs'][$k]['pay_period']))*($json['tarifs'][$key]['tarifs'][$k]['pay_period'])?> &#x20BD</p>
		
		<?php endif;?>

    </div>

    <?php endforeach;?>

<?php endforeach; ?>

<script>

$('.first-page').on('click', function(){
	$('.first-page').hide();
	var $id = $(this).attr('id');	
	var $n = parseInt($id);
	for (var i = 1; i < 5; i++) {	
		$('#'+($n*4+i)).show();
	}// end for
	$('#'+$n+'-'+'b').show();
	$('.third').hide();
	$('.sale').show();

});// end function

$('.second-page').on('click', function(){
	$('.second-page').hide();
	var $id = $(this).attr('id');
	var $m = parseInt($id);
	$('#'+$m).show();
	$('.arrow-forward').hide();
	$('.sale').hide();
	$('.third').show();

});// end function

$('.button').on('click', function(){
	var $id = $(this).attr('id');
	var $b = parseInt($id);
	if ($('.second-page:visible').length != 1) {
		$('.first-page').show();
		$('.second-page').hide();
		$(this).hide();
	}else { 
		for (var i = 1; i < 5; i++) {
		$('#'+ ($b*4+i)).show();
	}//end for
	$('.arrow-forward').show();
}
});//end function

</script>
</body>
</html>