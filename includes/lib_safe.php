<?php
function submitcheck()
{

}

//��֤�ǿ�
function ckempty($v,$e='����Ϊ��')
{
	if(!$v)
	{
		errback($e);
	}
}
//��֤��С���� ������
function ckbetween($v,$e,$max,$min=0)
{
	if($v>$max or $v<$min)
	{
		errback($e);	
	}
	
}

//��֤����
function cklong($v,$e,$max,$min=0)
{
	if(strlen($v)>$max  or strlen($v)<$min)
	{
		errback($e);
	}
}

//��֤�Ƿ����

function ckequal($v1,$v2,$t=0)
{
	//�ϸ�ıȽ�
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
 * ��֤������ʼ���ַ�Ƿ�Ϸ�
 *
 * @access  public
 * @param   string      $email      ��Ҫ��֤���ʼ���ַ
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

/*���ܺ���*/
function umd5($str)
{
	return md5(md5($str)."233444");	
}