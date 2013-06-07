<?php
//require_once("/../models/default.php");
$model = new AdminModelDefault();
if (!$model->isValidUser())
    die();
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>WildRide | Adrian Mihaila & Saveluc Diana & Unknown</title>
        <link rel="stylesheet" type="text/css" href="<?= WSystem::$url ?>assets/css/main.css" /> 
        <!--script src="http://code.jquery.com/jquery-1.9.1.js"></script-->
        <link href="<?= WSystem::$url ?>assets/js/jtable/themes/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
        <link href="<?= WSystem::$url ?>assets/js/jtable/scripts/jtable/themes/lightcolor/blue/jtable.css" rel="stylesheet" type="text/css" />   
        <script src="<?= WSystem::$url ?>assets/js/jtable/scripts/jquery-1.6.4.min.js" type="text/javascript"></script>
        <script src="<?= WSystem::$url ?>assets/js/jtable/scripts/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
        <script src="<?= WSystem::$url ?>assets/js/jtable/scripts/jtable/jquery.jtable.js" type="text/javascript"></script>


        <script type="text/javascript">
            var ch = 0;
            function Logout() {
                deleteCookie('user_id');
                deleteCookie('user_session_id');
                window.location.href = "login.php";
            }
            function deleteCookie(name) {
                var date = new Date();
                date.setTime(date.getTime() + (-1 * 24 * 60 * 60 * 1000));
                var expires = " expires=" + date.toGMTString();
                document.cookie = name + "=;" + expires + "; path=/";
            }
            function checkAll(checktoggle)
            {
                var checkboxes = new Array();
                checkboxes = document.getElementsByName('select[]');
                if (ch == 1) {
                    checktoggle = false;
                    ch = 0;
                }
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type === 'checkbox') {
                        checkboxes[i].checked = checktoggle;
                    }
                }
                ch++;
                if (!checktoggle)
                    ch = 0;
            }
            function submitDeleteAll() {
                if (confirm('Do you really want to delete?')) {
                    document.getElementById('delete_all').submit();
                }
            }
            function goToPage() {
                var pagenum = document.getElementById("pagenum").value;
                window.location = document.URL + "?pagenum=" + pagenum;
            }
        </script> 
    </head>
    <body> 


        <header>
            <div class="content">
                <div id="logo">
                    <a href="default.php" title="WildRide"><img src="<?= WSystem::$url ?>/img/logo.png" alt="WildRide"/></a>
                </div>

                <div id="navigator">
                    <p>Bine ai venit, <?php $result = $model->getUser(null);
echo $result['nume'] . " " . $result['prenume'];
?>!<input type="button" value="Logout" onclick="Logout()" class="input-logout"/></p>

                    <nav>
<?php echo $nav = $model->createMenu($result['tip_admin']); ?>
                    </nav>
                </div>

            </div>
        </header>





        <div id="WorkpointTableContainer"  style="width: 600px;margin-left:auto;margin-top:100px;margin-right:auto;"></div>
        <script type="text/javascript">

            $(document).ready(function() {



                $('#WorkpointTableContainer').jtable({
                    title: 'Table of workpoints',
                    paging: true,
                    pageSize: 5,
                    sorting: true,
                    defaultSorting: 'nume ASC',
                    actions: {
                        listAction: '<?= WSystem::$url ?>admin/workpointCRUD/list',
                        createAction: '<?= WSystem::$url ?>admin/workpointCRUD/create',
                        updateAction: '<?= WSystem::$url ?>admin/workpointCRUD/update',
                        deleteAction: '<?= WSystem::$url ?>admin/workpointCRUD/delete'
                    },
                    fields: {
                        id: {
                            key: true,
                            create: false,
                            edit: false,
                            list: false
                        },
                        nume: {
                            title: 'Nume',
                            width: '20%'
                        },
                        oras: {
                            title: 'Oras',
                            width: '20%'
                        },
                        judet: {
                            title: 'Judet',
                            width: '20%'
                        },
                        adresa: {
                            title: 'Adresa',
                            width: '20%'
                        }

                    }
                });

                //Load person list from server
                $('#WorkpointTableContainer').jtable('load');

            });

        </script>              
    </body>
</html>
