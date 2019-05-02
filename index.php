<?php
// get data
$json_data = file_get_contents( 'http://sknt.ru/job/frontend/data.json' );
$json = json_decode( $json_data, true);
	usort($json['tarifs'][0]['tarifs'], function ($item1, $item2) {	
		if ($item1['ID'] === $item2['ID']) return 0;
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
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
  			integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
  			crossorigin="anonymous">
  	</script>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="conteiner">
<?php foreach ($json['tarifs'] as $key => $tarifs): ?>
	<?php
		$title = $tarifs['title'];
		$speed = $tarifs['speed'];
		$link = $tarifs['link'];?>
		<!-- Main Button -->
		<div id="<?= $key ?>-button" class="button">
			<div class="arrow-left"></div>
			<div>
				<div class="tarif">Тариф "<?= $title ?>"</div>
				<div class="third">Выбор тарифа</div>
			</div>   
		</div>
		<!--End Main Button -->

		<!-- First Screen -->		
		<div id="<?= $key ?>-page" class="first-page">
			<div class="header">Тариф "<?= $title ?>"</div>
		    <hr>
		    <div class="article">
		    <span class="speed"><?= $speed ?> Мбит&#47;c</span>
			<?php foreach ($tarifs['tarifs'] as $min_max) {
			$min_max_arr[$key][] = ($min_max['price'])/($min_max['pay_period']);
			$max = max($min_max_arr[$key]);
			$min = min($min_max_arr[$key]);
			}?>
			<div class="price"><?= $min ?> - <?= $max ?> &#x20BD;&#47;мес</div>
			<div class="arrow-right"></div>
			<?php if ($key != 0):?>
			<?php foreach ($tarifs['free_options'] as $free_options):?>
			<div class="free-options"><?= $free_options ?></div>
	    	<?php endforeach;?>
			<?php endif;?>
			</div>
			<hr>
			<div class="link">
				<a href="<?= $link ?>">узнать подробнее на сайте www.sknt.ru</a>
			</div>
		</div>
		<!--End First Screen -->
	<?php foreach ($tarifs['tarifs'] as $tarif): ?>
		<?php
			$pay_period = $tarif['pay_period'];
			$price = $tarif['price'];
			$new_payday = $tarif['new_payday'];	 
			$id = $tarif['ID'];
		?>	
		<!-- Second Screen -->
		<div id="<?= $id ?>" class = "second-page"> 
			<div class="third header">Тариф "<?= $title ?>"</div>
			<hr class="third">
			<div>
				<span class="third">
					<b class="period">Период оплаты - </b>
				</span>			
		<?php if ($pay_period == 1) {
			$ending = "";
		} elseif ($pay_period == 3) {
			$ending = "а";
		} else {
			$ending = "ев";
		}?>
				<span class="pay-period">
					<b><?= $pay_period ?> месяц<?= $ending ?></b>
				</span>
			</div>	
			<hr class="sale">
			<div class="period-block">
				<b><?= ($price)/($pay_period) ?> &#x20BD;&#47;мес</b>
			</div>
			<div class="arrow-right"></div>
			<div class="once-pay">разовый платёж - <?= $price ?> &#x20BD;</div>
			<div class="third">со счёта спишется - <?= $price ?> &#x20BD;</div>
			<div class="opac third">
				<div>вступит в силу - сегодня</div>
				<div>активно до - <?= gmdate("d.m.Y",(int)($new_payday)) ?></div>
			</div>					
		<?php if ($pay_period != 1):?>			
			<div class="sale">cкидка - 
			<?= (($tarifs['tarifs'][0]['price'])-($price)/($pay_period))*($pay_period) ?> &#x20BD;
			</div>			
		<?php endif;?>
			<hr class="third">
			<div class="third btn-choose">Выбрать</div>
	    </div>
		<!-- End Second Screen -->
    <?php endforeach;?>
<?php endforeach; ?>
	</div>
<script>
$(window).on('load', function(){

$('#0-page .speed').css('background-color', '#70603E');
$('#1-page .speed').css('background-color', '#0075D9');
$('#2-page .speed').css('background-color', '#EE4700');
$('#3-page .speed').css('background-color', '#0075D9');
$('#4-page .speed').css('background-color', '#EE4700');

$('.first-page').on('click', function(){
	$('.first-page').hide();
	var $id = $(this).attr('id');	
	var $n = parseInt($id);
	for (var i = 1; i < 5; i++) {	
		$('#'+($n*4+i)).show();
	}// end for
	$('#'+$n+'-'+'button').show();
	$('.tarif').show();
	$('.third').hide();
	$('.sale').show();
	$('.pay-period').addClass('header');
});// end function

$('.second-page').on('click', function(){
	var $id = $(this).attr('id');
	var $m = parseInt($id);
	$('.second-page').hide();	
	$('#'+$m).show();
	$('.arrow-right').hide();
	$('.sale').hide();
	$('.tarif').hide();
	$('.third').show();	
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
	}
	else {
		for (var i = 1; i < 5; i++) {
		$('#'+ ($b*4+i)).show();
	}//end for
	$('.arrow-right').show();
	$('.tarif').show();
	$('.third').hide();
	$('.sale').show();	
	$('.pay-period').addClass('header');
	$('.second-page').removeClass('result');
	}
});//end function
});
</script>
</body>
</html>
