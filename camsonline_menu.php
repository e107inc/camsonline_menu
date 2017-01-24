<?php

/*

        Cam's Online Menu v1.0 by Cameron.at.e107coders.org



        for the e107 website system

        �Steve Dunstan 2001-2002



        Released under the terms and conditions of the

        GNU General Public License (http://gnu.org).

*/



require_once(e_LANGUAGEDIR.e_LANGUAGE."/lan_login.php");

$folder = "camsonline_menu";

$text = "";

        if(USER == TRUE || ADMIN == TRUE){



        $text .="<table style='width:100%'><tr><td valign='top'>";

                $sql = new db;

                if($sql -> db_Select("user", "*", "user_id='".USERID."'")){

                $row = $sql -> db_Fetch();

                if($row[user_image] == "") {

                        $user_image = "".e_PLUGIN."$folder/images/default.png";

                        $text .= "<div class='spacer'><img src='".$user_image."' alt='' /></div>";

                }else{

                        $user_image = $row[user_image];

                require_once(e_HANDLER."avatar_handler.php");

                $user_image = avatar($user_image);

                $text .= "<div class='spacer'><img src='".$user_image."' alt='' /></div>";

                }

        }

$text .="</td><td class='smalltext' valign='top'>";









                list($uid, $upw) = ($_COOKIE[$pref['cookie_name']] ? explode(".", $_COOKIE[$pref['cookie_name']]) : explode(".", $_SESSION[$pref['cookie_name']]));

                $sql = new db;

                if($sql -> db_Select("user", "*", "user_id='$uid' AND md5(user_password)='$upw'")){

                        if(ADMIN == TRUE){

                                $adminfpage = (!$pref['adminstyle'] || $pref['adminstyle'] == "default" ? "admin.php" : $pref['adminstyle'].".php");

                                $text .= ($pref['maintainance_flag']==1 ? "<div style='text-align:center'><b>".LOGIN_MENU_L10."</div></b><br />" : "" );

                                $text .= "<img src='".THEME."images/bullet2.gif' alt='bullet' /> <a href='".e_ADMIN.$adminfpage."'>".LOGIN_MENU_L11."</a><br />";

                        }

                        $text .= "<img src='".THEME."images/bullet2.gif' alt='bullet' /> <a href='".e_BASE."usersettings.php'>".LOGIN_MENU_L12."</a>\n<br />\n<img src='".THEME."images/bullet2.gif' alt='bullet' /> <a href='".e_BASE."user.php?id.".USERID."'>".LOGIN_MENU_L13."</a>\n<br />\n<img src='".THEME."images/bullet2.gif' alt='bullet' /> <a href='".e_BASE."?logout'>".LOGIN_MENU_L8."</a>";



                        if(!$sql -> db_Select("online", "*", "online_ip='$ip' AND online_user_id='0' ")){

                                $sql -> db_Delete("online", "online_ip='$ip' AND online_user_id='0' ");

                        }



                        $time = USERLV;

                        $new_news = $sql -> db_Count("news", "(*)", "WHERE news_datestamp>'".$time."' "); if(!$new_news){ $new_news = LOGIN_MENU_L26; }

                        $new_comments = $sql -> db_Count("comments", "(*)", "WHERE comment_datestamp>'".$time."' "); if(!$new_comments){ $new_comments = LOGIN_MENU_L26; }

                        $new_chat = $sql -> db_Count("chatbox", "(*)", "WHERE cb_datestamp>'".$time."' "); if(!$new_chat){ $new_chat = LOGIN_MENU_L26; }

                        $new_forum = $sql -> db_Count("forum_t", "(*)", "WHERE thread_datestamp>'".$time."' "); if(!$new_forum){ $new_forum = LOGIN_MENU_L26; }

                        $new_users = $sql -> db_Count("user", "(*)", "WHERE user_join>'".$time."' "); if(!$new_users){ $new_users = LOGIN_MENU_L26; }

                        $text .="</td></tr></table><div class='spacer'></div>";





$text .= "<div style='cursor:hand' onClick=\"expandit('guests')\"><table style='width:95%'><tr ><td class='smalltext' ><a><b>Gasten Online</b></a></td><td class='smalltext' style='text-align:right'><b><a  >".GUESTS_ONLINE."</a></b></td></tr></table></div>";

        if(ADMIN){

                    $sql -> db_Select("online", "*", "online_user_id='0' ORDER BY online_user_id ASC ");

                    $text .="<div id='guests' style='display:none'><table class='forumheader3'>";

             //

                    while($row = $sql -> db_Fetch()){

                        extract($row);



                        $online_location_page = eregi_replace(".php", "", substr(strrchr($online_location, "/"), 1));

                        if($online_location_page == "log" || $online_location_page == "error"){ $online_location = "news.php"; $online_location_page = "news";  }

                        if($online_location_page == "request"){ $online_location = "download.php"; }

                        if(strstr($online_location_page, "forum")){ $online_location = "forum.php"; $online_location_page = "forum"; }

                        if($online_user_id == 2){ $online_location = "#"; $online_location_page = ":P"; $spanit = "style='color:red'";}else{$spanit = ""; }





                        $text .= "<tr><td class='smalltext' colspan='2'>&nbsp;<img src='".e_PLUGIN."$folder/images/user.png' alt='' style='vertical-align:middle' />

                         <a $spanit href='".e_ADMIN."userinfo.php?$online_ip'>$online_ip</a><span style='color:black'> ".ONLINE_EL7." </span><a $spanit href='$online_location'>$online_location_page</a></td></tr>";

                         }

                   $text .="</table></div>";

                }









        if($pref['user_reg'] == 1){

                $text .= "<div style='cursor:hand' title='Bekijk leden online' onClick=\"expandit('members')\"><table style='width:95%'><tr><td class='smalltext' ><a title='Bekijk leden online'><b>Leden Online</b></a></td><td class='smalltext' style='text-align:right'><b><a title='View members online'>".MEMBERS_ONLINE."</a></b></td></tr></table></div>";

        }



        if(MEMBERS_ONLINE){

        $text .="<div id='members' style=\"display:none\">";

        $text .= "<table class='forumheader3' style='width:95%'><tr><td  colspan='2'>";



                $sql -> db_Select("online", "*", "online_user_id!='0' ORDER BY online_user_id ASC ");

                while($row = $sql -> db_Fetch()){

                        $spanit = "";

                        extract($row);

                        $oid = substr($online_user_id, 0, strpos($online_user_id, "."));

                        $oname = substr($online_user_id, (strpos($online_user_id, ".")+1));

                    //    $online_location_page = substr(strrchr($online_location, "/"), 1);

                    $online_location_page = preg_replace(".php", "", substr(strrchr($online_location, "/"), 1));

                        if($online_location_page == "log" || $online_location_page == "error"){ $online_location = "news.php"; $online_location_page = "news";  }

                        if($online_location_page == "request"){ $online_location = "download.php"; }

                        if(strstr($online_location_page, "forum")){ $online_location = "forum.php"; $online_location_page = "forum"; }

                        if($online_user_id == 1){ $online_location = "#"; $online_location_page = ":P"; $spanit = "style='color:red'";}

                        $text .= "<tr><td class='smalltext' colspan='2'>&nbsp;<img src='".e_PLUGIN."$folder/images/user.png' alt='' style='vertical-align:middle' />

                         <a $spanit href='".e_BASE."user.php?id.$oid'>$oname</a><span style='color:black'> ".ONLINE_EL7." </span><a $spanit href='$online_location'>$online_location_page</a></td></tr>";







                }



                $text .="</table></div>";



        }





//PM System Start



global $sysprefs, $pref, $pm_prefs;

if(!isset($pm_prefs['perpage']))

{

	$pm_prefs = $sysprefs->getArray("pm_prefs");

}

require_once(e_PLUGIN."pm/pm_func.php");
$pm = new pmbox_manager;
$pm->pm_getInfo('clear');



function pm_show_popup()

{

	global $pm_inbox, $pm_prefs;

	$alertdelay = intval($pm_prefs['popup_delay']);

	if($alertdelay == 0) { $alertdalay = 60; }

	setcookie("pm-alert", "ON", time()+$alertdelay);

	$popuptext = "

	<html>

		<head>

			<title>".$pm_inbox['inbox']['new']." ".LAN_PM_109."</title>

		</head>

		<body style=\'padding-left:2px;padding-right:2px; padding:2px; padding-bottom:2px; margin:0px; text-align:center\' marginheight=\'0\' marginleft=\'0\' topmargin=\'0\' leftmargin=\'0\'>

		<table style=\'width:100%; text-align:center; height:99%; padding-bottom:2px\' class=\'bodytable\'>

			<tr>

				<td width=100% >

					<center><b>--- ".LAN_PM." ---</b><br />".$pm_inbox['inbox']['new']." ".LAN_PM_109."<br />".$pm_inbox['inbox']['unread']." ".LAN_PM_37."<br /><br />

					<form>

						<input class=\'button\' type=\'submit\' onclick=\'self.close();\' value = \'".LAN_PM_110."\' />

					</form>

					</center>

				</td>

			</tr>

		</table>

		</body>

	</html> ";

	$popuptext = str_replace("\n", "", $popuptext);

	$popuptext = str_replace("\t", "", $popuptext);

	$text = "

	<script type='text/javascript'>

	winl=(screen.width-200)/2;

	wint = (screen.height-120)/2;

	winProp = 'width=200,height=120,left='+winl+',top='+wint+',scrollbars=no';

	window.open('javascript:document.write(\"".$popuptext."\");', 'pm_popup', winProp);

	</script >";

	return $text;

}



define("PM_INBOX_ICON", "<img src='".e_PLUGIN."pm/images/mail_get.png' style='height:16px; width:16px; border:0px;' alt='".LAN_PM_25."' title='".LAN_PM_25."' />");

define("PM_OUTBOX_ICON", "<img src='".e_PLUGIN."pm/images/mail_send.png' style='height:16px; width:16px; border:0px;' alt='".LAN_PM_26."' title='".LAN_PM_26."' />");

define("PM_SEND_LINK", LAN_PM_35);

define("NEWPM_ANIMATION", "<img src='".e_PLUGIN."pm/images/newpm.gif' alt='' style='border:0' />");



$sc_style['SEND_PM_LINK']['pre'] = "<br /><br /><center>[ ";

$sc_style['SEND_PM_LINK']['post'] = " ]</center>";



$sc_style['INBOX_FILLED']['pre'] = "[";

$sc_style['INBOX_FILLED']['post'] = "%]";



$sc_style['OUTBOX_FILLED']['pre'] = "[";

$sc_style['OUTBOX_FILLED']['post'] = "%]";



$sc_style['NEWPM_ANIMATE']['pre'] = "<a href='".e_PLUGIN_ABS."pm/pm.php?inbox'>";

$sc_style['NEWPM_ANIMATE']['post'] = "</a>";





if(!isset($pm_menu_template))

{

	$pm_menu_template = "

	<br />

	<a href='".e_PLUGIN_ABS."pm/pm.php?inbox'>".PM_INBOX_ICON."</a>

	<a href='".e_PLUGIN_ABS."pm/pm.php?inbox'>".LAN_PM_25."</a>

	{NEWPM_ANIMATE}

	<br />

	{INBOX_TOTAL} ".LAN_PM_36.", {INBOX_UNREAD} ".LAN_PM_37." {INBOX_FILLED}

	<br />

	<a href='".e_PLUGIN_ABS."pm/pm.php?outbox'>".PM_OUTBOX_ICON."</a>

	<a href='".e_PLUGIN_ABS."pm/pm.php?outbox'>".LAN_PM_26."</a><br />

	{OUTBOX_TOTAL} ".LAN_PM_36.", {OUTBOX_UNREAD} ".LAN_PM_37." {OUTBOX_FILLED}

	{SEND_PM_LINK}

	";

}



if(check_class($pm_prefs['pm_class']))

{

	global $tp, $pm_inbox;

	$pm_inbox = pm_getInfo('inbox');

	require_once(e_PLUGIN."pm/pm_shortcodes.php");

	$text .= $tp->parseTemplate($pm_menu_template, TRUE, $pm_shortcodes);

	if($pm_inbox['inbox']['new'] > 0 && $pm_prefs['popup'] && strpos(e_SELF, "pm.php") === FALSE && $_COOKIE["pm-alert"] != "ON")

	{

		$text .= pm_show_popup();

	}

}



//PM System End



    $text .="<br /><div style='text-align:center; font-weight:bold'><a style='cursor:hand' onClick='expandit(this)' >Recente aanvullingen:</a></div>";





                        $text .= "<div style='display:none'>\n<span class='smalltext'>\n".LOGIN_MENU_L25."

                        $new_news ".($new_news == 1 ? LOGIN_MENU_L14 : LOGIN_MENU_L15).",

                        $new_chat ".($new_chat == 1 ? LOGIN_MENU_L16 : LOGIN_MENU_L17).",

                        $new_comments ".($new_comments == 1 ? LOGIN_MENU_L18 : LOGIN_MENU_L19).",

                        $new_forum ".($new_forum == 1 ? LOGIN_MENU_L20 : LOGIN_MENU_L21)." ".LOGIN_MENU_L27."

                        $new_users ".($new_users == 1 ? LOGIN_MENU_L22 : LOGIN_MENU_L23).".</span>

                        <br /><a href='".e_PLUGIN."list_new/list.php'>".LOGIN_MENU_L24."</a></div>";







                        $caption = (file_exists(THEME."images/login_menu.png") ? "<img src='".THEME."images/login_menu.png' alt='' /> ".LOGIN_MENU_L5." ".USERNAME : LOGIN_MENU_L5." ".USERNAME);





                }else{

                        $text = "<div style='text-align:center'>".LOGIN_MENU_L7."<br /><br />\n<img src='".THEME."images/bullet2.gif' alt='bullet' /> <a href='".e_BASE."index.php?logout'>".LOGIN_MENU_L8."</a></div>";



                }

        }else{

                if(deftrue('LOGINMESSAGE')){

                        $text = "<div style='text-align:center'>".LOGINMESSAGE."</div>";

                }

                $text .=  "<div style='text-align:center'>\n<form method='post' action='".e_SELF;

if(e_QUERY){

        $text .= "?".e_QUERY;

}



$text .= "'><p>\n".LOGIN_MENU_L1."<br />\n<input class='tbox' type='text' name='username' size='15' value='' maxlength='30' />\n<br />\n".LOGIN_MENU_L2."\n<br />\n<input class='tbox' type='password' name='userpass' size='15' value='' maxlength='20' />\n\n<br />\n<input class='button' type='submit' name='userlogin' value='".LOGIN_MENU_L28."' />\n\n<br />\n<input type='checkbox' name='autologin' value='1' /> ".LOGIN_MENU_L6;



if($pref['user_reg']){

        $text .= "<br /><br />";

        if($pref['auth_method'] != "ldap"){

                $text .= "[ <a href='".e_BASE.e_SIGNUP."'>".LOGIN_MENU_L3."</a> ]<br />[ <a href='".e_BASE."fpw.php'> ".LOGIN_MENU_L4."</a> ]";

        }

}

$text .= "</p>

</form>

</div><br />";

}









 // Total Members and Newest Member.

        $total_members = $sql -> db_Count("user");



        if($total_members > 1){

                $newest_member = $sql -> db_Select("user", "user_id, user_name", "ORDER BY user_join DESC LIMIT 0,1", "no_where");

                $row = $sql -> db_Fetch(); extract($row);

                $text .= "<div style='text-align:center'><br />".ONLINE_EL5.": ".$total_members."<br />".ONLINE_EL6.": <a href='user.php?id.".$user_id."'>".$user_name."</a></div>";

        }







      $title = (USER)? $caption:"Login";

        $ns -> tablerender($title, $text);



?>