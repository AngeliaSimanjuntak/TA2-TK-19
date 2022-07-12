<?php
require('config.php');


function get($table)
{
    $query = mysqli_query($GLOBALS['connection'], "SELECT * FROM $table");
    return $query;
}

function create($table, $data)
{
    $sql = "INSERT INTO $table VALUES (null, " . $data . ")";
    $query = mysqli_query($GLOBALS['connection'], $sql);
    return $query;
}

function find($table, $id)
{
    $query = mysqli_query($GLOBALS['connection'], "SELECT * FROM $table WHERE id = $id");
    return $query->fetch_assoc();
}

function first($table)
{
    $query = mysqli_query($GLOBALS['connection'], "SELECT * FROM $table ORDER BY id ASC LIMIT 1");
    return $query->fetch_assoc();
}

function update($table, $data, $id)
{
    $sql = "UPDATE $table SET $data WHERE id = $id";
    $query = mysqli_query($GLOBALS['connection'], $sql);
    return $query;
}
