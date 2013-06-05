<!DOCTYPE HTML>
<html>
    <head>
        <title>Womics | Adrian Mihaila & Saveluc Diana</title>
        <link rel="stylesheet" type="text/css" href="../../../css/main.css" />
        <script type="text/javascript">
            function Redirect(){
                window.location.href = "signup.php";
            }
        </script>
    </head>
    <body>
        <div id="content-log">
            <form action="../controllers/signin.php" method="post">
                <label class="row-head">
                    Email:
                </label>
                
                <input type="email" name="email" id="email" class="input-login"/>
                
                <label class="row-head">
                    Password:
                </label>
                
                <input type="password" name="password" id="password" class="input-login"/>
                
                <input type="submit" value="Sign in" class="input-login"/> or <input type="button" value="Sign up" onclick="Redirect()" class="input-login"/>
            </form>
        </div>
    </body>
</html>