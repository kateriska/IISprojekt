<?php
//PROVIDES DB HANDLE $db
$db = mysqli_init();
$login = "xholub42";
$password = "n4etimbe";

if (!mysqli_real_connect($db, '127.0.0.1', $login, $password, $login, 0, '/var/run/mysql/mysql.sock')){
  die('cannot connect '.mysqli_connect_error());
}

function controlProcedures($db, $command, $link, $info){
  if(mysqli_query($db, $command)){
      echo "Command created successfully($info)\n\n";
  }else{
      echo "ERROR: command '$command' " . mysqli_error($db) . "\n\n";
  }
}
// DROP DATABASE:
$fk_check_beg = "SET FOREIGN_KEY_CHECKS=0;";
$drop_hodnoceni = "DROP TABLE IF EXISTS hodnoceni;";
controlProcedures($db, $drop_hodnoceni, $link, "drop hodnoceni");
$drop_ke_schvaleni_student = "DROP TABLE IF EXISTS ke_schvaleni_student;";
controlProcedures($db, $drop_ke_schvaleni_student, $link, "drop ke_schvaleni_student");
$drop_ke_schvaleni_kurz = "DROP TABLE IF EXISTS ke_schvaleni_kurz;";
controlProcedures($db, $drop_ke_schvaleni_kurz, $link, "drop ke_schvaleni_kurz");
$drop_soubory = "DROP TABLE IF EXISTS soubory;";
controlProcedures($db, $drop_soubory, $link, "drop soubory");
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

// CREATE TABLES:
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
Kurzy_ID varchar(15) COLLATE utf8mb4_unicode_520_ci NOT NULL,
nazev varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
popis text COLLATE utf8mb4_unicode_520_ci NOT NULL,
typ varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
cena int NOT NULL,
garant_ID int NOT NULL,
vedouci_ID int NOT NULL,
PRIMARY KEY (Kurzy_ID),
CONSTRAINT kurzy_fk_uzivatele
  FOREIGN KEY (garant_ID)
  REFERENCES uzivatele (Uzivatele_ID)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
CONSTRAINT kurzy_fk_uzivatele2
  FOREIGN KEY (vedouci_ID)
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
mistnost_ID varchar(15) COLLATE utf8mb4_unicode_520_ci,
lektor_ID int NOT NULL,
popis text COLLATE utf8mb4_unicode_520_ci,
typ_termin varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL,
kapacita int,
doba_trvani int,
schvaleno varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL,
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
  Kurzy_ID varchar(15) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  student_ID int NOT NULL,
  PRIMARY KEY (Kurzy_ID, student_ID),
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

$soubory_tb = "CREATE TABLE soubory (
  Kurzy_ID varchar(15) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  datum date,
  cas time(6),
  mistnost_ID varchar(15) COLLATE utf8mb4_unicode_520_ci,
  nazev varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  url varchar(80) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  restrikce varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (Kurzy_ID, datum, cas, mistnost_ID),
  CONSTRAINT soubory_fk_mistnosti
    FOREIGN KEY (Kurzy_ID, datum, cas, mistnost_ID)
    REFERENCES terminy (Kurzy_ID, datum, cas, mistnost_ID)
    ON DELETE CASCADE
    ON UPDATE CASCADE
  ) ENGINE=InnoDB";
  controlProcedures($db, $soubory_tb, $link, "create soubory");

$ke_schvaleni_kurz_tb = "CREATE TABLE ke_schvaleni_kurz (
  Kurzy_ID varchar(15) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  nazev varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  popis text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  typ varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  cena int NOT NULL,
  garant_ID int NOT NULL,
  vedouci_ID int NOT NULL,
  zadatel_ID int NOT NULL,
  PRIMARY KEY (Kurzy_ID),
  CONSTRAINT ke_schvaleni_kurz_fk_garant
    FOREIGN KEY (garant_ID)
    REFERENCES uzivatele (Uzivatele_ID)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT ke_schvaleni_kurz_fk_vedouci
    FOREIGN KEY (vedouci_ID)
    REFERENCES uzivatele (Uzivatele_ID)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT ke_schvaleni_kurz_fk_zadatel
    FOREIGN KEY (zadatel_ID)
    REFERENCES uzivatele (Uzivatele_ID)
    ON DELETE CASCADE
    ON UPDATE CASCADE
  ) ENGINE=InnoDB";
  controlProcedures($db, $ke_schvaleni_kurz_tb, $link, "create ke_schvaleni_kurz ");

$ke_schvaleni_student_tb = "CREATE TABLE ke_schvaleni_student (
  Kurzy_ID varchar(15) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  student_ID int NOT NULL,
  PRIMARY KEY (Kurzy_ID, student_ID),
  CONSTRAINT ke_schvaleni_student_fk_kurzy
    FOREIGN KEY (Kurzy_ID)
    REFERENCES kurzy (Kurzy_ID)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT ke_schvaleni_student_fk_uzivatele
    FOREIGN KEY (student_ID)
    REFERENCES uzivatele (Uzivatele_ID)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB";
controlProcedures($db, $ke_schvaleni_student_tb, $link, "create ke_schvaleni_student");

$hodnoceni_tb = "CREATE TABLE hodnoceni (
  Kurzy_ID varchar(15) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  datum date NOT NULL,
  cas time(6) NOT NULL,
  mistnost_ID varchar(15) COLLATE utf8mb4_unicode_520_ci,
  student_ID int NOT NULL,
  hodnoceni int NOT NULL,
  hodnotil_ID int NOT NULL,
  PRIMARY KEY (Kurzy_ID, datum, cas, mistnost_ID, student_ID),
  CONSTRAINT hodnoceni_fk_mistnosti
    FOREIGN KEY (Kurzy_ID, datum, cas, mistnost_ID)
    REFERENCES terminy (Kurzy_ID, datum, cas, mistnost_ID)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT hodnoceni_fk_uzivatele
    FOREIGN KEY (student_ID)
    REFERENCES uzivatele (Uzivatele_ID)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT hodnoceni_fk_uzivatele2
    FOREIGN KEY (hodnotil_ID)
    REFERENCES uzivatele (Uzivatele_ID)
    ON DELETE CASCADE
    ON UPDATE CASCADE
  ) ENGINE=InnoDB";
  controlProcedures($db, $hodnoceni_tb, $link, "create hodnoceni");





// fill admin data:
$admin_insert = 'INSERT INTO uzivatele (jmeno, prijmeni, heslo, role, email) VALUES ("Marek", "Prokop", "$2y$09$qFiksEt6EFcpk1B6seDjPOWQtg67epB3o9eoHX1hAfFOri5GmvMWS", 5, "admin");';
//email = admin, heslo = admin
controlProcedures($db, $admin_insert, $link, "insert admin");
?>
