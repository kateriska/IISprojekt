<?php
//PROVIDES DB HANDLE $db
require_once('inc.db_handle.php');


function controlProcedures($db, $command, $link, $info){
  if(mysqli_query($db, $command)){
      echo "Command created successfully($info)\n\n";
  }else{
      echo "ERROR: command '$command' " . mysqli_error($db) . "\n\n";
  }
}

$drop_mistnosti = "DROP TABLE IF EXISTS mistnosti;";
controlProcedures($db, $drop_mistnosti, $link, "drop mistnosti");
$drop_terminy = "DROP TABLE IF EXISTS terminy;";
controlProcedures($db, $drop_terminy, $link, "drop terminy");
$drop_kurzy = "DROP TABLE IF EXISTS kurzy;";
controlProcedures($db, $drop_kurzy, $link, "drop kurzy");
$drop_uzivatele = "DROP TABLE IF EXISTS uzivatele;";
controlProcedures($db, $drop_uzivatele, $link, "drop uzivatele");


$uzivatele_tb = "CREATE TABLE uzivatele (
Uzivatele_ID int NOT NULL AUTO_INCREMENT,
jmeno varchar(25) COLLATE utf8mb4_unicode_520_ci NOT NULL,
prijmeni varchar(25) COLLATE utf8mb4_unicode_520_ci NOT NULL,
heslo varchar(30) COLLATE utf8mb4_unicode_520_ci NOT NULL,
`role` int NOT NULL,
email varchar(25) COLLATE utf8mb4_unicode_520_ci NOT NULL,
PRIMARY KEY (Uzivatele_ID)
) ENGINE=InnoDB";

controlProcedures($db, $uzivatele_tb, $link, "create uzivatele");

$kurzy_tb = "CREATE TABLE kurzy (
Kurzy_ID varchar(10) COLLATE utf8mb4_unicode_520_ci NOT NULL,
nazev varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
popis text COLLATE utf8mb4_unicode_520_ci NOT NULL,
typ varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
cena int NOT NULL,
garant_ID int NOT NULL,
PRIMARY KEY (Kurzy_ID)
) ENGINE=InnoDB";

controlProcedures($db, $kurzy_tb, $link, "create kurzy");

$mistnosti_tb = "CREATE TABLE mistnosti (
Mistnosti_ID varchar(15) COLLATE utf8mb4_unicode_520_ci NOT NULL,
adresa varchar(35) COLLATE utf8mb4_unicode_520_ci NOT NULL,
typ varchar(25) COLLATE utf8mb4_unicode_520_ci NOT NULL,
kapacita int NOT NULL,
PRIMARY KEY (Mistnosti_ID)
) ENGINE=InnoDB";
controlProcedures($db, $mistnosti_tb, $link, "create mistnosti");

$terminy_tb = "CREATE TABLE terminy (
Kurzy_ID varchar(15) COLLATE utf8mb4_unicode_520_ci NOT NULL,
datum date NOT NULL,
cas time(6) NOT NULL,
mistnost_ID varchar(15) COLLATE utf8mb4_unicode_520_ci NOT NULL,
lektor_ID int NOT NULL,
popis text COLLATE utf8mb4_unicode_520_ci NOT NULL,
typ varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL,
kapacita int NOT NULL,
doba_trvani int NOT NULL,
PRIMARY KEY (Kurzy_ID,datum,cas,mistnost_ID),

CONSTRAINT `termin_ibfk_1` 
  FOREIGN KEY (`Kurzy_ID`) 
  REFERENCES `kurzy` (`Kurzy_ID`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,

CONSTRAINT `termin_ibfk_2`
  FOREIGN KEY (`lektor_ID`)
  REFERENCES `uzivatele` (`Uzivatele_ID`)
  ON DELETE CASCADE
  ON UPDATE CASCADE
) ENGINE=InnoDB";

controlProcedures($db, $terminy_tb, $link, "create terminy");

/* do tabulky TERMINY cizi klice:
KEY `lektor_ID` (`lektor_ID`),
KEY `mistnost_ID` (`mistnost_ID`),
CONSTRAINT `termin_ibfk_1` FOREIGN KEY (`Kurzy_ID`) REFERENCES `kurzy` (`Kurzy_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT `termin_ibfk_2` FOREIGN KEY (`lektor_ID`) REFERENCES `uzivatele` (`Uzivatele_ID`) ON DELETE CASCADE ON UPDATE CASCADE*/

/* do tabulky KURZ cizi klic:
KEY `garant_ID` (`garant_ID`),
CONSTRAINT `kurz_ibfk_1` FOREIGN KEY (`garant_ID`) REFERENCES `uzivatel` (`Uzivatel_ID`) ON DELETE CASCADE ON UPDATE CASCADE*/

// fill admin data:
$admin_insert = "INSERT INTO uzivatele (Uzivatele_ID, jmeno, prijmeni, heslo, role, email) VALUES (1, 'Marek', 'Prokop', '', 5, 'marek.prokop@email.cz');";
controlProcedures($db, $admin_insert, $link, "insert admin");



?>
