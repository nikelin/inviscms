<?php
# This file is part of InvisCMS .
#
#    InvisCMS is free software: you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation, either version 3 of the License, or
#    (at your option) any later version.
#
#    Foobar is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with InvisCMS.  If not, see <http://www.gnu.org/licenses/>.
?><?php
 function die_r($text){
	if(is_object($text) || is_array($text)){
		print htmlspecialchars(print_r($text,true));
	}else{
		print htmlspecialchars($text);
	}
	exit;
 }
 
 function imagecreatefrombmp( $filename )
{
    $file = fopen( $filename, "rb" );
    $read = fread( $file, 10 );
    while( !feof( $file ) && $read != "" )
    {
        $read .= fread( $file, 1024 );
    }
    $temp = unpack( "H*", $read );
    $hex = $temp[1];
    $header = substr( $hex, 0, 104 );
    $body = str_split( substr( $hex, 108 ), 6 );
    if( substr( $header, 0, 4 ) == "424d" )
    {
        $header = substr( $header, 4 );
        // Remove some stuff?
        $header = substr( $header, 32 );
        // Get the width
        $width = hexdec( substr( $header, 0, 2 ) );
        // Remove some stuff?
        $header = substr( $header, 8 );
        // Get the height
        $height = hexdec( substr( $header, 0, 2 ) );
        unset( $header );
    }
    $x = 0;
    $y = 1;
    $image = imagecreatetruecolor( $width, $height );
    foreach( $body as $rgb )
    {
        $r = hexdec( substr( $rgb, 4, 2 ) );
        $g = hexdec( substr( $rgb, 2, 2 ) );
        $b = hexdec( substr( $rgb, 0, 2 ) );
        $color = imagecolorallocate( $image, $r, $g, $b );
        imagesetpixel( $image, $x, $height-$y, $color );
        $x++;
        if( $x >= $width )
        {
            $x = 0;
            $y++;
        }
    }
    return $image;
}

if(!function_exists("imagecreatefrombmp"))
{
       function imagecreatefrombmp( $filename )
       {
	   $file = fopen( $filename, "rb" );
	   $read = fread( $file, 10 );
	   while( !feof( $file ) && $read != "" )
	   {
	       $read .= fread( $file, 1024 );
	   }
	   $temp = unpack( "H*", $read );
	   $hex = $temp[1];
	   $header = substr( $hex, 0, 104 );
	   $body = str_split( substr( $hex, 108 ), 6 );
	   if( substr( $header, 0, 4 ) == "424d" )
	   {
	       $header = substr( $header, 4 );
	       // Remove some stuff?
	       $header = substr( $header, 32 );
	       // Get the width
	       $width = hexdec( substr( $header, 0, 2 ) );
	       // Remove some stuff?
	       $header = substr( $header, 8 );
	       // Get the height
	       $height = hexdec( substr( $header, 0, 2 ) );
	       unset( $header );
	   }
	   $x = 0;
	   $y = 1;
	   $image = imagecreatetruecolor( $width, $height );
	   foreach( $body as $rgb )
	   {
	       $r = hexdec( substr( $rgb, 4, 2 ) );
	       $g = hexdec( substr( $rgb, 2, 2 ) );
	       $b = hexdec( substr( $rgb, 0, 2 ) );
	       $color = imagecolorallocate( $image, $r, $g, $b );
	       imagesetpixel( $image, $x, $height-$y, $color );
	       $x++;
	       if( $x >= $width )
	       {
		   $x = 0;
		   $y++;
	       }
	   }
	   return $image;
       }
}
 
 function wasIncluded($file){
	$incl=false;
	$file=str_replace('/','\\',$file);
 	foreach(get_included_files() as $k=>$v){
	  if($v==$file){
		 $incl=true;
		 break;
	  }
	}
	return $incl;
 }
 
 function die_br($text){
	return "<br/>".die_r($text);
 }
 
 
 function print_rbr($text){
	if(is_array($text) || is_object($text)){
     	print_r($text,true).'<br/>';
	}else{
	  print($text)."<br/>";
	}
 }
?>
