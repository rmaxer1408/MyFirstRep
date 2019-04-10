
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
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>SkyNetApp</title>
	<script  src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
  crossorigin="anonymous"></script>
	<link rel="stylesheet" href="style.css">
	</head>
<body>
	<div class="conteiner">
<?php foreach ($json['tarifs'] as $key => $value): ?>

	<div id="<?=$key?>-b" class="button"><div class="arrow-left"></div>
		<div>
			<div class="hidT">&nbsp; &nbsp; Тариф "<?=$json['tarifs'][$key]['title']?>"</div>
			<div class="choT">&nbsp; &nbsp; Выбрать тариф</div>
		</div>   
	</div>

	<div id="<?=$key?>-pg" class="first-page">
		<div class="header">Тариф "<?=$json['tarifs'][$key]['title']?>"</div>
	    <hr>
	    <div class="article">
	    <span class="speed"><?=$json['tarifs'][$key]['speed']?> Мбит&#47;c</span>
    
	<?php 
	$max = ($json['tarifs'][$key]['tarifs'][0]['price'])/($json['tarifs'][$key]['tarifs'][0]['pay_period']);
	$min = ($json['tarifs'][$key]['tarifs'][3]['price'])/($json['tarifs'][$key]['tarifs'][3]['pay_period']);
	?>

		<div class="price"><?=$min?> - <?=$max?> &#x20BD;&#47;мес</div>
		<div class="arrow-right"></div>
	
	<?php if ($key != 0):?>
    	<?php foreach ($json['tarifs'][$key]['free_options'] as $ke => $value):?>

			<div class="free-options"><?=$json['tarifs'][$key]['free_options'][$ke]?></div>

    	<?php endforeach;?>
	<?php endif;?>

		</div>
		<hr>
		<div class="link">
			<a href="<?=$json['tarifs'][$key]['link']?>">узнать подробнее на сайте www.sknt.ru</a>
		</div>
	</div>

	<?php foreach ($json['tarifs'][$key]['tarifs'] as $k => $value): ?>
		
	<div id="<?=$json['tarifs'][$key]['tarifs'][$k]['ID']?>" class = "second-page"> 
		<div class="third header">Тариф "<?=$json['tarifs'][$key]['title']?>"</div>
		<hr class="third">
		<div>
			<span class="third"><b class="period">Период оплаты - </b></span>
		
		<?php if ($json['tarifs'][$key]['tarifs'][$k]['pay_period'] == 1) {
			$a = "";
		} elseif ($json['tarifs'][$key]['tarifs'][$k]['pay_period'] == 3) {
			$a = "а";
		} else {
			$a = "ев";
		}?>
			<span class="pay-period">
				<b><?=$json['tarifs'][$key]['tarifs'][$k]['pay_period']?> месяц<?= $a ?></b>
			</span>
		</div>	
		<hr class="sale">
		<div class="period-block">
			<b><?=($json['tarifs'][$key]['tarifs'][$k]['price'])/
			($json['tarifs'][$key]['tarifs'][$k]['pay_period'])?> &#x20BD;&#47;мес</b>
		</div>
		<div class="arrow-right"></div>
		<div class="once-pay">разовый платёж - 
			<?=$json['tarifs'][$key]['tarifs'][$k]['price']?> &#x20BD;
		</div>
				<div class="third">со счёта спишется - 
					<?=$json['tarifs'][$key]['tarifs'][$k]['price']?> &#x20BD;
				</div>
		<div class="opac">
				<div class="third">вступит в силу - сегодня</div>
				<div class="third">активно до - 
				<?=gmdate("d.m.Y",(int)($json['tarifs'][$key]['tarifs'][$k]['new_payday']))?>
				</div>
		</div>
				
		<?php if ($json['tarifs'][$key]['tarifs'][$k]['pay_period'] != 1):?>
		
		<div class="sale">cкидка - <?=(($json['tarifs'][$key]['tarifs'][0]['price'])-
			($json['tarifs'][$key]['tarifs'][$k]['price'])/
			($json['tarifs'][$key]['tarifs'][$k]['pay_period']))*
			($json['tarifs'][$key]['tarifs'][$k]['pay_period'])?> &#x20BD;
		</div>
		
		<?php endif;?>	

			<hr class="third">
			<div class="third btn-choose">Выбрать</div>
    </div>

    <?php endforeach;?>
<?php endforeach; ?>

	</div>

<script>

$('#0-pg .speed').css('background-color', '#70603E');
$('#1-pg .speed').css('background-color', '#0075D9');
$('#2-pg .speed').css('background-color', '#EE4700');
$('#3-pg .speed').css('background-color', '#0075D9');
$('#4-pg .speed').css('background-color', '#EE4700');

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
	$('.arrow-right').hide();
	$('.sale').hide();
	$('.third').show();
	$('.choT').show();
	$('.hidT').hide();
	$('.pay-period').removeClass('header');
	$('.second-page').addClass('result');

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
	$('.arrow-right').show();
	$('.third').hide();
	$('.sale').show();
	$('.choT').hide();
	$('.hidT').show();
	$('.pay-period').addClass('header');
	$('.second-page').removeClass('result');
	}
});//end function
</script>
</body>
</html>