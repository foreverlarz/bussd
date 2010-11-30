<?php

require_once "global.php";

if (isset($_POST["revise"])) {

    if (!is_numeric($_POST["revise"])) {

        die("you must specify a valid id.");

    } else {

        $issue_id = $_POST["revise"];

    };

    $sql = "SELECT *                    ".
           "FROM {$table_prefix}issue   ".
           "WHERE id = $issue_id        ";
    if (!$result = mysql_query($sql)) print_error();

    if (mysql_num_rows($result) !== 1)   {

        die("you must specify a valid id.");

    };

    $current = mysql_fetch_array($result);

    $owner      = ($_POST["owner"]     != $current["owner_id"]     && is_numeric($_POST["owner"]))     ? $_POST["owner"]                   : 'DEFAULT';
    $milestone  = ($_POST["milestone"] != $current["milestone_id"] && is_numeric($_POST["milestone"])) ? $_POST["milestone"]               : 'DEFAULT';
    $status     = ($_POST["status"]    != $current["status_id"]    && is_numeric($_POST["status"]))    ? $_POST["status"]                  : 'DEFAULT';
    $severity   = ($_POST["severity"]  != $current["severity_id"]  && is_numeric($_POST["severity"]))  ? $_POST["severity"]                : 'DEFAULT';
    $type       = ($_POST["type"]      != $current["type_id"]      && is_numeric($_POST["type"]))      ? $_POST["type"]                    : 'DEFAULT';
    $subject    = ($_POST["subject"]   != $current["subject"]      && !empty($_POST["subject"]))       ? "'".clean($_POST["subject"])."'"  : 'DEFAULT';
    $message    = (!empty($_POST["message"]))                                                          ? "'".clean($_POST["message"])."'"  : 'DEFAULT';

    if ($owner     == 'DEFAULT' &&
        $milestone == 'DEFAULT' &&
        $status    == 'DEFAULT' &&
        $severity  == 'DEFAULT' &&
        $type      == 'DEFAULT' &&
        $subject   == 'DEFAULT' &&
        $message   == 'DEFAULT'    ) {

        die("you didn't enter a message or make any other changes.");

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

    $change = array();

    if ($owner     != 'DEFAULT') $change[] = "owner_id     = $owner";
    if ($milestone != 'DEFAULT') $change[] = "milestone_id = $milestone";
    if ($status    != 'DEFAULT') $change[] = "status_id    = $status";
    if ($severity  != 'DEFAULT') $change[] = "severity_id  = $severity";
    if ($type      != 'DEFAULT') $change[] = "type_id      = $type";
    if ($subject   != 'DEFAULT') $change[] = "subject      = $subject";

    $sql = '';

    foreach ($change as $value) {

        $sql .= (empty($sql)) ? "UPDATE {$table_prefix}issue SET $value" : ", $value";

    };

    if (!empty($sql)) {

        $sql .= " WHERE id = $issue_id";
    
        if (!$result = mysql_query($sql)) print_error();
        
    };

    if ($owner != 'DEFAULT') {

        if ($owner != $bussd["user_id"]) bust_an_email($owner, $issue_id, 'given');
        if ($current["owner_id"] != $bussd["user_id"]) bust_an_email($current["owner_id"], $issue_id, 'taken');

    };

    header("Location: issue.php?id=$issue_id");

};



if (empty($_GET["id"]) || !is_numeric($_GET["id"])) {

    die("you must specify a valid id.");

} else {

    $id = $_GET["id"];

};

header('Content-Type: text/html; charset=utf-8');

$sql = "SELECT {$table_prefix}owner.id      owner_id     ,                          ".
       "       {$table_prefix}milestone.id  milestone_id ,                          ".
       "       {$table_prefix}status.id     status_id    ,                          ".
       "       {$table_prefix}severity.id   severity_id  ,                          ".
       "       {$table_prefix}type.id       type_id      ,                          ".
       "       {$table_prefix}issue.subject subject                                 ".
       "FROM {$table_prefix}issue                                                   ".
       "LEFT JOIN {$table_prefix}user {$table_prefix}owner                          ".
       "       ON {$table_prefix}owner.id = {$table_prefix}issue.owner_id           ".
       "LEFT JOIN {$table_prefix}milestone                                          ".
       "       ON {$table_prefix}milestone.id = {$table_prefix}issue.milestone_id   ".
       "LEFT JOIN {$table_prefix}status                                             ".
       "       ON {$table_prefix}status.id = {$table_prefix}issue.status_id         ".
       "LEFT JOIN {$table_prefix}severity                                           ".
       "       ON {$table_prefix}severity.id = {$table_prefix}issue.severity_id     ".
       "LEFT JOIN {$table_prefix}type                                               ".
       "       ON {$table_prefix}type.id = {$table_prefix}issue.type_id             ".
       "WHERE {$table_prefix}issue.id = $id                                         ";
if (!$result = mysql_query($sql)) print_error();

if (mysql_num_rows($result) !== 1) {

    die("you must specify a valid id.");

};

$row = mysql_fetch_array($result);

$owner_id     = output($row["owner_id"]);
$milestone_id = output($row["milestone_id"]);
$status_id    = output($row["status_id"]);
$severity_id  = output($row["severity_id"]);
$type_id      = output($row["type_id"]);
$subject      = output($row["subject"]);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <title>revise&mdash;issue&mdash;<?php echo $project_name; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="style.php" />
    </head>
    <body>
        <div id="contain">
            <h1><a href="index.php"><?php echo $project_name; ?></a></h1>
<?php

echo <<<EOF
            <h2><a href="index.php">issues</a> &raquo; <a href="issue.php?id=$id">$subject</a> &raquo; revise</h2>

EOF;

?>
            <form action="issue_revise.php" method="post">
                <table id="revise">
                    <tr>
                        <th>message</th>
                        <td>
                            <textarea cols="72" rows="10" name="message"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="2" class="more">revise the issue by changing the fields below.</th>
                    </tr>
                    <tr>
                        <th>subject</th>
                        <td><input type="text" name="subject" value="<?php echo $subject; ?>" class="required" /></td>
                    </tr>
                    <tr>
                        <th>owner</th>
                        <td>
                            <select name="owner">
                                <option value="0">undetermined</option>
<?php

    $sql = "SELECT id, name FROM {$table_prefix}user ORDER BY id";
    if (!$result = mysql_query($sql)) print_error();
    while ($row = mysql_fetch_array($result)) {

        $option_id = $row["id"];
        $option_name = output($row["name"]);

        if ($owner_id == $option_id) { $sel = ' selected="selected"'; }
        else { unset($sel); };

        echo <<<EOF
                                <option value="$option_id"$sel>$option_name</option>

EOF;

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
    while ($row = mysql_fetch_array($result)) {

        $option_id = $row["id"];
        $option_name = output($row["name"]);

        if ($milestone_id == $option_id) { $sel = ' selected="selected"'; }
        else { unset($sel); };

        echo <<<EOF
                                <option value="$option_id"$sel>$option_name</option>

EOF;

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
    while ($row = mysql_fetch_array($result)) {

        $option_id = $row["id"];
        $option_name = output($row["name"]);

        if ($status_id == $option_id) { $sel = ' selected="selected"'; }
        else { unset($sel); };

        echo <<<EOF
                                <option value="$option_id"$sel>$option_name</option>

EOF;

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
    while ($row = mysql_fetch_array($result)) {

        $option_id = $row["id"];
        $option_name = output($row["name"]);

        if ($severity_id == $option_id) { $sel = ' selected="selected"'; }
        else { unset($sel); };

        echo <<<EOF
                                <option value="$option_id"$sel>$option_name</option>

EOF;

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
    while ($row = mysql_fetch_array($result)) {

        $option_id = $row["id"];
        $option_name = output($row["name"]);

        if ($type_id == $option_id) { $sel = ' selected="selected"'; }
        else { unset($sel); };

        echo <<<EOF
                                <option value="$option_id"$sel>$option_name</option>

EOF;

    };

?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <td>
                            <input type="hidden" name="revise" value="<?php echo $id; ?>" />
                            <input type="submit" value="submit" class="submit" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>
