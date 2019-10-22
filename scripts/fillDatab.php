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

$uzivatele_insert = "INSERT INTO uzivatele (Uzivatele_ID, jmeno, prijmeni, heslo, role, email) VALUES
(2, 'Eleanora', 'Palkova', '', 2, 'palkova@seznam.cz'),
(3, 'Andrej', 'Maly', '', 3, 'maly.andrej@seznam.cz'),
(4, 'Iveta', 'Stara', '', 4, 'stara@gmail.com'),
(5, 'Katerina', 'Humpolcova', '', 5, 'humpolcova@gmail.com'),
(6, 'Anna', 'Novotna', '', 5, 'novotna.anna@centrum.cz'),
(7, 'Adam', 'Hajek', '', 4, 'hajek@email.cz'),
(8, 'Lucie', 'Otahalova', '', 4, 'lucie.otahalova@post.cz'),
(9, 'Zaneta', 'Formankova', '', 3, 'formankova@email.cz'),
(10, 'Zuzana', 'Stivinova', '', 5, 'stivinova@seznam.cz');";
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

?>
