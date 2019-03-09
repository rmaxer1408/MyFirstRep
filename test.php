
<?php
// get data
$json_data = @file_get_contents( "http://sknt.ru/job/frontend/data.json" );
$json = json_decode( $json_data, true );
// sort array
	usort($json['tarifs'][0]['tarifs'], function ($item1, $item2) {	
		if ($item1['ID'] == $item2['ID']) return 0;
    	return $item1['ID'] < $item2['ID'] ? -1 : 1;
	});
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
<div class="conteiner">

<?php foreach ($json['tarifs'] as $key => $value): ?>

<div id="<?=$key?>-b" class="button"><div class="arrow-back"></div>
	<div>
		<div class="hidT">&nbsp &nbsp Тариф "<?=$json['tarifs'][$key]['title']?>"
		</div>
		<div class="choT">&nbsp &nbsp Выбрать тариф</div>
	</div>   
</div>
<div id="<?=$key?>-p" class="first-page">
	<div class="header">Тариф "<?=$json['tarifs'][$key]['title']?>"</div>
    <hr>
    <div class="article">
    <div><span class="speed"><?=$json['tarifs'][$key]['speed']?> М/б</span></div>
	<div class="arrow-forward"></div>
	
	<?php if ($key != 0):?>
    	<?php foreach ($json['tarifs'][$key]['free_options'] as $ke => $value):?>

		<div class="free-options"><?=$json['tarifs'][$key]['free_options'][$ke]?></div>

    	<?php endforeach;?>
	<?php endif;?>

	</div>
	<hr>
	<a href='<?=$json['tarifs'][$key]['link']?>'>узнать подробнее на сайте www.sknt.ru</a>
</div>


	<?php foreach ($json['tarifs'][$key]['tarifs'] as $k => $value): ?>
		
	<div id="<?=$json['tarifs'][$key]['tarifs'][$k]['ID']?>"  class = "second-page"> 
		<div class="third header">Тариф "<?=$json['tarifs'][$key]['title']?>"</div>
		<hr class="third">
		<span class="third"><b class="period">Период оплаты - </b></span>
		<?php if ($json['tarifs'][$key]['tarifs'][$k]['pay_period'] == 1) {
			$a = "";
		} elseif ($json['tarifs'][$key]['tarifs'][$k]['pay_period'] == 3) {
			$a = "а";
		} else {
			$a = "ев";
		}
		?>
		<span class="pay-period"><b><?=$json['tarifs'][$key]['tarifs'][$k]['pay_period']?> месяц<?= $a ?></b></span>
		<hr class="sale">
		<p>
			<b><?=($json['tarifs'][$key]['tarifs'][$k]['price'])/($json['tarifs'][$key]['tarifs'][$k]['pay_period'])?>
				&nbsp &#x20BD &#47 мес</b>
		</p>
		<p>разовый платёж - <?=$json['tarifs'][$key]['tarifs'][$k]['price']?> &#x20BD
		<div class="arrow-forward"></div>
		</p>
		<p class="third">со счёта спишется - <?=$json['tarifs'][$key]['tarifs'][$k]['price']?> &#x20BD</p>
		<div class="opac">
			<p class="third">вступит в силу - сегодня</p>
			<p class="third">активно до - <?=gmdate("d.m.Y",(int)($json['tarifs'][$key]['tarifs'][$k]['new_payday']))?></p>
		</div>

		<?php if ($json['tarifs'][$key]['tarifs'][$k]['pay_period'] != 1):?>
		
			<p class="sale">cкидка - <?=(($json['tarifs'][$key]['tarifs'][0]['price'])-
			($json['tarifs'][$key]['tarifs'][$k]['price'])/($json['tarifs'][$key]['tarifs'][$k]['pay_period']))*
			($json['tarifs'][$key]['tarifs'][$k]['pay_period'])?> &#x20BD</p>
		
		<?php endif;?>

		<div class="third" type="button">Выбрать</div>
    </div>

    <?php endforeach;?>
<?php endforeach; ?>

</div>

<script>
$('#0-p .speed').css('background-color','grey');
$('#1-p .speed').css('background-color','lightblue');
$('#2-p .speed').css('background-color','orange');
$('#3-p .speed').css('background-color','lightblue');
$('#4-p .speed').css('background-color','orange');

 
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
	$('.pay-period').addClass('header');

});// end function

$('.second-page').on('click', function(){
	$('.second-page').hide();
	var $id = $(this).attr('id');
	var $m = parseInt($id);
	$('#'+$m).show();
	$('.arrow-forward').hide();
	$('.sale').hide();
	$('.third').show();
	$('.choT').show();
	$('.hidT').hide();
	$('.pay-period').removeClass('header');

});// end function

$('.button').on('click', function(){
	var $id = $(this).attr('id');
	var $b = parseInt($id);
	if ($('.second-page:visible').length != 1) {
		$('.first-page').show();
		$('.second-page').hide();
		$(this).hide();
		$('.choT').hide();
		$('.hidT').show();
	}else { 
		for (var i = 1; i < 5; i++) {
		$('#'+ ($b*4+i)).show();
	}//end for
	$('.arrow-forward').show();
	$('.third').hide();
	$('.sale').show();
	$('.choT').hide();
	$('.hidT').show();
	$('.pay-period').addClass('header');
	}
});//end function
</script>
</body>
</html>