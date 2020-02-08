<?php

	include('Captcha.php');

	$captcha = new Captcha();

	$captcha->setFont('fonts/8080.ttf');

	$image = $captcha->generateCaptcha('TEXT');

	if ($image !==false)
	{
		header('Content-type: image/png');

		imagejpeg($image);
		imagedestroy($image);	
	}
	else
	{
		echo 'Ошибка генерации капчи';
	}

?>