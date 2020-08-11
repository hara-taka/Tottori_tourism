<?php

const DSN = 'mysql:dbname=trip;host=localhost;charset=utf8';
const USERNAME = 'root';
const PASSWORD = 'root';
const OPTIONS = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

?>