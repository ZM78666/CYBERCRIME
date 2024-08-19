<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpreviews";
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "
CREATE TABLE IF NOT EXISTS `register_users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` TEXT NOT NULL,
    `name` TEXT NOT NULL,
    `email` TEXT NOT NULL,
    `password` TEXT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
$conn->query($sql);

$sql2 = "
CREATE TABLE IF NOT EXISTS `questions` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` TEXT NOT NULL,
    `question` TEXT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
$conn->query($sql2);

$sql3 = "
CREATE TABLE IF NOT EXISTS `answers` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` TEXT NOT NULL,
    `answer` TEXT NOT NULL,
    `questionid` TEXT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
$conn->query($sql3);



?>