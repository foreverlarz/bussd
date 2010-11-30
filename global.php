<?php

/******************************************************************************
 *                                   buss'd                                   *
 ******************************************************************************
 * Copyright (c) 2010 Jonathan Lucas Reddinger <lucas@wingedleopard.net>      *
 *                                                                            *
 * Permission to use, copy, modify, and distribute this software for any      *
 * purpose with or without fee is hereby granted, provided that the above     *
 * copyright notice and this permission notice appear in all copies.          *
 *                                                                            *
 * THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES   *
 * WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF           *
 * MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR    *
 * ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES     *
 * WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN      *
 * ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF    *
 * OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.             *
 ******************************************************************************/

require_once "config.php";
mb_internal_encoding('UTF-8');
session_start();
date_default_timezone_set($timezone);

/********************************************************
 * REMOVE MAGIC QUOTES                                  *
 *                                                      *
 * php.net/manual/en/security.magicquotes.disabling.php *
 ********************************************************/
if (get_magic_quotes_gpc()) {
    function stripslashes_deep($value) {
        $value = is_array($value) ?
            array_map('stripslashes_deep', $value) :
            stripslashes($value);
        return $value;
    };
    $_POST = array_map('stripslashes_deep', $_POST);
    $_GET = array_map('stripslashes_deep', $_GET);
    $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
    $_REQUEST = array_map('stripslashes_deep', $_REQUEST);
};


/***************
 * PRINT ERROR *
 ***************/
function print_error() {
    if (mysql_error()) {
        echo "<strong>mysql dbms error ".mysql_errno()."</strong>: ".
            mysql_error()."\n";
    } else {
        echo "<strong>fatal error</strong>: could not connect to the mysql dbms.\n";
    };
    die();
};


/***************
 * CLEAN INPUT *
 ***************/
function clean($text) {
    return mysql_real_escape_string($text);
};


/*****************
 * FORMAT OUTPUT *
 *****************/
function output($text, $blank = 0) {
    if ($blank == 1 && ($text === NULL || $text === '')) return '<em>unspecified</em>';
    return htmlspecialchars($text, ENT_COMPAT, "UTF-8");
};


/******************
 * OUTPUT MESSAGE *
 ******************/
function outputmessage($text) {
    return nl2br(output($text));
};


/***************
 * OUTPUT DATE *
 ***************/
function outputdate($timestamp) {
    global $date_format;
    return strtolower(date($date_format, $timestamp));
};


/*************************
 * CONNECT TO MYSQL DBMS *
 *************************/
if (!$dbmscnx = @mysql_pconnect($dbms_host, $dbms_user, $dbms_pass)) print_error();
if (!mysql_select_db($dbms_db)) print_error();
if (!mysql_query("SET NAMES 'utf8'")) print_error();


/*********************
 * AUTHENTICATE USER *
 *********************/
require_once "authenticate.php";

?>
