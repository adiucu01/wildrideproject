<!DOCTYPE HTML>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="<?= WSystem::$url ?>assets/css/main.css" />
    </head>
    <body>
        <div class="content">
            <div id="login-form"/>
                <form action="<?= WSystem::$url ?>admin/signin" method="post">
                    <label>
                        Email:
                    </label>

                    <input type="email" name="email" id="email" class="input-login"/>

                    <label>
                        Password:
                    </label>

                    <input type="password" name="password" id="password" class="input-login"/>
                    <label></label>
                    <input type="submit" value="Sign in" class="input-login"/>
                </form>
            </div>
        </div>
    </body>
</html>