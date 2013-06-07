<?php $model = new AdminModelDefault(); ?> 
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

        <!--script src="http://code.jquery.com/jquery-1.9.1.js"></script-->
        <script type="text/javascript">

            var ch = 0;
            function Logout() {
                deleteCookie('user_id');
                deleteCookie('user_session_id');
                window.location.href = "<?= WSystem::$url ?>admin";
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
                if (ch === 1) {
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


        <div class="content">
            <header>
                <section id="admin-header-left">
                    <h1>Bine ai venit, <?php
                            $result = $model->getUser(null);
                            echo $result['nume'] . " " . $result['prenume'];
                        ?>!</h1>
                    <input type="button" value="Logout" onclick="Logout()" class="input-logout"/>
                </section>
                <nav id="admin-header-navigation">
                    <?php echo $nav = $model->createMenu($result['tip_admin']); ?>
                </nav>

            </header>

            <div id="PeopleTableContainer"  style="width: 980px;margin: 0 auto;"></div>


            <div id="PeopleTableContainer" style="width: 980px;"></div>
        </div>
        <script type="text/javascript">

            $(document).ready(function() {

                    //Prepare jTable
                    $('#PeopleTableContainer').jtable({
                            title: 'Table of users',
                            paging: true,
                            pageSize: 5,
                            sorting: true,
                            defaultSorting: 'nume ASC',
                            actions: {
                                listAction: '<?=WSystem::$url?>admin/adminTableCRUD/list',
                                createAction: '<?=WSystem::$url?>admin/adminTableCRUD/create',
                                updateAction: '<?=WSystem::$url?>admin/adminTableCRUD/update',
                                deleteAction: '<?=WSystem::$url?>admin/adminTableCRUD/delete'
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
                                prenume: {
                                    title: 'Prenume',
                                    width: '20%'
                                },
                                email: {
                                    title: 'Email',
                                    width: '20%'

                                },
                                punct_de_lucru: {
                                    title: 'Punct de lucru',
                                    width: '20%',
                                    options: <?=$model->getWorkpointsJSON()?>

                                },
                                tip_utilizator: {
                                    title: 'Tip admin',
                                    width: '20%',
                                    options: <?=$model->getTipUtilizatorJSON()?>

                                },
                                parola: {
                                    title: 'Parola',
                                    width: '20%',
                                    type: 'password',
                                    create: true,
                                    edit: false,
                                    list: false
                                }
                            }
                    });

                    //Load person list from server
                    $('#PeopleTableContainer').jtable('load');

            });


        </script>    
    </body>

</html>
