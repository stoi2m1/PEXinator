<?php


if($_POST['submit'])
{

$source = $_POST['source'];

	switch($source)
	{
	
		case 'mysql':
		
			$conn = mysql_connect($_POST['server'],$_POST['user'],$_POST['password']);
			$db = mysql_select_db($_POST['db']);
				if(!$conn)
					header("location: index.php?error=Cannot+connect+to+MySQL");
				elseif(!$db)
					header("location: index.php?error=Cannot+connect+to+Database");
				else
				{
					$File = "../includes/config.php"; 
 					$Handle = fopen($File, 'w');
						$data = '<?php' . "\n";
						$data .= '$settings[\'mysql\'][\'host\'] = \''.$_POST['server'].'\';' . "\n";
						$data .= '$settings[\'mysql\'][\'username\'] = \''.$_POST['user'].'\';' . "\n";
						$data .= '$settings[\'mysql\'][\'password\'] = \''.$_POST['password'].'\';' . "\n";
						$data .= '$settings[\'mysql\'][\'database\'] = \''.$_POST['db'].'\';' . "\n";
						$data .= '?>' . "\n";
 					fwrite($Handle, $data); 
 					fclose($Handle);
					
					chmod("../includes/config.php", 0755);
					
					
					$sql1 = "CREATE TABLE IF NOT EXISTS `pexinator_users` (
   						`id` int(11) NOT NULL auto_increment,
   						`name` varchar(32) NOT NULL,
   						`password` varchar(32) NOT NULL,
						`pin` int(4) NOT NULL,
						`session_id` varchar(32) NOT NULL default 'default',
   						PRIMARY KEY  (`id`)
   						) ENGINE=InnoDB";
						
					$query1 = mysql_query($sql1);
				
					$sql2 = "CREATE TABLE IF NOT EXISTS `pexinator_settings` (
   						`setting` varchar(32) NOT NULL,
   						`value` varchar(32) NOT NULL,
						PRIMARY KEY  (`setting`)
   						) ENGINE=InnoDB";
						
					$query2 = mysql_query($sql2);
					
					if($query1 && $query2)
					{
						$insert1 = mysql_query("INSERT INTO pexinator_settings (setting,value) VALUES ('wsEnabled','false')");
						$insert2 = mysql_query("INSERT INTO pexinator_settings (setting,value) VALUES ('wsAddress','127.0.0.1')");
						$insert3 = mysql_query("INSERT INTO pexinator_settings (setting,value) VALUES ('wsPassword','Password')");
						$insert4 = mysql_query("INSERT INTO pexinator_settings (setting,value) VALUES ('defaultColor','&f')");
					
						if($insert1 && $insert2 && $insert3 && $insert4)
							header("location: index.php?step=2&success");
						else
							header("location: index.php?error=Failed+to+fill+tables");
					}
					else
					header("location: index.php?error=Failed+to+create+tables");
	
					
				}
				mysql_close($conn);
				die();
		break;
		
		case 'admin':

			require("../includes/config.php");
			$regex = "/^[A-Za-z0-9]$/";

			if(empty($_POST['username']) || empty($_POST['pass1']) || empty($_POST['pass2']) || empty($_POST['pin']))
			{
					header("location: index.php?step=2&error=Missing+Fields");
			}
			//elseif(!preg_match($regex,$_POST['username']) || !preg_match($regex,$_POST['password']) || !preg_match($regex,$_POST['pin']))
			//{
				//	header("location: index.php?step=2&error=Alpha+numeric+characters+_+only");	
			//}
			elseif(strlen($_POST['username']) > 32 || strlen($_POST['pass1']) > 32 || strlen($_POST['pass2']) > 32)
			{
					header("location: index.php?step=2&error=32+characters+max");				
			}
			elseif(!is_numeric($_POST['pin']) || strlen($_POST['pin']) != 4)
			{
					header("location: index.php?step=2&error=Pin+must+be+numeric and 4 characters");		
			}
			elseif($_POST['pass1'] != $_POST['pass2'])
			{
					header("location: index.php?step=2&error=Passwords+do+not+match");				
			}
			else
			{
				
				
				$conn = mysql_connect($settings['mysql']['host'],$settings['mysql']['username'],$settings['mysql']['password']);
				$db = mysql_select_db($settings['mysql']['database']);
				
				if($conn && $db)
				{
					$u = mysql_real_escape_string($_POST['username']);
					$pin = mysql_real_escape_string($_POST['pin']);
					$p = md5($_POST['pass1'] . $pin);	
					$query = mysql_query("INSERT INTO pexinator_users (id,name,password,pin,session_id) VALUES (NULL,'$u','$p','$pin','default')");
					
						if($query)
						{
							header("location: index.php?step=3");	
						}
					
					
				}
			}
		break;
	}
}







?>