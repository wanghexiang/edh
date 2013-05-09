<?php
function submitcheck()
{

}

//验证非空
function ckempty($v,$e='不能为空')
{
	if(!$v)
	{
		errback($e);
	}
}
//验证大小介于 。。。
function ckbetween($v,$e,$max,$min=0)
{
	if($v>$max or $v<$min)
	{
		errback($e);	
	}
	
}

//验证长度
function cklong($v,$e,$max,$min=0)
{
	if(strlen($v)>$max  or strlen($v)<$min)
	{
		errback($e);
	}
}

//验证是否相等

function ckequal($v1,$v2,$t=0)
{
	//严格的比较
	if($t==1)
	{
		if($v1===$v2)
		{
			return true;
		}else
		{
			return false;
		}
	}else
	{
		if($v1==$v2)
		{
			return true;	
		}else
		{
			return false;	
		}
	}
	
}

/**
 * 验证输入的邮件地址是否合法
 *
 * @access  public
 * @param   string      $email      需要验证的邮件地址
 *
 * @return bool
 */
function is_email($user_email)
{
    $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
    if (strpos($user_email, '@') !== false && strpos($user_email, '.') !== false)
    {
        if (preg_match($chars, $user_email))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}

/*加密函数*/
function umd5($str)
{
	return md5(md5($str)."233444");	
}