<?php

require_once "global.php";



header('Content-Type: text/html; charset=utf-8');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <title>issues&mdash;<?php echo $project_name; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="style.php" />
    </head>
    <body>
        <div id="contain">
            <h1><?php echo $project_name; ?></h1>
            <h2>issues</h2>
            <div id="create"><a href="issue_create.php">create an issue</a></div>
            <table id="list">
                <tr>
                    <th>id</th>
                    <th>owner</th>
                    <th>milestone</th>
                    <th>status</th>
                    <th>severity</th>
                    <th>type</th>
                    <th>subject</th>
                </tr>
<?php

$sql = "SELECT {$table_prefix}issue.id       issue     ,                            ".
       "       {$table_prefix}owner.name     owner     ,                            ".
       "       {$table_prefix}milestone.name milestone ,                            ".
       "       {$table_prefix}status.name    status    ,                            ".
       "       {$table_prefix}severity.name  severity  ,                            ".
       "       {$table_prefix}type.name      type      ,                            ".
       "       {$table_prefix}issue.subject  subject                                ".
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
       "ORDER BY {$table_prefix}issue.id                                            ";
if (!$result = mysql_query($sql)) print_error();
while ($row = mysql_fetch_array($result)) {

    $owner     = output($row["owner"]);
    $milestone = output($row["milestone"]);
    $status    = output($row["status"]);
    $severity  = output($row["severity"]);
    $type      = output($row["type"]);
    $subject   = output($row["subject"]);

    echo <<<EOF
                <tr>
                    <td><a href="issue.php?id={$row["issue"]}">{$row["issue"]}</a></td>
                    <td>$owner</td>
                    <td>$milestone</td>
                    <td>$status</td>
                    <td>$severity</td>
                    <td>$type</td>
                    <td>$subject</td>
                </tr>

EOF;

};

?>
            </table>
        </div>
    </body>
</html>
