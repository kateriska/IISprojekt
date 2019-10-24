<?php
require_once('inc.db_handle.php');
function controlProcedures($db, $command, $link, $info)
{
  if(mysqli_query($db, $command))
  {
      echo "Command created successfully($info)\n\n";
  }
  else
  {
      echo "ERROR: command '$command' " . mysqli_error($db) . "\n\n";
  }
}

/*
role:
1 - student
2 - lektor
3 - vedouci
4 - garant
5 - admin
*/
$uzivatele_insert = 'INSERT INTO uzivatele (Uzivatele_ID, jmeno, prijmeni, heslo, role, email) VALUES
(2, "Eleanora", "Palkova", "$2y$09$g0mOz171ScW7LrxuW7tHc.DPZJ.Dsb/ri/fZNoOn.ylymsJ0ihpzG", 2, "palkova@seznam.cz"),
(3, "Andrej", "Maly", "$2y$09$v80chHDC5wNPrx7DqOrP3.koBH1M751z6g2zF6i1meoaJPsKN4/M6", 3, "maly.andrej@seznam.cz"),
(4, "Iveta", "Stara", "$2y$09$cUgTuud1ktdQLpX3aCq8Kub8tGGINopODIjyNPIuLkZw1anfCn4Jq", 2, "stara@gmail.com"),
(5, "Katerina", "Humpolcova", "$2y$09$pLrhckRmzoJEDj7q87EDJ.iNL90ddyxY.bMBkx6wh8XEfnSQiyseK", 1, "humpolcova@gmail.com"),
(6, "Anna", "Novotna", "$2y$09$51v56vv5V5taUxoRR276suOFY1lwbT1yG2Ye01i9xe/7xSApBcsyi", 1, "novotna.anna@centrum.cz"),
(7, "Adam", "Hajek", "$2y$09$pyyWLIMoqMlaHeUVcbg6pu9kYginRst0kU4lCPX/zEytVtL/lS2Ci", 1, "hajek@email.cz"),
(8, "Lucie", "Otahalova", "$2y$09$ht2QP4ilxoBNrzkvdgDF9O.iI6Gx9x2Po4GJWojWlVKATm6uS33T2", 4, "lucie.otahalova@post.cz"),
(9, "Zaneta", "Formankova", "$2y$09$FnXWZDMfwjOmpv26WlApHeJRnzi8jmk7/tNgOGBbK8kw3bErXTqS2", 3, "formankova@email.cz"),
(10, "Zuzana", "Stivinova", "$2y$09$5Z6u4IQ1flPP1fXMoRs5NuPdsx2HOOaMN2R6w7j3VRdnK/SqXQida", 2, "stivinova@seznam.cz");';
//HESLA: vždy 1. písmeno jména a 3 písmena příjmení (epal, amal,...)
controlProcedures($db, $uzivatele_insert, $link, "insert into uzivatele");

$kurzy_insert = "INSERT INTO kurzy (Kurzy_ID, nazev, popis, typ, cena, garant_ID) VALUES
('CADZ', 'Zaklady programu CAD', 'Seznamuje se zaklady modelovani pomoci CAD technologii.', 'Strojirenstvi', 2900, 9),
('IMD', 'Uvod do medicinskych databazi', 'Seznamuje se zakladem tvorby databazi v medicinskem prostredi, vhodne pro studenty informatiky nebo bionformatiky', 'Medicinska informatika', 5900, 3),
('VID', 'Zaklady tvorby video-obsahu', 'Vhodne pro zajemce o nataceni videi, kratkych filmu, strihani videa atd.', 'Multimedia', 5000, 3);";
controlProcedures($db, $kurzy_insert, $link, "insert into kurzy");

$mistnosti_insert = "INSERT INTO mistnosti (Mistnosti_ID, adresa, typ, kapacita) VALUES
('F202', 'Manesova 220/3, Brno', 'poslucharna', 100),
('G505', 'Manesova 220/3, Brno', 'laborator', 30),
('H009', 'Hutarova 183/6, Brno', 'poslucharna', 120);";
controlProcedures($db, $mistnosti_insert, $link, "insert into mistnosti");

$terminy_insert = "INSERT INTO terminy (Kurzy_ID, datum, cas, mistnost_ID, lektor_ID, popis, typ, kapacita, doba_trvani) VALUES
('CADZ', '2019-10-18', '12:30:00.000000', 'F202', 4, 'Konani seminare. Vizte web stranky www.kurzy/cadz.pdf s uvodnim materialem', 'prednaska', 60, 120),
('CADZ', '2019-11-30', '15:00:00.000000', '', 8, 'Domaci ukol k pouziti zakladnich prikazu. Vizte sablonu na odkaze: www.cad.cz/sablona.pdf. Ukol bude opravovan uvedenym lektorem.', 'domaci ukol', 50, 0),
('IMD', '2019-11-28', '15:00:00.000000', 'G505', 4, 'Cviceni v laboratori. Budete seznameni s laboratornim radem. Prosim, noste si psaci potreby a pripadne notebook.', 'cviceni', 20, 120),
('VID', '2019-10-28', '11:00:00.000000', 'H009', 8, 'Prednaska k problematice a demonstrace modeloveho prikladu a programu. Odkazy ke stazeni probirane latky budou doplneny.', 'prednaska', 90, 60);";
controlProcedures($db, $terminy_insert, $link, "insert into terminy");

$zapsane_kurzy_insert = "INSERT INTO zapsane_kurzy (Zapsane_kurzy_ID, Kurzy_ID, student_ID) VALUES
(1, 'VID',5),
(2, 'VID',7),
(2, 'IMD',5),
(2, 'CADZ',6),
(2, 'VID',6);";
controlProcedures($db, $zapsane_kurzy_insert, $link, "insert into zapsane_kurzy");

?>
