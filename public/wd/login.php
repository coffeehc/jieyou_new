<?php
header("Content-type: text/html; charset=utf-8");
include "../include/config.php";
if(isset($_POST['username'])){
	if(empty($_POST['username'])){
		die("<script>alert('请输入用户名');</script>");
	}
	$connect = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die('Unale to connect');
	$connect->query("SET NAMES utf8");
	$stmt = $connect->prepare("select * from admin_user where users=? and pass=?");
	$stmt->bind_param('ss', $_POST['username'], $_POST['pwd']);
	$stmt->execute();
	$result = $stmt->get_result();
	if($result && $result->num_rows>0){
		$lrs = mysqli_fetch_array($result);
		//写入SESSION变量
		$_SESSION['userid'] = $lrs['id'];
		
		//解决充值问题
		$stmt2 = $connect->prepare("select sessionid from login_session where user=?");
		$stmt2->bind_param('s', $_POST['username']);
		$stmt2->execute();
		$result2 = $stmt2->get_result();
		if($result2 && $result2->num_rows>0){
			$stmt3 = $connect->prepare("update login_session set sessionid=? where user=?");
			$stmt3->bind_param('ss', session_id(),$_POST['username']);
			$stmt3->execute();
			$stmt3->close();
		}else{
			$stmt3 = $connect->prepare("insert into login_session (sessionid,user) values (?,?)");
			$stmt3->bind_param('ss', session_id(),$_POST['username']);
			$stmt3->execute();
			$stmt3->close();
		}
		$stmt2->close();

		//记录用户的登陆次数和时间
		mysql_query("update admin_user set hits =".$lrs['hits']."+1,time = '".time()."' where id =".$lrs['id']);
		$stmt->close();

		//die("<script>alert('".$lrs['name'].":欢迎您回来！');parent.window.location='/wx/60.html';</script>");
		//取得当前游戏的所有区服，并返回到登录界面，完成登录后选区
		$gid = $_POST['gameid'];
		$sql="select id,name,date_format(stime, '%m-%d %H') shijian,game from admin_game_server where gid='".$gid."' order by UNIX_TIMESTAMP(stime) desc";
		$stmt = $connect->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$lists = '';
		if($result && $result->num_rows>0){
			$list = array(array());
			$idx = 0;
			while($lrs = mysqli_fetch_array($result)){
				$list[$idx++] = $lrs;
			}
			$lists = json_encode($list);
		}
		$stmt->close();
		$connect->close();
		die("<script>parent.callbackServers('".$lists."');</script>");
	}else{
		$connect->close();
		die("<script>alert('用户名或密码错误！');</script>");
	}
}
?>