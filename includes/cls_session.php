<?php
class session{

	public $expire;
	function __construct($db,$expire=3600)
	{
		$this->db=$db;
		$this->expire=$expire;
		session_set_save_handler( 
            array(&$this, 'open'), 
            array(&$this, 'close'), 
            array(&$this, 'read'), 
            array(&$this, 'write'), 
            array(&$this, 'destroy'), 
            array(&$this, 'gc')                                                             
        ); 
		session_start();
	}
	function open($save_path, $session_name)
	{  
		return true;
	}
	
	function close()
	{
		return true;
	}
	
	function read($id)
	{
		$dateline=time()-$this->expire;
		$this->db->query("DELETE FROM ".TABLE_PRE."session WHERE dateline<'$dateline' ");//检查过去并删除
		return $this->db->getOne("SELECT data FROM ".TABLE_PRE."session WHERE id='$id' AND dateline>'$dateline' ");
	}
	
	function write($id, $sess_data)
	{
		if($this->db->getOne("SELECT id FROM ".TABLE_PRE."session WHERE id='$id' "))
		{
			$this->db->query("update ".TABLE_PRE."session set data='$sess_data',dateline=".time()." where id='$id'");
		}else
		{
			$this->db->query("insert into ".TABLE_PRE."session SET data='$sess_data',dateline=".time().",id='$id' ");
		}
	}
	
	function destroy($id)
	{
		$this->db->query("DELETE   FROM  ".TABLE_PRE."session WHERE id='$id'");
	}
	
	function gc($maxlifetime)
	{
		return true;
	}

	
}

?>