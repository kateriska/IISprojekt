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
(2, "Eleanora", "P�lkov�", "$2y$09$g0mOz171ScW7LrxuW7tHc.DPZJ.Dsb/ri/fZNoOn.ylymsJ0ihpzG", 2, "palkova@seznam.cz"),
(3, "Andrej", "Mal�", "$2y$09$v80chHDC5wNPrx7DqOrP3.koBH1M751z6g2zF6i1meoaJPsKN4/M6", 3, "maly.andrej@seznam.cz"),
(4, "Iveta", "Star�", "$2y$09$cUgTuud1ktdQLpX3aCq8Kub8tGGINopODIjyNPIuLkZw1anfCn4Jq", 2, "stara@gmail.com"),
(5, "Katar�na", "Humpolcov�", "$2y$09$pLrhckRmzoJEDj7q87EDJ.iNL90ddyxY.bMBkx6wh8XEfnSQiyseK", 1, "humpolcova@gmail.com"),
(6, "Anna", "Novotn�", "$2y$09$51v56vv5V5taUxoRR276suOFY1lwbT1yG2Ye01i9xe/7xSApBcsyi", 1, "novotna.anna@centrum.cz"),
(7, "Adam", "H�jek", "$2y$09$pyyWLIMoqMlaHeUVcbg6pu9kYginRst0kU4lCPX/zEytVtL/lS2Ci", 1, "hajek@email.cz"),
(8, "Lucie", "Ot�halov�", "$2y$09$ht2QP4ilxoBNrzkvdgDF9O.iI6Gx9x2Po4GJWojWlVKATm6uS33T2", 4, "lucie.otahalova@post.cz"),
(9, "Zita", "Form�nkov�", "$2y$09$FnXWZDMfwjOmpv26WlApHeJRnzi8jmk7/tNgOGBbK8kw3bErXTqS2", 3, "formankova@email.cz"),
(10, "Zuzana", "Stiv�nov�", "$2y$09$5Z6u4IQ1flPP1fXMoRs5NuPdsx2HOOaMN2R6w7j3VRdnK/SqXQida", 2, "stivinova@seznam.cz"),
(11, "Alena", "Jahodov�", "$2y$09$cvwm2Y8KiOZj7TX4k8H69eP1MhQpIn4Y017HdnlV4uQfmhAyBHSEG", 1, "student"), -- heslo: student
(12, "Petr", "Hrub�", "$2y$09$ZAgr62guPScYvDMmGR1cZOMAH4/sGGs5LzVklQj5gmbba9wR7EeP.", 2, "lektor"), -- heslo: lektor
(13, "Marta", "Jansk�", "$2y$09$7y6oCWp1JdOPln6qq54AUevkc4qZjj3tHy03WCtsct6/j9aLqLF9y", 3, "garant"), -- heslo: garant
(14, "Miroslav", "Kocour", "$2y$09$nDtAvLGGJHQtKQamTRUVDuG.SqdGsiwtxGI6lrlFaE4V2odraPSgS", 4, "vedouci") -- heslo: vedouci
;';
//HESLA: vždy 1. písmeno jména a 3 písmena příjmení (epal, amal,...)
controlProcedures($db, $uzivatele_insert, $link, "insert into uzivatele");

$kurzy_insert = "INSERT INTO kurzy (Kurzy_ID, nazev, popis, typ, cena, garant_ID, vedouci_ID) VALUES
('CADZ', 'Z�klady programu CAD', 'Seznamuje se z�klady modelov�n� pomoc� CAD technologi�.', 'Stroj�renstv�', 2900, 3, 8),
('ZPR', 'Z�klady programov�n�', 'Seznamuje se z�klady programov�n� a algoritmizace.', 'Programov�n�', 3500, 13 , 14),
('ZOPP', 'Z�klady OOP', 'Seznamuje se z�klady objektov� orientovan�ch jazyk�.', 'Programov�n�', 4000, 13 , 14),
('CTZ', 'Citace a psan� odborn�ho textu', 'Seznamuje se spr�vn�m citov�n�m a form�ln�mi nutnostmi pro psan� odborn�ho textu. Vhodn� zejm�na pro studenty, co budou ps�t diplomku.', 'Typografie', 1500, 9 , 14),
('IMD', '�vod do medic�nsk�ch datab�z�', 'Seznamuje se z�kladem tvorby datab�z� v oblasti medic�ny, vhodn� pro studenty informatiky nebo bionformatiky.', 'Medicinsk� informatika', 5900, 3, 8),
('VID', 'Z�klady tvorby video-obsahu', 'Vhodn� pro z�jemce o tvorbu vide�, kr�tk�ho filmu atd.', 'Multim�dia', 5000, 9, 8);";
controlProcedures($db, $kurzy_insert, $link, "insert into kurzy");

