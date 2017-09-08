<?php

/*
 *
 *  External Time Until Restart Clock/Timer
 *  Created for Arma 3 Exile Servers
 *
 *  Created by: Kurewe
 *  Website: http://cantankerousoldgoats.enjin.com/
 *
 */

include('include/dbinfo.php');

// Create connection
$conn = new mysqli($serveraddr, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT time_until_restart FROM restart_timer WHERE id = 1";
$result = $conn->query($sql);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}

$row = $result->fetch_assoc();
$timer = $row['time_until_restart'];

$zero    = new DateTime('@0');
$offset  = new DateTime('@' . $timer * 60);
$diff    = $zero->diff($offset);

$string = $diff->format('%h:%I');

/*
text to image converter
daftlogic 
www.daftlogic.com
*/
Header("Content-type: image/png");
class textPNG 
{
	var $font = 'fonts/komikatitlewide.ttf'; // customizeable True Type font. directory relative to script directory
	var $size = 32;				// font size
	var $rot = 0;					// rotation in degrees
	var $pad = 10;				// padding around image
	var $transparent = 0; // transparency 0-Off/1-On (if on, it overrides the background color settings)
	var $red = 40;				// font color - green text
	var $grn = 140;				// font color - green text
	var $blu = 0;					// font color - green text
	var $bg_red = 20;			// background color - dark grey
	var $bg_grn = 20;			// background color - dark grey
	var $bg_blu = 20;			// background color - dark grey
	
	function draw() 
	{
		$width = 0;
		$height = 0;
		$offset_x = 0;
		$offset_y = 0;
		$bounds = array();
		$image = "";
	
		// get the font height.
		$bounds = ImageTTFBBox($this->size, $this->rot, $this->font, "W");
		if ($this->rot < 0) 
		{
			$font_height = abs($bounds[7]-$bounds[1]);		
		} 
		else if ($this->rot > 0) 
		{
		$font_height = abs($bounds[1]-$bounds[7]);
		} 
		else 
		{
			$font_height = abs($bounds[7]-$bounds[1]);
		}
		// determine bounding box.
		$bounds = ImageTTFBBox($this->size, $this->rot, $this->font, $this->msg);
		if ($this->rot < 0) 
		{
			$width = abs($bounds[4]-$bounds[0]);
			$height = abs($bounds[3]-$bounds[7]);
			$offset_y = $font_height;
			$offset_x = 0;
		} 
		else if ($this->rot > 0) 
		{
			$width = abs($bounds[2]-$bounds[6]);
			$height = abs($bounds[1]-$bounds[5]);
			$offset_y = abs($bounds[7]-$bounds[5])+$font_height;
			$offset_x = abs($bounds[0]-$bounds[6]);
		} 
		else
		{
			$width = abs($bounds[4]-$bounds[6]);
			$height = abs($bounds[7]-$bounds[1]);
			$offset_y = $font_height;;
			$offset_x = 0;
		}
		
		$image = imagecreate($width+($this->pad*2)+1,$height+($this->pad*2)+1);
		$background = ImageColorAllocate($image, $this->bg_red, $this->bg_grn, $this->bg_blu);
		$foreground = ImageColorAllocate($image, $this->red, $this->grn, $this->blu);
	
		if ($this->transparent) ImageColorTransparent($image, $background);
		ImageInterlace($image, false);
	
		// render the image
		ImageTTFText($image, $this->size, $this->rot, $offset_x+$this->pad, $offset_y+$this->pad, $foreground, $this->font, $this->msg);
	
		// output PNG object.
		imagePNG($image);
		}
	}

	$text = new textPNG;

	$text->msg = $string; // text to display
	if (isset($font)) $text->font = $font; // font to use (include directory if needed).
	if (isset($size)) $text->size = $size; // size in points
	if (isset($rot)) $text->rot = $rot; // rotation
	if (isset($pad)) $text->pad = $pad; // padding in pixels around text.
	if (isset($red)) $text->red = $red; // text color
	if (isset($grn)) $text->grn = $grn; // ..
	if (isset($blu)) $text->blu = $blu; // ..
	if (isset($bg_red)) $text->bg_red = $bg_red; // background color.
	if (isset($bg_grn)) $text->bg_grn = $bg_grn; // ..
	if (isset($bg_blu)) $text->bg_blu = $bg_blu; // ..
	if (isset($tr)) $text->transparent = $tr; // transparency flag (boolean).

	$text->draw(); // GO!!!!!
?>