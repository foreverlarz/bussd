<?php

header("Content-type: text/css");

?>
body {
    font-family: Verdana, Arial, Helvetica, sans-serif;
}

a {
    color: black;
}

img {
    border-width: 0;
}

ul {
    padding: 0 0 0 1em;
    margin: 0;
}

input {
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 100%;
}

select {
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 100%;
}

textarea {
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 100%;
}

table#auth {
    border-collapse: collapse;
    font-size: 80%;
}

table#auth tr th {
    border: 1px solid #cccccc;
    padding: 4px;
    text-align: right;
}

table#auth tr td {
    border: 1px solid #cccccc;
    padding: 4px;
}

table#auth tr td input {
    width: 125px;
}

table#list {
    border-collapse: collapse;
    font-size: 80%;
    margin-top: 25px;
}

table#list tr th {
    padding: 2px 0.5em;
    text-align: left;
    border-top: 1px solid #000099;
    border-bottom: 1px solid #000099;
    background: #ccccff;
}

table#list tr td {
    border-bottom: 1px solid #cccccc;
    padding: 2px 0.5em;
    text-align: right;
}

table#list tr td+td {
    border-left: 1px solid #cccccc;
    text-align: left;
}

table#create {
    border-collapse: collapse;
    font-size: 80%;
}

table#create tr th {
    border: 1px solid #cccccc;
    padding: 4px;
    text-align: right;
}

table#create tr td {
    border: 1px solid #cccccc;
    padding: 4px;
}

table#create tr td input {
    width: 500px;
}

table#create tr td select {
    width: 200px;
}

table#create tr td textarea {
    width: 500px;
}

table#create tr td input.submit {
    width: 200px;
}

table#update {
    border-collapse: collapse;
    font-size: 80%;
}

table#update tr th {
    border: 1px solid #cccccc;
    padding: 4px;
    text-align: right;
}

table#update tr td {
    border: 1px solid #cccccc;
    padding: 4px;
}

table#update tr td input {
    width: 500px;
}

table#update tr td select {
    width: 200px;
}

table#update tr td textarea {
    width: 500px;
}

table#update tr td input.submit {
    width: 200px;
}

/* issue.php */

table#info {
    border-collapse: collapse;
    font-size: 80%;
    margin-top: 25px;
}

table#info tr th {
    padding: 2px 6px;
    text-align: left;
    border: 1px solid #cccccc;
}

table#info tr td {
    border: 1px solid #cccccc;
    padding: 2px 6px;
}

div.revision {
    border: solid 1px #000099;
    background-color: #ccccff;
    margin-top: 25px;
    width: 600px;
}

div.revision div.author {
    float: left;
    margin: 2px 6px;
}

div.revision div.date {
    float: right;
    margin: 2px 6px;
}

div.revision p.message {
    clear: both;
    overflow: auto;
    background-color: white;
    margin: 2px 0 0 0;
    padding: 6px;
}

div.revision div.attributes {
    clear: both;
    overflow: auto;
    background-color: #efefef;
    padding: 6px;
    font-size: 80%;
}

fieldset#revise {
    border: solid 1px #000099;
    width: 600px;
    margin: 25px 0 0 0;
    padding: 0;
}

fieldset#revise textarea {
    width: 588px;
    border-width: 0;
    margin: 0;
    padding: 6px;
}

fieldset#revise input.submit {
    width: 600px;
    background-color: #ccccff;
    border-width: 0;
}

/* issue_revise.php */

table#revise {
    border-collapse: collapse;
    font-size: 80%;
}

table#revise tr th {
    border: 1px solid #cccccc;
    padding: 4px;
    text-align: right;
}

table#revise tr th.more {
    border: 1px solid #cccccc;
    border-bottom: solid 1px #000099;
    background: #ccccff;
    padding: 4px;
    text-align: center;
}

table#revise tr td {
    border: 1px solid #cccccc;
    padding: 4px;
}

table#revise tr td input {
    width: 500px;
}

table#revise tr td select {
    width: 200px;
}

table#revise tr td textarea {
    width: 500px;
}

table#revise tr td input.submit {
    width: 200px;
}