$mistnosti_insert = "INSERT INTO mistnosti (Mistnosti_ID, adresa, typ, kapacita) VALUES
('F202', 'M�nesova 220/3, Brno', 'poslucharna', 100),
('F208', 'M�nesova 220/3, Brno', 'poslucharna', 120),
('G505', 'M�nesova 220/3, Brno', 'laborator', 30),
('G507', 'M�nesova 220/3, Brno', 'laborator', 30),
('I007', 'Sk�celova 183/6, Brno', 'laborator', 20),
('H009', 'Sk�celova 183/6, Brno', 'poslucharna', 120);";
controlProcedures($db, $mistnosti_insert, $link, "insert into mistnosti");

$terminy_insert = "INSERT INTO terminy (Kurzy_ID, datum, cas, mistnost_ID, lektor_ID, popis, typ_termin, kapacita, doba_trvani, schvaleno) VALUES
('CADZ', '2019-10-18', '12:30:00.000000', 'F202', 4, 'Kon�n� �vodn� hodiny. Vizte web str�nky www.kurzy/cadz.pdf s materi�lem o teoretick�ch z�kladech.', 'prednaska', 60, 120, 'ne'),
('CADZ', '2019-11-30', '15:00:00.000000', '', 8, 'Dom�c� �kol. Vizte oporu na odkazu: www.cad.cz/sablona.pdf. �kol bude opravov�n uveden�m lektorem.', 'domaci ukol', 50, 0,'ne'),
('ZOPP', '2019-12-01', '15:00:00.000000', 'G507', 4, 'Pros�m, zopakujte si/nastudujte z�klady jazyka PHP a Python.', 'cviceni', 15, 120,'ne'),
('IMD', '2019-11-28', '15:00:00.000000', 'G505', 4, 'Budete sezn�meni s �vodn�mi pravidly a informacemi. Pros�m, noste si propisku, pap�r a tak� notebook.', 'cviceni', 20, 120,'ne'),
('ZPR', '2019-12-16', '13:00:00.000000', 'H009', 12, 'Probereme si praktick� �koly k prvn�mu prob�ran�mu t�matu.', 'cviceni', 20, 120,'ne'),
('CTZ', '2019-12-10', '18:00:00.000000', 'F208', 12, '�vodn� hodina. Popov�d�me si zejm�na o norm�ch ISO.', 'prednaska', 120, 120,'ne'),
('CTZ', '2019-12-18', '20:00:00.000000', '', 12, 'Bodovan� �kol, vizte na studium https://www.knihovnazn.cz/files/citace.pdf', 'domaci ukol', 120, '','ne'),
('VID', '2019-10-28', '11:00:00.000000', 'H009', 8, 'Problematika a demonstrace modelov�ho �kolu a programu.', 'prednaska', 90, 60,'ne');";
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
('CTZ', 'Citace a psan� odborn�ho textu', 'Seznamuje se spr�vn�m citov�n�m. Vhodn� pro studenty na vysok�.', 'Typografie', 2000, 9, 14, 9),
('CADZ', 'Z�klady programu CAD', 'Seznamuje se z�klady modelov�n� pomoc� CAD technologi�. Vhodn� pro z�jemce z fakult strojn�ch.', 'Stroj�renstv�', 3500, 3, 8, 3);";
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
