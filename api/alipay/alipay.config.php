<?php

//���������id����2088��ͷ��16λ������
$aliapy_config['partner']      = '2088302422505850';

//��ȫ�����룬�����ֺ���ĸ��ɵ�32λ�ַ�
$aliapy_config['key']          = '72ovd7tigkv1p073ffx481glzkk6977f';

//ǩԼ֧�����˺Ż�����֧�����ʻ�
$aliapy_config['seller_email'] = 'shapaba@shapaba.com';

//ҳ����תͬ��֪ͨҳ��·����Ҫ�� http://��ʽ������·�����������?id=123�����Զ������
//return_url����������д��http://localhost/create_direct_pay_by_user_php_gb/return_url.php ������ᵼ��return_urlִ����Ч
//������������  ���� hck.com ��http://hck.com/api/alipay/return_url.php
$aliapy_config['return_url']   = 'http://hck.koufukeji.com/index.php?m=alipayback';
//������������  ���� hck.com ��http://hck.com/api/alipay/notify_url.php
//�������첽֪ͨҳ��·����Ҫ�� http://��ʽ������·�����������?id=123�����Զ������
$aliapy_config['notify_url']   = 'http://hck.koufukeji.com/api/alipay/notify_url.php';

//�����������������������������������Ļ�����Ϣ������������������������������

//ǩ����ʽ �����޸�
$aliapy_config['sign_type']    = 'MD5';

//�ַ������ʽ Ŀǰ֧�� gbk �� utf-8
$aliapy_config['input_charset']= 'gbk';

//����ģʽ,�����Լ��ķ������Ƿ�֧��ssl���ʣ���֧����ѡ��https������֧����ѡ��http
$aliapy_config['transport']    = 'https';
?>