<?php
// get data
$json_data = file_get_contents( 'http://sknt.ru/job/frontend/data.json' );
$json = json_decode( $json_data, true);
foreach ($json['tarifs'] as $key => $tarifs) {
	usort($json['tarifs'][$key]['tarifs'], function ($item1, $item2) {	
		if ($item1['ID'] === $item2['ID']) return 0;
		return $item1['ID'] < $item2['ID'] ? -1 : 1;
	});
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>SkyNetApp</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="conteiner">
<?php foreach ($json['tarifs'] as $key => $tarifs): ?>
<?php
	$title = $tarifs['title'];
	$speed = $tarifs['speed'];
	$link = $tarifs['link'];

	if ($key !=0) {
		$free_options = $tarifs['free_options'];
	} 
	else 
		$free_options = [];

	foreach ($tarifs['tarifs'] as $tarif) {
		$min_max_arr[$key][] = ($tarif['price'])/($tarif['pay_period']);
		$max = max($min_max_arr[$key]);
		$min = min($min_max_arr[$key]);
	}
?>
		<!-- Main Button -->
		<div id="button_<?= $key ?>" class="main-button">
			<div class="arrow-left"></div>
			<div class="main-button__tarif">Тариф "<?= $title ?>"</div>
			<div class="main-button__select">Выбор тарифа</div>		  
		</div>
		<!--End Main Button -->	

		<!-- First Screen -->		
		<div id="first-page_<?= $key ?>" class="first-page">
			<div class="first-page__header">
				<div class="header">Тариф "<?= $title ?>"</div>
		    	<hr>
		    </div>
		    <div class="first-page__section">
		    	<span class="speed"><?= $speed ?> Мбит&#47;c</span>	
				<div class="min-max-price"><?= $min ?> - <?= $max ?> &#x20BD;&#47;мес</div>
				<div class="arrow-right"></div>			
				<div class="free-options"><?= implode('<br>', $free_options) ?></div>		
			</div>
			<div class="first-page__footer">
				<hr>
				<a class="link" href="<?= $link ?>">узнать подробнее на сайте www.sknt.ru</a>
			</div>		
		</div>
		<!--End First Screen -->

	<?php foreach ($tarifs['tarifs'] as $k => $tarif): ?>
	<?php
		$pay_period = $tarif['pay_period'];
		$price = $tarif['price'];
		$price_in_month = $price/$pay_period;
		$sale = ($max-$price_in_month)*($pay_period);
		$new_payday = $tarif['new_payday'];	 
		$id = $tarif['ID'];
		
		if ($pay_period == 1) {
			$ending = "";
		} elseif ($pay_period == 3) {
			$ending = "а";
		} else {
			$ending = "ев";
		}

		if ($pay_period == 1) {
			$sale = "";
		} else {
			$sale = "скидка - $sale &#x20BD;";
		}
	?>

		<!-- Second Screen -->
		<div id="second-page_<?= $key.'_'.$k ?>" class="second-page"> 
			<div class="second-page__header">			
				<b class="header"><?= $pay_period ?> месяц<?= $ending ?></b>			
				<hr>
			</div>
			<div class="arrow-right"></div>
			<div class="second-page__section">
				<div class="price-in-month">
					<b><?= $price_in_month ?> &#x20BD;&#47;мес</b>
				</div>			
				<div class="one-time-payment">разовый платёж - <?= $price ?> &#x20BD;</div>
				<div class="sale"><?= $sale ?></div>
			</div>	
		</div>
	    <!-- End Second Screen -->

	    <!-- Third Screen -->
	    <div id="third-page_<?= $key.'_'.$k ?>" class="third-page">
	    	<div class="third-page__header">
	    		<div class="header">Тариф "<?= $title ?>"</div>
	    		<hr>
	    	</div>
	    	<div class="third-page__section">
		    	<div class="payment-period">		
					<b>Период оплаты - <?= $pay_period ?> месяц<?= $ending ?></b>
				</div>
				<div class="one-time-payment">разовый платёж - <?= $price ?> &#x20BD;</div>
				<div class="charge-off">со счёта спишется - <?= $price ?> &#x20BD;</div>
				<div class="opacity-text">
					<div>вступит в силу - сегодня</div>
					<div>активно до - <?= gmdate("d.m.Y",(int)($new_payday)) ?></div>
				</div>
			</div>
			<div class="third-page__footer">
				<hr>
				<div class="button-select">Выбрать</div>
			</div>
	    </div>
	    <!-- End Third Screen -->
    <?php endforeach;?>    	
<?php endforeach;?>
	</div>
<script src="main.js"></script>
</body>
</html>
