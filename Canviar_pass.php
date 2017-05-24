<?php
session_start();
include("includes/header.php");
if(!isset($_SESSION["username"])){ 
    header("Location: index.php");
}
?>

    <div class="container mlogin">
        <p class="error"><?php echo $_SESSION['Error'];?></p>
        <div id="login">
                <h2>Cambiar contraseña de <span><?php echo $_SESSION['username'];?> ! </span></h2>
                <form name="passform" id="passform" action="Pass.php" method="post">
                    <input type=hidden name="username" id="username" class="input" value="<?php echo $_SESSION['username'];?>"/>
                    <p>
                        <label for="user_pass">Vieja Contraseña
                            <br />
                            <input type="password" name="old_password" id="old_password" class="input" value="" size="20" /> </label>
                    </p>
                    <p>
                        <label for="user_pass">Nueva Contraseña
                            <br />
                            <input type="password" name="new_password" id="new_password" class="input" value="" size="20" /> </label>
                    </p>
                    <p>
                        <label for="user_pass">Repetir Contraseña
                            <br />
                            <input type="password" name="new_password2" id="new_password2" class="input" value="" size="20" /> </label>
                    </p>
                        <p class="submit">
                            <input type="submit" name="change" id="change" class="button" value="Cambiar" /> </p>
                </form>
                <br/ >
                <a style="float:right; padding-top:10px;" href="index.php">Volver</a>
            </div>
        </div>
<?php include("includes/footer.php"); ?>