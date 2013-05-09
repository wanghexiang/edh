<?php     
/*
ͼƬ���� 
����ͼ����ˮӡ
*/
class image{

function __construct(){
}
/**
����ͼ����
*/
function makethumb($dstimg,$img,$dstw,$dsth,$all=false)
{
	if(!file_exists($img))
	{
		return false;
	}
	list($width,$height) = getimagesize($img);
	
	$percent=$dstw/$width;
	
	
	$new_width = $width * $percent;
	$new_height = $height * $percent;
	if($all){
		$new_width=$dstw;
		$new_height=$dsth;
		if($height>$width){
			$height=$width;
		}else{
			$width=$height;
		}
	}
	$im = imagecreatetruecolor($new_width, $new_height);
	$imgtype=$this->getimgtype($img);
	$image = $this->imagecreatefrom($img,$imgtype);
	imagecopyresampled($im, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	
	$this->imagesave($im, $dstimg,$imgtype);

}


/**
����ˮӡ
*/
function addwater($dstimg,$warterpos=9,$img='',$str="����һ��",$size=16,$font="includes/���������.ttf",$color="#FF6000")
{
	if(!file_exists($dstimg))
	{
		return false;
	}
	$str=iconv("GB2312","utf-8",$str);
	
	list($dw,$dh)=getimagesize($dstimg);	
	$dsttype=$this->getimgtype($dstimg);
	$dstim=$this->imagecreatefrom($dstimg,$dsttype);
	if(!empty($img))
	{
	//ˮӡͼƬ
	list($w,$h)=getimagesize($img);
	$imgtype=$this->getimgtype($img);
	$im=$this->imagecreatefrom($img,$imgtype);	
	}else
	{
		$temp=@imagettfbbox($size,0,$font,$str);
		
		$w=$temp[2]-$temp[6];
		$h=$temp[3]-$temp[7];
				
	}
	if(($dw<$w) || ($dh<$h))
	{
		echo "<script>alert('��Ҫ��ˮӡ��ͼƬ��ˮӡС���޷���ˮӡ');</script>";
		
		return false;
	}
	switch($warterpos)
	{
		case 0://���
			$posX=rand(0,($dw-$w));
			$posY=rand(0,($dh-$h));	
			break;
		case 1://����
			if($img)
			{
			$posX=0;
			$posY=0;
			}else
			{
			$posX=0;
			$posY=$h;
			}
			
			break;
		case 2://����
			if($img)
			{
			$posX=($dw-$w)/2;
			$posY=0;
			}else
			{
			$posX=($dw-$w)/2;
			$posY=$h;
			}
			break;
		case 3://����
			if($img)
			{
			$posX=$dw-$w;
			$posY=0;
			}else
			{
			$posX=$dw-$w;
			$posY=$h;
				
			}
			break;
		case 4://����
			$posX=0;
			$posY=($dh-$h)/2;
			break;
		case 5://����
			$posX=($dw-$w)/2;
			$posY=($dh-$h)/2;
			break;
		case 6://����
			$posX=$dw-$w;
			$posY=($dh-$h)/2;
			break;
		case 7://����
			$posX=0;
			$posY=$dh-$h;
			break;
		case 8://����
			$posX=($dw-$w)/2;
			$posY=$dh-$h;
			break;
		case 9://����
			$posX=$dw-$w;
			$posY=$dh-$h;
			break;
		default://���
			$posX=rand(0,($dw-$w));
			$posY=rand(0,($dh-$h));	
			break;		
	}
	imagealphablending($dstim,true);
	if(!empty($img))
	{
		//����ͼƬˮӡ
		imagecopy($dstim,$im,$posX,$posY,0,0,$w,$h);
	}else
	{
		//��������ˮӡ
		if(!empty($color) && (strlen($color)==7))
		{
			$R=hexdec(substr($color,1,2));
			$G=hexdec(substr($color,3,2));
			$B=hexdec(substr($color,5));
		}else
		{
			$R=$G=$B="00";
		}
		$grey=imagecolorallocate($dstim,$R,$G,$B);
		@imagettftext($dstim,$size,0,$posX,$posY,$grey,$font,$str);
		
		
		
	}
	$this->imagesave($dstim,$dstimg,$dsttype);
	
}

//��ȡͼƬ��׺
function getimgtype($img)
{
	$im=getimagesize($img);
	switch($im['mime'])
	{
			case 'image/gif':
			return 'gif';
			break;
			case 'image/bmp':
			case "image/x-ms-bmp":
			return 'bmp';
			break;
			case "image/jpeg":
			return 'jpg';
			break;
			case 'image/png':
			return 'png';
			break;
			default:
			return '';
		}
}


//���ͼ��
function imagesave($im,$dstimg='',$imgtype='jpeg')
{
	switch($imgtype)
	{
		case "gif":
				imagegif($im,$dstimg);
				break;	
		case "jpg":
				imagejpeg($im,$dstimg,100);
				break;
		case "png":
				imagepng($im,$dstimg);
				break;
		case "bmp":
				imagewbmp($im,$dstimg);
				break;
				
	}
}

function imagecreatefrom($img,$imgtype)
{
	switch($imgtype)
	{
		case 'gif':
			return imagecreatefromgif($img);
		break;
		case "jpg":
			return imagecreatefromjpeg($img);
		break;
		case "png":
			return imagecreatefrompng($img);
		break;
		case 'bmp':
			return imagecreatefromwbmp($img);
		break;
	}
}

}
/*
����

$img=new image();
$img->addwater("1.jpg",9,'2.jpg');
*/
?>