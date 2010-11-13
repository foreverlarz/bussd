<?php

require_once "global.php";



if (empty($_GET["id"]) || !is_numeric($_GET["id"])) {

    die("you must specify a valid id.");

} else {

    $id = $_GET["id"];

};



header('Content-Type: text/html; charset=utf-8');

$sql = "SELECT {$table_prefix}owner.name        owner     ,                         ".
       "       {$table_prefix}milestone.name    milestone ,                         ".
       "       {$table_prefix}status.name       status    ,                         ".
       "       {$table_prefix}severity.name     severity  ,                         ".
       "       {$table_prefix}type.name         type      ,                         ".
       "       {$table_prefix}issue.subject     subject                             ".
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

$owner     = output($row["owner"]);
$milestone = output($row["milestone"]);
$status    = output($row["status"]);
$severity  = output($row["severity"]);
$type      = output($row["type"]);
$subject   = output($row["subject"]);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <title><?php echo $subject; ?>&mdash;issue&mdash;<?php echo $project_name; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="style.php" />
    </head>
    <body>
        <div id="contain">
            <h1><a href="index.php"><?php echo $project_name; ?></a></h1>
<?php

echo <<<EOF
            <h2><a href="index.php">issues</a> &raquo; $subject</h2>
            <table id="info">
                <tr>
                    <th>owner</th>
                    <td>$owner</td>
                </tr>
                <tr>
                    <th>milestone</th>
                    <td>$milestone</td>
                </tr>
                <tr>
                    <th>status</th>
                    <td>$status</td>
                </tr>
                <tr>
                    <th>severity</th>
                    <td>$severity</td>
                </tr>
                <tr>
                    <th>type</th>
                    <td>$type</td>
                </tr>
            </table>

EOF;

$sql = "SELECT {$table_prefix}issue_revision.id      revision  ,                            ".
       "       {$table_prefix}author.name            author    ,                            ".
       "       {$table_prefix}issue_revision.date    date      ,                            ".
       "       {$table_prefix}owner.name             owner     ,                            ".
       "       {$table_prefix}milestone.name         milestone ,                            ".
       "       {$table_prefix}status.name            status    ,                            ".
       "       {$table_prefix}severity.name          severity  ,                            ".
       "       {$table_prefix}type.name              type      ,                            ".
       "       {$table_prefix}issue_revision.subject subject   ,                            ".
       "       {$table_prefix}issue_revision.message message                                ".
       "FROM {$table_prefix}issue_revision                                                  ".
       "LEFT JOIN {$table_prefix}user {$table_prefix}author                                 ".
       "       ON {$table_prefix}author.id = {$table_prefix}issue_revision.author_id        ".
       "LEFT JOIN {$table_prefix}user {$table_prefix}owner                                  ".
       "       ON {$table_prefix}owner.id = {$table_prefix}issue_revision.owner_id          ".
       "LEFT JOIN {$table_prefix}milestone                                                  ".
       "       ON {$table_prefix}milestone.id = {$table_prefix}issue_revision.milestone_id  ".
       "LEFT JOIN {$table_prefix}status                                                     ".
       "       ON {$table_prefix}status.id = {$table_prefix}issue_revision.status_id        ".
       "LEFT JOIN {$table_prefix}severity                                                   ".
       "       ON {$table_prefix}severity.id = {$table_prefix}issue_revision.severity_id    ".
       "LEFT JOIN {$table_prefix}type                                                       ".
       "       ON {$table_prefix}type.id = {$table_prefix}issue_revision.type_id            ".
       "WHERE {$table_prefix}issue_revision.issue_id = $id                                  ".
       "ORDER BY {$table_prefix}issue_revision.date                                         ";
if (!$result = mysql_query($sql)) print_error();
while ($row = mysql_fetch_array($result)) {

    $author = output($row["author"]);
    $date = outputdate($row["date"]);
    $message = outputmessage($row["message"]);

    echo <<<EOF
            <div class="revision">
                <div class="author">$author</div>
                <div class="date">$date</div>
                <p class="message">$message</p>
            </div>

EOF;

};

?>
        </div>
    </body>
</html>
