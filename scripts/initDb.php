<?php

  function controlProcedures($db, $command, $link)
  {
    if(mysqli_query($db, $command))
    {
        echo "Command created successfully.\n";
    }
    else
    {
        echo "ERROR: Could not able to execute $command. " . mysqli_error($link);
    }
    return;
  }

  $db = mysqli_init();
  $login = $argv[1];
  $password = $argv[2];
  if (!mysqli_real_connect($db, 'localhost', $login, $password, $login, 0, '/var/run/mysql/mysql.sock'))
  {
    die('cannot connect '.mysqli_connecterror());
  }
  $fk_check_start = "SET FOREIGN_KEY_CHECKS=0;";

  $drop_user = "DROP TABLE IF EXISTS `uzivatel`;";
  controlProcedures($db, $drop_user, $link);

  $drop_course = "DROP TABLE IF EXISTS `kurz`;";
  controlProcedures($db, $drop_course, $link);

  $drop_place = "DROP TABLE IF EXISTS `mistnost`;";
  controlProcedures($db, $drop_place, $link);

  $drop_term = "DROP TABLE IF EXISTS `termin`;";
  controlProcedures($db, $drop_term, $link);

  $fk_check_end = "SET FOREIGN_KEY_CHECKS = 1;";
  $user = "CREATE TABLE `uzivatel` (
  `Uzivatel_ID` int NOT NULL AUTO_INCREMENT,
  `jmeno` varchar(25) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `prijmeni` varchar(25) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `heslo` varchar(30) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `role` int NOT NULL,
  `email` varchar(25) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`Uzivatel_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;";
  controlProcedures($db, $user, $link);

  $course = "CREATE TABLE `kurz` (
  `Kurz_ID` varchar(10) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `nazev` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `popis` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `typ` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `cena` int NOT NULL,
  `garant_ID` int NOT NULL,
  PRIMARY KEY (`Kurz_ID`),
  CONSTRAINT `kurz_ibfk_1` FOREIGN KEY (`garant_ID`) REFERENCES `uzivatel` (`Uzivatel_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;";
  controlProcedures($db, $course, $link);

  $place = "CREATE TABLE `mistnost` (
  `Mistnost_ID` varchar(15) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `adresa` varchar(35) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `typ` varchar(25) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `kapacita` int NOT NULL,
  PRIMARY KEY (`Mistnost_ID`),
  KEY `kapacita` (`kapacita`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;";
  controlProcedures($db, $place, $link);

  $term = "CREATE TABLE `termin` (
  `Kurz_ID` varchar(15) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `datum` date NOT NULL,
  `cas` time(6) NOT NULL,
  `mistnost_ID` varchar(15) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `lektor_ID` int NOT NULL,
  `popis` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `typ` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `kapacita` int NOT NULL,
  `doba trvani` int NOT NULL,
  PRIMARY KEY (`Kurz_ID`,`datum`,`cas`,`mistnost_ID`),
  KEY `lektor_ID` (`lektor_ID`),
  KEY `mistnost_ID` (`mistnost_ID`),
  CONSTRAINT `termin_ibfk_1` FOREIGN KEY (`Kurz_ID`) REFERENCES `kurz` (`Kurz_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `termin_ibfk_2` FOREIGN KEY (`lektor_ID`) REFERENCES `uzivatel` (`Uzivatel_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;";
  controlProcedures($db, $term, $link);

?>
