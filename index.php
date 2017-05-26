<?php
session_start();
include("includes/header.php");
if(isset($_SESSION["username"])){ 
    header("Location: Home.php");
}

?>
                <div class="container mlogin">
                    <div id="login">
                        <label for="error" class="error"><?php echo $_SESSION['Error'];?></label>
                        <h1>Login</h1>
                        <form name="loginform" id="loginform" action="Pass.php" method="post">
                            <p>
                                <label for="user_login">Nombre De Usuario 2
                                    <br />
                                    <input type="text" name="username" id="username" class="input" value="" size="20" /> </label>
                            </p>
                            <p>
                                <label for="user_pass">Contraseña
                                    <br />
                                    <input type="password" name="password" id="password" class="input" value="" size="20" /> </label>
                            </p>
                            <p class="submit">
                                <input type="submit" name="login" id="login" class="button" value="Entrar" /> </p>
                        </form>
                    </div>
                </div>
                <?php include("includes/footer.php"); ?>
