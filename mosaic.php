<?php

require_once __DIR__."/vendor/autoload.php";

$filename = $argv[1] or die("Please give a filename as argument.\n");
if(!file_exists($filename)) {
	die("File $filename does not exist.\n");
}

class Mosaic {

	private $imagine;
	private $images;

	private $img_order = array(
		"TL" => array(0,1,2,3),
		"TR" => array(1,0,3,2),
		"BL" => array(2,3,0,1),
		"BR" => array(3,2,1,0),
	);

	public function __construct($imagine, $srcImage) {
		$this->imagine = $imagine;
		$this->images = array(
			$imagine->open($srcImage),
			$imagine->open($srcImage)->flipVertically(),
			$imagine->open($srcImage)->flipHorizontally(),
			$imagine->open($srcImage)->flipVertically()->flipHorizontally()
		);
	}

	public function getMosaicImage($type) {
		$size = $this->images[0]->getSize();
		$newSize = $size->scale(2);
		$newImage = $this->imagine->create($newSize);
		$indexes = $this->img_order[$type];
		$newImage->paste($this->images[$indexes[0]], new Imagine\Image\Point(0,0));
		$newImage->paste($this->images[$indexes[1]], new Imagine\Image\Point(0,$size->getHeight()));
		$newImage->paste($this->images[$indexes[2]], new Imagine\Image\Point($size->getWidth(),0));
		$newImage->paste($this->images[$indexes[3]], new Imagine\Image\Point($size->getWidth(),$size->getHeight()));
		return $newImage;
	}
}

$pi = pathinfo($filename);
$name_pattern = "{$pi['dirname']}/{$pi['filename']}_%s.{$pi['extension']}";

$m = new Mosaic(new Imagine\Imagick\Imagine(), $filename);
$m->getMosaicImage("TL")->save(sprintf($name_pattern, "top_left"));
$m->getMosaicImage("TR")->save(sprintf($name_pattern, "top_right"));
$m->getMosaicImage("BL")->save(sprintf($name_pattern, "bottom_left"));
$m->getMosaicImage("BR")->save(sprintf($name_pattern, "bottom_right"));



