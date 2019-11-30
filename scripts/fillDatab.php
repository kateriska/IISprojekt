<?php
require('inc.db_handl.php');
$link='';
function controlProcedures($db, $command, $link, $info)
{
  if(mysqli_query($db, $command))
  {
      echo "Command created successfully($info)\n\n<br>";
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
3 - garant
4 - vedouci
5 - admin
*/
// INSERT TO TABLES:
$uzivatele_insert = 'INSERT INTO uzivatele (Uzivatele_ID, jmeno, prijmeni, heslo, role, email) VALUES
(2, "Eleanora", "Pálková", "$2y$09$g0mOz171ScW7LrxuW7tHc.DPZJ.Dsb/ri/fZNoOn.ylymsJ0ihpzG", 2, "palkova@seznam.cz"),
(3, "Andrej", "Malý", "$2y$09$v80chHDC5wNPrx7DqOrP3.koBH1M751z6g2zF6i1meoaJPsKN4/M6", 3, "maly.andrej@seznam.cz"),
(4, "Iveta", "Stará", "$2y$09$cUgTuud1ktdQLpX3aCq8Kub8tGGINopODIjyNPIuLkZw1anfCn4Jq", 2, "stara@gmail.com"),
(5, "Katarína", "Humpolcová", "$2y$09$pLrhckRmzoJEDj7q87EDJ.iNL90ddyxY.bMBkx6wh8XEfnSQiyseK", 1, "humpolcova@gmail.com"),
(6, "Anna", "Novotná", "$2y$09$51v56vv5V5taUxoRR276suOFY1lwbT1yG2Ye01i9xe/7xSApBcsyi", 1, "novotna.anna@centrum.cz"),
(7, "Adam", "Hájek", "$2y$09$pyyWLIMoqMlaHeUVcbg6pu9kYginRst0kU4lCPX/zEytVtL/lS2Ci", 1, "hajek@email.cz"),
(8, "Lucie", "Otáhalová", "$2y$09$ht2QP4ilxoBNrzkvdgDF9O.iI6Gx9x2Po4GJWojWlVKATm6uS33T2", 4, "lucie.otahalova@post.cz"),
(9, "Zita", "Formánková", "$2y$09$FnXWZDMfwjOmpv26WlApHeJRnzi8jmk7/tNgOGBbK8kw3bErXTqS2", 3, "formankova@email.cz"),
(10, "Zuzana", "Stivínová", "$2y$09$5Z6u4IQ1flPP1fXMoRs5NuPdsx2HOOaMN2R6w7j3VRdnK/SqXQida", 2, "stivinova@seznam.cz"),
(11, "Alena", "Jahodová", "$2y$09$cvwm2Y8KiOZj7TX4k8H69eP1MhQpIn4Y017HdnlV4uQfmhAyBHSEG", 1, "student"), -- heslo: student
(12, "Petr", "Hrubý", "$2y$09$ZAgr62guPScYvDMmGR1cZOMAH4/sGGs5LzVklQj5gmbba9wR7EeP.", 2, "lektor"), -- heslo: lektor
(13, "Marta", "Janská", "$2y$09$7y6oCWp1JdOPln6qq54AUevkc4qZjj3tHy03WCtsct6/j9aLqLF9y", 3, "garant"), -- heslo: garant
(14, "Miroslav", "Kocour", "$2y$09$nDtAvLGGJHQtKQamTRUVDuG.SqdGsiwtxGI6lrlFaE4V2odraPSgS", 4, "vedouci") -- heslo: vedouci
;';
//HESLA: vÅ¾dy 1. pÃ­smeno jmÃ©na a 3 pÃ­smena pÅ™Ã­jmenÃ­ (epal, amal,...)
controlProcedures($db, $uzivatele_insert, $link, "insert into uzivatele");

$kurzy_insert = "INSERT INTO kurzy (Kurzy_ID, nazev, popis, typ, cena, garant_ID, vedouci_ID) VALUES
('CADZ', 'Základy programu CAD', 'Seznamuje se základy modelování pomocí CAD technologií.', 'Strojírenství', 2900, 3, 8),
('ZPR', 'Základy programování', 'Seznamuje se základy programování a algoritmizace.', 'Programování', 3500, 13 , 14),
('ZOPP', 'Základy OOP', 'Seznamuje se základy objektovì orientovaných jazykù.', 'Programování', 4000, 13 , 14),
('CTZ', 'Citace a psaní odborného textu', 'Seznamuje se správným citováním a formálními nutnostmi pro psaní odborného textu. Vhodné zejména pro studenty, co budou psát diplomku.', 'Typografie', 1500, 9 , 14),
('IMD', 'Úvod do medicínských databází', 'Seznamuje se základem tvorby databází v oblasti medicíny, vhodné pro studenty informatiky nebo bionformatiky.', 'Medicinská informatika', 5900, 3, 8),
('VID', 'Základy tvorby video-obsahu', 'Vhodné pro zájemce o tvorbu videí, krátkého filmu atd.', 'Multimédia', 5000, 9, 8);";
controlProcedures($db, $kurzy_insert, $link, "insert into kurzy");

$mistnosti_insert = "INSERT INTO mistnosti (Mistnosti_ID, adresa, typ, kapacita) VALUES
('F202', 'Mánesova 220/3, Brno', 'poslucharna', 100),
('F208', 'Mánesova 220/3, Brno', 'poslucharna', 120),
('G505', 'Mánesova 220/3, Brno', 'laborator', 30),
('G507', 'Mánesova 220/3, Brno', 'laborator', 30),
('I007', 'Skácelova 183/6, Brno', 'laborator', 20),
('H009', 'Skácelova 183/6, Brno', 'poslucharna', 120);";
controlProcedures($db, $mistnosti_insert, $link, "insert into mistnosti");

$terminy_insert = "INSERT INTO terminy (Kurzy_ID, datum, cas, mistnost_ID, lektor_ID, popis, typ_termin, kapacita, doba_trvani, schvaleno) VALUES
('CADZ', '2019-10-18', '12:30:00.000000', 'F202', 4, 'Konání úvodní hodiny. Vizte web stránky www.kurzy/cadz.pdf s materiálem o teoretických základech.', 'prednaska', 60, 120, 'ne'),
('CADZ', '2019-11-30', '15:00:00.000000', '', 8, 'Domácí úkol. Vizte oporu na odkazu: www.cad.cz/sablona.pdf. Úkol bude opravován uvedeným lektorem.', 'domaci ukol', 50, 0,'ne'),
('ZOPP', '2019-12-01', '15:00:00.000000', 'G507', 4, 'Prosím, zopakujte si/nastudujte základy jazyka PHP a Python.', 'cviceni', 15, 120,'ne'),
('IMD', '2019-11-28', '15:00:00.000000', 'G505', 4, 'Budete seznámeni s úvodními pravidly a informacemi. Prosím, noste si propisku, papír a také notebook.', 'cviceni', 20, 120,'ne'),
('ZPR', '2019-12-16', '13:00:00.000000', 'H009', 12, 'Probereme si praktické úkoly k prvnímu probíranému tématu.', 'cviceni', 20, 120,'ne'),
('CTZ', '2019-12-10', '18:00:00.000000', 'F208', 12, 'Úvodní hodina. Popovídáme si zejména o normách ISO.', 'prednaska', 120, 120,'ne'),
('CTZ', '2019-12-18', '20:00:00.000000', '', 12, 'Bodovaný úkol, vizte na studium https://www.knihovnazn.cz/files/citace.pdf', 'domaci ukol', 120, '','ne'),
('VID', '2019-10-28', '11:00:00.000000', 'H009', 8, 'Problematika a demonstrace modelového úkolu a programu.', 'prednaska', 90, 60,'ne');";
controlProcedures($db, $terminy_insert, $link, "insert into terminy");

$zapsane_kurzy_insert = "INSERT INTO zapsane_kurzy (Kurzy_ID, student_ID) VALUES
('VID',5),
('VID',7),
('CTZ',7),
('IMD',5),
('IMD',11),
('ZPR',11),
('CADZ',6),
('ZOPP',10),
('VID',4),
('CTZ',4),
('VID',6);";
controlProcedures($db, $zapsane_kurzy_insert, $link, "insert into zapsane_kurzy");

$ke_schvaleni_kurz_insert = "INSERT INTO ke_schvaleni_kurz (Kurzy_ID, nazev, popis, typ, cena, garant_ID, vedouci_ID, zadatel_ID) VALUES
('CTZ', 'Citace a psaní odborného textu', 'Seznamuje se správným citováním. Vhodné pro studenty na vysoké.', 'Typografie', 2000, 9, 14, 9),
('CADZ', 'Základy programu CAD', 'Seznamuje se základy modelování pomocí CAD technologií. Vhodné pro zájemce z fakult strojních.', 'Strojírenství', 3500, 3, 8, 3);";
controlProcedures($db, $ke_schvaleni_kurz_insert, $link, "insert into ke_schvaleni_kurz");

$ke_schvaleni_student_insert = "INSERT INTO ke_schvaleni_student (Kurzy_ID, student_ID) VALUES
('IMD',7),
('IMD',6);";
controlProcedures($db, $ke_schvaleni_student_insert, $link, "insert into ke_schvaleni_student");

$hodnoceni_insert = "INSERT INTO hodnoceni (Kurzy_ID, datum, cas, mistnost_ID, student_ID, hodnoceni, hodnotil_ID) VALUES
('CADZ', '2019-10-18', '12:30:00.000000', 'F202', 6, 20, 4),
('VID', '2019-10-28', '11:00:00.000000', 'H009', 6, 60, 8),
('CTZ', '2019-12-18', '20:00:00.000000', '', 4, 30, 12),
('CTZ', '2019-12-18', '20:00:00.000000', '', 7, 20, 12),
('CADZ', '2019-11-30', '15:00:00.000000', '', 6, 15, 8),
('IMD', '2019-11-28', '15:00:00.000000', 'G505', 11, 18, 4);";
controlProcedures($db, $hodnoceni_insert, $link, "insert into hodnoceni");
?>
