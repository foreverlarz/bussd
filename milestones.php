<?php

require_once "global.php";



if (!empty($_GET["delete"])) {

    if (!is_numeric($_GET["delete"])) {

        die("you must specify a valid id.");

    } else {

        $id = $_GET["delete"];

    };

    $sql = "DELETE FROM {$table_prefix}milestone    ".
           "WHERE id = $id                          ";
    if (!$result = mysql_query($sql)) print_error();

    header("Location: milestones.php");

};



if (isset($_POST["create"])) {

    if (empty($_POST["name"])) {

        die("you must enter a name. please go back and enter one.");

    };

    $name = (!empty($_POST["name"])) ? "'".clean($_POST["name"])."'" : 'DEFAULT';

    $sql = "INSERT INTO {$table_prefix}milestone    ".
           "SET name = $name                        ";
    if (!$result = mysql_query($sql)) print_error();

    header("Location: milestones.php");

};



if (!empty($_POST["update"])) {

    if (!is_numeric($_POST["update"])) {

        die("you must specify a valid id.");

    } else {

        $id = $_POST["update"];

    };

    if (empty($_POST["name"])) {

        die("you must enter a name. please go back and enter one.");

    };

    $name = (!empty($_POST["name"])) ? "'".clean($_POST["name"])."'" : 'DEFAULT';

    $sql = "UPDATE {$table_prefix}milestone ".
           "SET name = $name                ".
           "WHERE id = $id                  ";
    if (!$result = mysql_query($sql)) print_error();

    header("Location: milestones.php");

};



if (!empty($_GET["update"])) {

    if (!is_numeric($_GET["update"])) {

        die("you must specify a valid id.");

    } else {

        $id = $_GET["update"];

    };

    $sql = "SELECT *                        ".
           "FROM {$table_prefix}milestone   ".
           "WHERE id = $id                  ";
    if (!$result = mysql_query($sql)) print_error();
    $row = mysql_fetch_array($result);

    $id   = output($row["id"]);
    $name = output($row["name"]);

    header('Content-Type: text/html; charset=utf-8');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <title>update&mdash;milestone&mdash;<?php echo $project_name; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="style.php" />
    </head>
    <body>
        <div id="contain">
            <h1><a href="index.php"><?php echo $project_name; ?></a></h1>
            <h2><a href="milestones.php">milestones</a> &raquo; update</h2>
            <form action="milestones.php" method="post">
                <table id="update">
                    <tr>
                        <th>name</th>
                        <td><input type="text" name="name" value="<?php echo $name; ?>" /></td>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <td>
                            <input type="hidden" name="update" value="<?php echo $id; ?>" />
                            <input type="submit" value="submit" class="submit" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>
<?php

    die();

};



if (isset($_GET["create"])) {

    header('Content-Type: text/html; charset=utf-8');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <title>create&mdash;milestone&mdash;<?php echo $project_name; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="style.php" />
    </head>
    <body>
        <div id="contain">
            <h1><a href="index.php"><?php echo $project_name; ?></a></h1>
            <h2><a href="milestones.php">milestones</a> &raquo; create</h2>
            <form action="milestones.php" method="post">
                <table id="create">
                    <tr>
                        <th>name</th>
                        <td><input type="text" name="name" /></td>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <td>
                            <input type="hidden" name="create" />
                            <input type="submit" value="submit" class="submit" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>
<?php

    die();

};

header('Content-Type: text/html; charset=utf-8');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <title>milestones&mdash;<?php echo $project_name; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="style.php" />
    </head>
    <body>
        <div id="contain">
            <h1><a href="index.php"><?php echo $project_name; ?></a></h1>
            <h2>milestones</h2>
            <div id="create"><a href="milestones.php?create">create</a></div>
            <table id="list">
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>actions</th>
                </tr>
<?php

$sql = "SELECT *                        ".
       "FROM {$table_prefix}milestone   ".
       "ORDER BY id                     ";
if (!$result = mysql_query($sql)) print_error();
while ($row = mysql_fetch_array($result)) {

    $id   = $row["id"];
    $name = output($row["name"]);

    echo <<<EOF
                <tr>
                    <td>$id</td>
                    <td>$name</td>
                    <td>
                        <a href="milestones.php?update=$id"><img src="icon_update.png" alt="update" /></a>
                        <a href="milestones.php?delete=$id"><img src="icon_delete.png" alt="delete" /></a>
                    </td>
                </tr>

EOF;

};

?>
            </table>
        </div>
    </body>
</html>
