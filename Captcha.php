<?php

class Captcha {
  
	private $width = 200;
	private $height = 70;

	private $font = null;

	private $backgroundColor = array('r' => 255, 'g' => 255, 'b' => 255);

	private $minLetterAngle = -45;
	private $maxLetterAngle = 45;

	private $randomFontColor = true;

	private $fontColor = array('r' => 0, 'g' => 0, 'b' => 0);

	private $minFontSize = 25;
	private $maxFontSize = 50;

	private $randomFontSize = true;

	private $fontSize = 16;

	private $isTransparent = true;

	private $randomLines = true;

	private $linesNum = 5;
  
	public function __construct()
	{
	}
	
	public function setAngles($min = 0, $max = 45)
	{
		$this->minLetterAngle = $min;
		$this->maxLetterAngle = $max;
	}
	
	public function setFont($font = '')
	{
		$this->font = empty($font) ? $this->font : $font;
	}

	public function getFont()
	{
		return $this->font;
	}

	public function setFontColor($r = 0, $g = 0, $b = 0)
	{
		$this->fontColor['r'] = $r;
		$this->fontColor['g'] = $g;
		$this->fontColor['b'] = $b;
	}
	
	public function setFontSize($minFontSize, $maxFontSize)
	{
		$this->minFontSize  = empty($minFontSize) ? $this->minFontSize : $minFontSize;
		$this->maxFontSize = empty($maxFontSize) ? $this->maxFontSize : $maxFontSize;
	}

	public function setImageSize($width, $height)
	{
		$this->width  = empty($width) ? $this->width : $width;
		$this->height = empty($height) ? $this->height : $height;
  
	}
  
	public function setBgColor($r = 0, $g = 0, $b = 0)
	{
		$this->backgroundColor['r'] = $r;
		$this->backgroundColor['g'] = $g;
		$this->backgroundColor['b'] = $b;
	}
	
	public function setTransparent($isTransparent = true)
	{
		$this->isTransparent = $isTransparent;
	}

	public function isTransparent()
	{
		return $this->isTransparent;
	}

	public function generateCaptcha($text)
	{

		$font = $this->getFont();

		if (empty($font)) return false;
		if (!file_exists($font)) return false;
	
		$captcha = imagecreatetruecolor ($this->width, $this->height);

		$backgroundColor = imagecolorallocatealpha($captcha, $this->backgroundColor['r'], $this->backgroundColor['g'], $this->backgroundColor['b'], 127);
	  
		if ($this->isTransparent())
		{
	  
			imagealphablending( $captcha, false );
			imagesavealpha($captcha, true);

			imagefill($captcha, 0, 0, $backgroundColor);
		
			imagealphablending( $captcha, true );
	  
		}
		else
		{
			imagefill($captcha, 0, 0, $backgroundColor);  
		}
	  
		if ($this->randomLines)
		{
			for ($i=0; $i < $this->linesNum; $i++)
			{
				$lineColor = imagecolorallocate($captcha, rand(0, 255), rand(0, 255), rand(0, 255)); // Случайный цвет c изображения 
			
				imageline($captcha,
				rand(0, $this->width),
				rand(0, $this->height),
				rand(0, $this->height),
				rand(0, $this->width), 
				$lineColor);
			}
		}
	   
		$x = 20;

		$textLength = strlen($text);

		for ($i = 0; $i < $textLength; $i++)
		{

			if ($this->randomFontSize)  
			$fontSize = mt_rand($this->minFontSize, $this->maxFontSize);
			else
			$fontSize = $this->fontSize;
	  
			if ($this->randomFontColor)
			{
				$r = mt_rand(0, 255);
				$g = mt_rand(0, 255);
				$b = mt_rand(0, 255);
			}
			else
			{
				$r = $this->fontColor['r'];
				$g = $this->fontColor['g'];
				$b = $this->fontColor['b'];
			}

			$fontColor = imagecolorallocate ($captcha, $r, $g, $b);
	  
			$y = $fontSize;

			$letter = $text[$i];
		  
			$letterAngle = mt_rand($this->minLetterAngle, $this->maxLetterAngle);

			imagettftext ($captcha, $fontSize, $letterAngle, $x, $y, $fontColor, $font, $letter);
	 		
			$x = $x + $fontSize;
		}
		
		return $captcha;
	}
}

?>