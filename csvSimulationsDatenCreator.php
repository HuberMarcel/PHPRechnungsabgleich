<?php

#Briefkennung;E-POSTBRIEF-Absender;Postfach;Empfänger-Adresse;Zeitpunkt;Ereignis;Kanal;Seitenzahl;Blattzahl;Druckoptionen;Versandprodukt;Länderkennung;Rechnungszahlung;Kostenstelle
?>
<?php

$newSimulationData_csv = fopen('newSimulationData.csv', 'w');
fputcsv($newSimulationData_csv, array("Briefkennung", "E-POSTBRIEF-Absender", "Postfach",
    "Empfänger-Adresse", "Zeitpunkt", "Ereignis", "Kanal", "Seitenzahl",
    "Blattzahl", "Druckoptionen", "Versandprodukt", "Länderkennung", "Rechnungszahlung", "Kostenstelle"));
fclose($newSimulationData_csv);
$keywordVersandpr = "Versandprodukt";
$keywordBlattzahl = "Blattzahl";
######## Das folgende ist für die Datenerstellung wichtig
$newSimulationData_csv = fopen('newSimulationData.csv', 'r');
$spaltenNamen = fgetcsv($newSimulationData_csv);
fclose($newSimulationData_csv);
$newSimulationData_csv = fopen('newSimulationData.csv', 'a');
#echo "Anzahl vorhandener Spalten: " . sizeof($spaltenNamen) . "\n";
for ($k = 0; $k < 20; ++$k) {
    $zeile = array();
    for ($j = 0; $j < sizeof($spaltenNamen); $j++) {
        if ($spaltenNamen[$j] == $keywordVersandpr) {
            $zeile[] = "Standard";
        } else if ($spaltenNamen[$j] == $keywordBlattzahl) {
            $zeile[] = rand(1, 10);
        } else {
            $zeile[] = $spaltenNamen[$j];
        }
    }
    fputcsv($newSimulationData_csv, $zeile);
}
flush($newSimulationData_csv);
fclose($newSimulationData_csv);
$newSimulationData_csv = fopen('newSimulationData.csv', 'a');
for ($k = 0; $k < 10; ++$k) {
    $zeile = array();
    for ($m = 0; $m < sizeof($spaltenNamen); ++$m) {
#        echo "\nAktuelle Spalte: " . $spaltenNamen[$m] . "\n\n";
        if ($spaltenNamen[$m] == $keywordVersandpr) {
            $zeile[] = "Kompakt";
        } else if ($spaltenNamen[$m] == $keywordBlattzahl) {
            $zeile[] = rand(1, 15);
        } else {
            $zeile[] = "$spaltenNamen[$m]";
        }
    }
    fputcsv($newSimulationData_csv, $zeile);
}
flush($newSimulationData_csv);
fclose($newSimulationData_csv);
$newSimulationData_csv = fopen('newSimulationData.csv', 'a');
for ($k = 0; $k < 5; ++$k) {
    $zeile = array();
    for ($j = 0; $j < sizeof($spaltenNamen); $j++) {
        if ($spaltenNamen[$j] == $keywordVersandpr) {
            $zeile[] = "Gross";
        } else if ($spaltenNamen[$j] == $keywordBlattzahl) {
            $zeile[] = rand(1, 25);
        } else {
            $zeile[] = $spaltenNamen[$j];
        }
    }
    fputcsv($newSimulationData_csv, $zeile);
}
flush($newSimulationData_csv);
fclose($newSimulationData_csv);
?>
