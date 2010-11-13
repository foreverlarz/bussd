<?php

require_once "global.php";



if (isset($_POST["create"])) {

    if (empty($_POST["subject"])) {

        die("you must enter a subject. please go back and enter one.");

    };

    $subject    = (!empty($_POST["subject"]))       ? "'".clean($_POST["subject"])."'"  : 'DEFAULT';
    $owner      = (is_numeric($_POST["owner"]))     ? $_POST["owner"]                   : 'DEFAULT';
    $milestone  = (is_numeric($_POST["milestone"])) ? $_POST["milestone"]               : 'DEFAULT';
    $status     = (is_numeric($_POST["status"]))    ? $_POST["status"]                  : 'DEFAULT';
    $severity   = (is_numeric($_POST["severity"]))  ? $_POST["severity"]                : 'DEFAULT';
    $type       = (is_numeric($_POST["type"]))      ? $_POST["type"]                    : 'DEFAULT';
    $message    = (!empty($_POST["message"]))       ? "'".clean($_POST["message"])."'"  : 'DEFAULT';

    $sql  = "INSERT INTO {$table_prefix}issue   ".
            "SET owner_id       = $owner      , ".
            "    milestone_id   = $milestone  , ".
            "    status_id      = $status     , ".
            "    severity_id    = $severity   , ".
            "    type_id        = $type       , ".
            "    subject        = $subject      ";

    if (!$result = mysql_query($sql)) print_error();

    $issue_id = mysql_insert_id();

    if (empty($issue_id)) {

        die("something terrible happened. sorry.");

    };

    $sql  = "INSERT INTO {$table_prefix}issue_revision  ".
            "SET issue_id       = $issue_id          ,  ".
            "    author_id      = {$bussd["user_id"]},  ".
            "    date           = UNIX_TIMESTAMP()   ,  ".
            "    owner_id       = $owner             ,  ".
            "    milestone_id   = $milestone         ,  ".
            "    status_id      = $status            ,  ".
            "    severity_id    = $severity          ,  ".
            "    type_id        = $type              ,  ".
            "    subject        = $subject           ,  ".
            "    message        = $message              ";
    if (!$result = mysql_query($sql)) print_error();

    header("Location: issue.php?id=$issue_id");

}



header('Content-Type: text/html; charset=utf-8');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <title>create&mdash;issue&mdash;<?php echo $project_name; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="style.php" />
    </head>
    <body>
        <div id="contain">
            <h1><a href="index.php"><?php echo $project_name; ?></a></h1>
            <h2><a href="index.php">issues</a> &raquo; create</h2>
            <form action="issue_create.php" method="post">
                <table id="create">
                    <tr>
                        <th>subject</th>
                        <td><input type="text" name="subject" class="required" /></td>
                    </tr>
                    <tr>
                        <th>owner</th>
                        <td>
                            <select name="owner">
                                <option value="0">undetermined</option>
<?php
    $sql = "SELECT id, name FROM {$table_prefix}user ORDER BY id";
    if (!$result = mysql_query($sql)) print_error();
    while (list($owner_id, $owner_name) = mysql_fetch_row($result)) {
        echo "                                <option value=\"$owner_id\">".output($owner_name)."</option>\n";
    };
?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>milestone</th>
                        <td>
                            <select name="milestone">
                                <option value="0">undetermined</option>
<?php
    $sql = "SELECT id, name FROM {$table_prefix}milestone ORDER BY id";
    if (!$result = mysql_query($sql)) print_error();
    while (list($milestone_id, $milestone_name) = mysql_fetch_row($result)) {
        echo "                                <option value=\"$milestone_id\">".output($milestone_name)."</option>\n";
    };
?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>status</th>
                        <td>
                            <select name="status">
                                <option value="0">undetermined</option>
<?php
    $sql = "SELECT id, name FROM {$table_prefix}status ORDER BY id";
    if (!$result = mysql_query($sql)) print_error();
    while (list($status_id, $status_name) = mysql_fetch_row($result)) {
        echo "                                <option value=\"$status_id\">".output($status_name)."</option>\n";
    };
?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>severity</th>
                        <td>
                            <select name="severity">
                                <option value="0">undetermined</option>
<?php
    $sql = "SELECT id, name FROM {$table_prefix}severity ORDER BY id";
    if (!$result = mysql_query($sql)) print_error();
    while (list($severity_id, $severity_name) = mysql_fetch_row($result)) {
        echo "                                <option value=\"$severity_id\">".output($severity_name)."</option>\n";
    };
?>
                    </select>
                        </td>
                    </tr>
                    <tr>
                        <th>type</th>
                        <td>
                            <select name="type">
                                <option value="0">undetermined</option>
<?php
    $sql = "SELECT id, name FROM {$table_prefix}type ORDER BY id";
    if (!$result = mysql_query($sql)) print_error();
    while (list($type_id, $type_name) = mysql_fetch_row($result)) {
        echo "                                <option value=\"$type_id\">".output($type_name)."</option>\n";
    };
?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>message</th>
                        <td>
                            <textarea cols="72" rows="10" name="message"></textarea>
                        </td>
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
