<?php

if (isset($_POST["hello"])) {

    $_SESSION["username"] = substr($_POST["username"], 0, 16);
    $_SESSION["password"] = sha1($_POST["password"]);

};



if (isset($_GET["goodbye"])) {

    session_destroy();

};



if (!empty($_SESSION['username']) && !empty($_SESSION['password'])) {

    $username = clean($_SESSION['username']);
    $password = clean($_SESSION['password']);

    $sql = "SELECT id                   ".
           "FROM {$table_prefix}user    ".
           "WHERE name='$username'      ".
           "  AND password='$password'  ";
    if (!$result = mysql_query($sql)) showerror();

    if (mysql_num_rows($result) === 1) {

        list($bussd["user_id"]) = mysql_fetch_array($result);

    } else {

        session_destroy();

    };

};



if (empty($bussd["user_id"]) || !is_numeric($bussd["user_id"])):

header('Content-Type: text/html; charset=utf-8');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
    <title>authenticate&mdash;<?php echo $project_name; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="style.php" />
    </head>
    <body>
        <div id="contain">
            <h1><?php echo $project_name; ?></h1>
            <h2>authenticate</h2>
            <form action="index.php" method="post">
                <table id="auth">
                    <tr>
                        <th>username</th>
                        <td><input type="text" name="username" /></td>
                    </tr>
                    <tr>
                        <th>password</th>
                        <td><input type="password" name="password" /></td>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <td>
                            <input type="hidden" name="hello" />
                            <input type="submit" value="submit" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>
<?php

die();

endif;

?>
