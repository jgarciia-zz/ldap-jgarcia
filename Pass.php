<?php 
session_start();

function cleanInput($input) {
  $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Elimina javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Elimina las etiquetas HTML
    '@<style[^>]*?>.*?</style>@siU',    // Elimina las etiquetas de estilo
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Elimina los comentarios multi-línea
  );
    $output = preg_replace($search, '', $input);
    return $output;
}

$ldapconn = ldap_connect("localhost")
    or die("Could not connect to LDAP server.");
$ldaprdn=cleanInput($_POST['username']);
$ldappass=cleanInput($_POST['password']);

if($_SERVER['REQUEST_METHOD']=='POST' && $_REQUEST['login']=='Entrar'){
    
    if(!empty($_POST['username']) && !empty($_POST['password'])) {

        $ldaprdn=cleanInput($_POST['username']);
        $ldappass=cleanInput($_POST['password']);
        $_SESSION['password']=$ldappass;
        // conexión al servidor LDAP
        if ($ldapconn) {

            // realizando la autenticación
            ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

            $conldap="cn=".$ldaprdn.",dc=daw2, dc=net";


            $ldapbind = ldap_bind($ldapconn, $conldap, $ldappass);

            //var_dump($ldapbind);


            // verificación del enlace
            if ($ldapbind) {
                $_SESSION['username']=$ldaprdn;
                $_SESSION['Error'] = "";
                //var_dump($_SESSION);
                header("Location: Home.php");
            } else {
                $_SESSION['Error'] = "Usuario no valido...";
                header("Location: index.php");
            }

        }

    }else{
        $_SESSION['Error'] ="Error nos has llenado los campos.";
        header("Location: index.php");

    }
}

if($_SERVER['REQUEST_METHOD']=='POST' && $_REQUEST['change']=='Cambiar'){
    
    if(!empty($_POST['new_password']) && !empty($_POST['new_password2']) && !empty($_POST['old_password'])) {
        $ldaprdn=cleanInput($_POST['username']);
        $ldappass=cleanInput($_POST['new_password']);
        $ldappass2=cleanInput($_POST['new_password2']);
        $ldappass_old=cleanInput($_POST['old_password']);
        
        if($ldappass!=$ldappass_old && $ldappass==$ldappass2){
            
            if ($ldapconn) {

            // realizando la autenticación
            ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

            $conldap="cn=".$ldaprdn.",dc=daw2, dc=net";
            $ldapbind = ldap_bind($ldapconn, $conldap, $ldappass_old);
            
                if ($ldapbind) {
                        ldap_mod_replace($ldapconn, $conldap, array('userpassword' => "{MD5}".base64_encode(pack("H*",md5($ldappass) ) ) ) ) or die(ldap_error($ldapconn));
                        $_SESSION['Error'] = "<span class='ok'>Contraseña cambiada.</span>";
                        header("Location: Canviar_pass.php");

                } else {
                        $_SESSION['Error'] = "<span class='Error'>Intento Fallido.</span>";
                        header("Location: Canviar_pass.php");

                }            
            }else{
                        $_SESSION['Error'] = "<span class='Error'>Intento Fallido.</span>";
                        header("Location: Canviar_pass.php");
            }
                
            
        
        }else{
            $_SESSION['Error'] = "<span class='error'>Es la misma contraseña o no coinciden.</span>";
            header("Location: Canviar_pass.php");
        }
        
    }else{
        $_SESSION['Error'] = "<span class='error'>Rellena los campos.</span>";
        header("Location: Canviar_pass.php");
    }
    
}

if($_SERVER['REQUEST_METHOD']=='POST' && $_REQUEST['logout']=='Cerrar'){
    unset($_SESSION['username']);
    unset($_SESSION['Error']);
    unset($_SESSION['password']);
    ldap_close($ldapconn);
    session_destroy();
    header("location:index.php");
}

?> 
