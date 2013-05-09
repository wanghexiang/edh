<?php
class upload{
	public $allowtype=array("gif","jpg","bmp","png",'jpeg');//允许上传的文件类型
	private $sysallowtype=array('gif','jpg','bmp','png','jpeg','txt','mpeg','avi','rm','rmvb','wmv','flv','mp3','wav','wma','swf','doc','pdf','zip','tar');
	//系统默认允许上传
	//上传文件夹
	public $uploaddir="uploads/";
	public $maxsize=4194304;
	//是否图片上传
	public $upimg=true;
	
	function __construct()
	{
		
	}
	
	function uploadfile($file)
	{
		$FILE=$_FILES[$file];
		//判断文件大小是否符合要求
		if($FILE['size'] > $this->maxsize) {
			@unlink($FILE['tmp_name']);
			return array('err'=>'上传文件过大','filename'=>'');
		}
		
		$uploaddir=$this->uploaddir.date("Y/m/d")."/";
		$this->umkdir($uploaddir);
		
		if($this->upimg==true)
		{
			$fs=getimagesize($FILE['tmp_name']);
			if($fs[0]<5 || $fs[1]<5)
			{
				@unlink($FILE['tmp_name']);
				return  array("err"=>'图像必须大于5像素','filename'=>'');
			}
		}
		$bname=basename($FILE['name']);
		$f_type=strtolower(trim(substr(strrchr($bname, '.'), 1)));//获取文件后缀名
		$f= md5(time().$bname);
		$uploadfile=$uploaddir.$f.".$f_type";
		$filetype=$FILE['type'];	
		$filetype=strtolower($this->getfiletype($filetype));//真实的文件后缀
		if($f_type!=$filetype)
		{
			if(!in_array($filetype,array('jpeg','gif','jpg','png','bmp')))
			{
				return array('err'=>'文件后缀与真实文件类型不一致','filename'=>'');
			}
		}
		
		if(!(in_array($filetype,$this->sysallowtype) && in_array($filetype,$this->allowtype)))
		{
			@unlink($FILE['tmp_name']);
			return array('err'=>'文件类型不允许','filename'=>'');
		}
		if(move_uploaded_file($FILE['tmp_name'],$uploadfile))
		{
			@unlink($FILE['tmp_name']);
			return array('err'=>'','filename'=>$uploadfile);
			
		}else
		{
			@unlink($FILE['tmp_name']);
			return array('err'=>'上传失败，请检查文件夹是否有写入权限','filename'=>'');			
		}
		
	}
	
	function getfiletype($ftype)
	{
		switch($ftype)
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
			case "image/pjpeg":
				return 'jpeg';
			break;
			case 'text/plain':
				return 'txt';
			case 'video/mpeg':
				return 'mpeg';
			case 'video/avi':
			case 'video/x-msvideo':
				return 'avi';
			case 'video/rm':
				return 'rm';
			case 'video/rmvb':
				return 'rmvb';
			case 'video/x-ms-wmv':
				return 'wmv';
			case 'application/octet-stream':
				return 'flv';
			case 'audio/mp3':
				return 'mp3';
			case 'audio/wav':
				return 'wav';
			case 'audio/x-ms-wma':
				return 'wma';
			case 'application/x-shockwave-flash':
				return 'swf';
			case 'application/msword':
				return 'doc';
			case 'image/png':
				return 'png';
			break;
			case 'application/pdf':
				return 'pdf';
			case 'application/zip':
				return 'zip';
			case "application/x-tar":
				return 'tar';
			default:
			return 'noallow';
		}
	}
	
	/*创建文件夹*/
	function umkdir($dir)
	{
		$arr=explode("/",$dir);
		foreach($arr as $key=>$val)
		{
			$d="";
			for($i=0;$i<=$key;$i++)
			{
				$d.=$arr[$i]."/";
			}
			if(!file_exists($d) && (strpos($val,":")==false))
			{
				mkdir($d,0755);
			}
		}
	}
	
}
?>