<?php
session_start();
include("includes/header.php");
include("Pass.php");
$_SESSION['Error']="";
?>
        <div id="myweb">
            <h2>Bienvenido, <span><?php echo $_SESSION['username'];?>! </span></h2> <a style="float:left;" href="Canviar_pass.php">Cambiar contraseña</a> 
            <form name="logoutform" id="logoutform" action="Pass.php" method="post">
                <p class="submit">
                        <input type="submit" name="logout" id="logout" class="button cerrar" value="Cerrar" /> 
                </p>
            </form>
            <br />
            <h2>Información del usuario</h2>
            <?php
                ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
            	$filter = "(cn=".$_SESSION['username'].")";
                $sr=ldap_search($ldapconn,"dc=daw2, dc=net", $filter);
                $info = ldap_get_entries($ldapconn, $sr);
                for ($i=0; $i<$info["count"]; $i++) {
                    echo "<strong>uid</strong>: " . $info[$i]["uid"][0] . "<br />";
                    echo "<strong>cn</strong>: " . $info[$i]["cn"][0] . "<br />";
                    echo "<strong>sn</strong>: " . $info[$i]["sn"][0] . "<br />";
                    echo "<strong>uidnumber</strong>: " . $info[$i]["uidnumber"][0] . "<br />";
                    echo "<strong>homedirectory</strong>: " . $info[$i]["homedirectory"][0] . "<br />";
                    echo "<strong>shell</strong>: " . $info[$i]["loginshell"][0] . "<br />";
                }
            ?>
        </div>
    <?php include("includes/footer.php"); ?>