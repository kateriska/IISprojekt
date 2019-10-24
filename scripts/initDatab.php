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
$fk_check_beg = "SET FOREIGN_KEY_CHECKS=0;";
$drop_zapsane_kurzy = "DROP TABLE IF EXISTS zapsane_kurzy;";
controlProcedures($db, $drop_zapsane_kurzy, $link, "drop zapsane_kurzy");
$drop_mistnosti = "DROP TABLE IF EXISTS mistnosti;";
controlProcedures($db, $drop_mistnosti, $link, "drop mistnosti");
$drop_terminy = "DROP TABLE IF EXISTS terminy;";
controlProcedures($db, $drop_terminy, $link, "drop terminy");
$drop_kurzy = "DROP TABLE IF EXISTS kurzy;";
controlProcedures($db, $drop_kurzy, $link, "drop kurzy");
$drop_uzivatele = "DROP TABLE IF EXISTS uzivatele;";
controlProcedures($db, $drop_uzivatele, $link, "drop uzivatele");
$fk_check_end = "SET FOREIGN_KEY_CHECKS=1;";
$uzivatele_tb = "CREATE TABLE uzivatele (
Uzivatele_ID int NOT NULL AUTO_INCREMENT,
jmeno varchar(25) COLLATE utf8mb4_unicode_520_ci NOT NULL,
prijmeni varchar(25) COLLATE utf8mb4_unicode_520_ci NOT NULL,
heslo varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
role int NOT NULL,
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
PRIMARY KEY (Kurzy_ID),
CONSTRAINT kurzy_fk_uzivatele
  FOREIGN KEY (garant_ID)
  REFERENCES uzivatele (Uzivatele_ID)
  ON DELETE CASCADE
  ON UPDATE CASCADE
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
CONSTRAINT terminy_fk_kurzy
  FOREIGN KEY (Kurzy_ID)
  REFERENCES kurzy (Kurzy_ID)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
CONSTRAINT terminy_fk_uzivatele
  FOREIGN KEY (lektor_ID)
  REFERENCES uzivatele (Uzivatele_ID)
  ON DELETE CASCADE
  ON UPDATE CASCADE
) ENGINE=InnoDB";
controlProcedures($db, $terminy_tb, $link, "create terminy");

$zapsane_kurzy_tb = "CREATE TABLE zapsane_kurzy (
  Zapsane_kurzy_ID int NOT NULL AUTO_INCREMENT,
  Kurzy_ID varchar(15) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  student_ID int NOT NULL,
  PRIMARY KEY (Zapsane_kurzy_ID,Kurzy_ID, student_ID),
  CONSTRAINT zapsane_fk_kurzy
    FOREIGN KEY (Kurzy_ID)
    REFERENCES kurzy (Kurzy_ID)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT zapsane_fk_uzivatele
    FOREIGN KEY (student_ID)
    REFERENCES uzivatele (Uzivatele_ID)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB";
controlProcedures($db, $zapsane_kurzy_tb, $link, "create zapsane_kurzy");
/* do tabulky TERMINY cizi klice:
/* do tabulky KURZ cizi klic:
KEY `garant_ID` (`garant_ID`),
CONSTRAINT `kurz_ibfk_1` FOREIGN KEY (`garant_ID`) REFERENCES `uzivatel` (`Uzivatel_ID`) ON DELETE CASCADE ON UPDATE CASCADE*/
// fill admin data:
$admin_insert = "INSERT INTO uzivatele (jmeno, prijmeni, heslo, role, email) VALUES ('Marek', 'Prokop', '$2y$09$qFiksEt6EFcpk1B6seDjPOWQtg67epB3o9eoHX1hAfFOri5GmvMWS', 5, 'admin');";
//email = admin, heslo = admin
controlProcedures($db, $admin_insert, $link, "insert admin");
?>
