<?php
class Db_class
{
	public $link_id='';
	public  $version='';
	public $config=array();
	function __construct($hostname,$username,$password,$db_name,$charset)
	{
		$this->Db_class($hostname,$username,$password,$db_name,$charset);
	}
	
	function Db_class($hostname,$username,$password,$db_name,$charset='gbk')
	{
		$this->config=array(
		"hostname"=>$hostname,
		"username"=>$username,
		"password"=>$password,
		"db_name"=>$db_name,
		"charset"=>$charset
		);
		$this->connect();
		
	}
	
	function connect()
	{
		$this->link_id=mysql_connect($this->config['hostname'],$this->config['username'],$this->config['password']);
		if(!$this->link_id)
		{
			echo "服务器连接失败";
		}else 
		{
			 mysql_select_db($this->config['db_name'],$this->link_id) or die("数据库连接失败");
			 $this->version = mysql_get_server_info($this->link_id);
			if ($this->version > '5.0.1')
            {
                mysql_query("SET sql_mode=''", $this->link_id);
            }			
			mysql_query("SET NAMES ".$this->config['charset'],$this->link_id);						
		}
		
	}
	
	function query($sql)
	{
		if(!mysql_ping($this->link_id)) 
		{
			mysql_close($this->link_id);
			 $this->connect();		
		}
		$start=$this->microtime_float();
		$res=mysql_query($sql,$this->link_id);
		$sqlfile=ROOT_PATH."temp/slowsql.php";
		$sqlfile2=ROOT_PATH."temp/slowsql2.php";
		$end=$this->microtime_float();
		if(($end-$start)>0.1)
		{
			if(!file_exists($sqlfile))
			{
				file_put_contents($sqlfile,"<?php exit(); ?>");
			}
			if(filesize($sqlfile)>102400)
			{
				if(!file_exists($sqlfile2))
				{
					file_put_contents($sqlfile2,"<?php exit(); ?>");
				}
				if(filesize($sqlfile2)>1024000)
				{
					@unlink($sqlfile2);
				}
				$fp2=fopen($sqlfile2,"a");
				fwrite($fp2,file_get_contents($sqlfile));
				@unlink($sqlfile);
			}
			$fp=fopen($sqlfile,"a");
			$str=$_SERVER['REQUEST_URI']." 时间:".date("Y-m-d H:i:s")."--$sql---执行时间：".($end-$start)."秒\r\n\r\n";
			fwrite($fp,$str);//str_replace(TABLE_PRE,"",$str));
			fclose($fp);
			
		}
		return $res;
	}
	
	
	function num_rows($res)
	{
		return mysql_num_rows($res);
	}
	
		
	function fetch_array($res)
	{
		return mysql_fetch_array($res,MYSQL_ASSOC);	
	}
	
	function fetch_row($res)
	{
		return mysql_fetch_row($res);	
	}
	
	function num_fields($res)
	{
		return mysql_num_fields($res);
	}
	
	function insert($table,$data)
	{
		$dot=$fields="";
		$i=0;
		foreach($data as $k=>$v){
			if($i>0) $dot=",";
			$fields.="$dot $k='$v' ";
			$i++;	
		}
		$this->query("INSERT INTO ".TABLE_PRE.$table." SET $fields ");
		return $this->insert_id();
	}
	
	function update($table,$data,$w)
	{
		$dot=$fields="";
		$i=0;
		foreach($data as $k=>$v){
			if($i>0) $dot=",";
			$fields.="$dot $k='$v' ";
			$i++;	
		}
		$this->query("UPDATE ".TABLE_PRE.$table." SET $fields WHERE 1=1 $w ");
	}
	
	function delete($table,$w='')
	{
		$this->query("DELETE FROM ".TABLE_PRE."$table WHERE 1=1  $w ");
	}
	/**
	*array("table","where","order","start","pagesize","fields")
	*/
	function SELECT($data)
	{		
		$start=$data['start']?$data['start']:0;
		$pagesize=$data['pagesize']?$data['pagesize']:10;
		$fields=$data['fields']?$data['fields']:"*";
		return $this->getAll("SELECT {$fields} FROM ".TABLE_PRE."{$data['table']}  WHERE 1=1 {$data['where']} {$data['order']} LIMIT $start,$pagesize ");
		
	}
	
	function selectOne($data)
	{
		$start=$data['start']?$data['start']:0;
		$pagesize=$data['pagesize']?$data['pagesize']:10;
		$fields=$data['fields']?$data['fields']:" COUNT(*) ";
		return $this->getOne("SELECT {$fields} FROM ".TABLE_PRE."{$data['table']}  WHERE 1=1 {$data['where']} {$data['order']} LIMIT 1 ");
	}
	
	function selectRow($data)
	{
		$start=$data['start']?$data['start']:0;
		$pagesize=$data['pagesize']?$data['pagesize']:10;
		$fields=$data['fields']?$data['fields']:" * ";
		return $this->getRow("SELECT {$fields} FROM ".TABLE_PRE."{$data['table']}  WHERE 1=1 {$data['where']} {$data['order']} LIMIT 1 ");
	}
		
	function selectCols($data)
	{
		$start=$data['start']?$data['start']:0;
		$pagesize=$data['pagesize']?$data['pagesize']:10;
		$fields=$data['fields']?$data['fields']:" * ";
		return $this->getCols("SELECT {$fields} FROM ".TABLE_PRE."{$data['table']}  WHERE 1=1 {$data['where']} {$data['order']} LIMIT $start,$pagesize ");
	}

 
 
			
	function getCount($table,$w='')
	{
		return $this->getOne("SELECT COUNT(*) FROM ".TABLE_PRE.$table." WHERE 1=1 $w ");
	}
	
	function getAll($sql)
	{
		$res=$this->query($sql);
		if($res!==false)
		{
			$arr=array();
			while ($rs=mysql_fetch_array($res,MYSQL_ASSOC))
			{
				$arr []=$rs;
			}
			return $arr;
		}else
		 {
			return false;
			
		}
	}
	
	function affected_rows()
	{
		return  mysql_affected_rows($this->link_id);
	}
	
	function getOne($sql,$limited = false)
	{
		if($limited == true)
		{
			$sql = trim($sql . 'LIMIT 1');
		}
		$res=$this->query($sql);
		if($res !==false)
		{
			$rs=mysql_fetch_row($res);
			if($rs!==false)
			{
				return $rs[0];
			}else
			{
				return '';
			}
		}
		else {
			return false;
		}
		
	}
	
	
	
	 function getRow($sql, $limited = false)
    {
        if ($limited == true)
        {
            $sql = trim($sql . ' LIMIT 1');
        }

        $res = $this->query($sql);
        if ($res !== false)
        {
            return mysql_fetch_array($res,MYSQL_ASSOC);
        }
        else
        {
            return false;
        }
    }
    
    function getCols($sql)
	{
		$res=$this->query($sql);
		if($res!==false)
		{
			$arr=array();
			while($rs=mysql_fetch_array($res))
			{
				$arr[]=$rs[0];
			}
			return $arr;
		}else
		{
			return false;
		}
	}
	

	function insert_id()
    {
        return mysql_insert_id($this->link_id);
    }
      function error()
    {
        return mysql_error();
    }

    function errno()
    {
        return mysql_errno();
    }
	
	function microtime_float()
	{
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}	        

}	




?>