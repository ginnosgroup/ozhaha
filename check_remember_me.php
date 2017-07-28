	<?php 
  	$data =array();
	if ($_SESSION['dm_status'] != 'PRE')
	{
		$data['dm_token'] = $_SESSION['dm_token'];
	}
  	if($_COOKIE['auth'])
  	{
  		$credential = explode('__',$_COOKIE['auth']);
  		$identifier_hash = md5($_COOKIE['username']);
      //var_dump($identifier_hash==$credential[0],$data['dm_token']==$credential[1]);
      if($identifier_hash==$credential[0]&&$data['dm_token']==$credential[1])
  		{
          header("Location:main.php");
  		}
  	
  	}

  	?>