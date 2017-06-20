# Briefkennung;E-POSTBRIEF-Absender;Postfach;Empfänger-Adresse;Zeitpunkt;Ereignis;Kanal;Seitenzahl;Blattzahl;Druckoptionen;Versandprodukt;Länderkennung;Rechnungszahlung;Kostenstelle
# Oben sieht man die Struktur der zu öffnenen CSV-Datei
#
# Hinweis: https://www.epost.de/geschaeftskunden/preise.html
#          Standardbrief: inklusive 1 Blatt
#          Kompaktbrief:  inklusive 4 Blatt
#          Gross:         inklusive 10 Blatt 
<?php
echo "\n";
echo "!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!\n";
echo "HINWEIS: BITTE DAS SPALTENTRENNZEICHEN KONTROLLIEREN UND GGF. ANPASSEN!\n";
echo "!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!\n";
echo "\n";
$csv_datei = "newSimulationData.csv";
$spaltenTrennzeichen = ",";
$zeilenTrennzeichen = "\n";
$kontrollAbbruchszahl = -1;
/** Anzahl der zu untersuchenden Datensätze zur Kontrolle */
/** negative Zahl sorgt dafür, dass alle Daten durchlaufen werden */
$kontrollZeitInMilliSekunden = 0 * 2000;
$kontrollSpaltenBezeichnung = "Versandprodukt";
$kontrollSpaltenNummer = 1;
# wir zählen die Spalten 1-basiert
$readFile = fopen($csv_datei, 'r');
$spaltenNamen = fgetcsv($readFile);
foreach ($spaltenNamen as $spaltenName) {
    if (strpos($spaltenName, $kontrollSpaltenBezeichnung) === false) {
        ++$kontrollSpaltenNummer;
    } else {
        break;
    }
}
echo "KontrollspaltenNummer: " . $kontrollSpaltenNummer;
#usleep(3000000);
# kontrollSpaltenNummer enthält die Spalte (1 basiert gezählt) mit den zu suchenden Keywords
$counter = 0;
$kontrollString01 = "Standard";
$kontrollString02 = "Kompakt";
$arrayOfKontrollStrings["Standard"] = $counter;
$arrayOfKontrollStrings["Kompakt"] = $counter;
$arrayOfKontrollStrings["Gross"] = $counter;
$arrayOfLetterPages["Standard"] = $counter;
$arrayOfLetterPages["Kompakt"] = $counter;
$arrayofLetterPages["Gross"] = $counter;
$arrayOfLetterPagesZusatz["Standard"] = $counter;
$arrayOfLetterPagesZusatz["Kompakt"] = $counter;
$arrayOfLetterPagesZusatz["Gross"] = $counter;
$spalteFuerBlaetter = 9;
#    $arrayOfKontrollStrings = array("Standard" => array("Standard", $counter), 
#                                    "Kompakt"  => array("Kompakt", $counter)
#                                   );
/** echo $arrayOfKontrollStrings["Standard"]; */
/** echo $arrayOfKontrollStrings["Kompakt"];  */
/** usleep(6000000);  */
$kontrollString01Counter = 0;
$kontrollString02Counter = 0;

if (@file_exists($csv_datei) == false) {
    /**
     * Fehlermeldung: Datei nicht vorhanden */
    echo "\nDie CSV-Datei: " . $csv_datei . " ist nicht im aktuellen Verzeichnis - kontrollieren Sie ggf. den Namen!";
} else {
    echo "\nWir untersuchen die CSV-Datei:\n"
    . "    " . $csv_datei;
    $dateiInhalt = @file_get_contents($csv_datei);
    $zeilenInhalte = explode($zeilenTrennzeichen, $dateiInhalt);
    /**
     * die Zählung ist 0-basiert 
     */
    $anzahlZeilen = count($zeilenInhalte);
    echo "\nEs wurden in ihr\n" . "\n" .
    "    " . ($anzahlZeilen - 1) . " Zeilen\n" . "\n" .
    "erkannt!" . "\n";
    $zeilenNummer = 0;
    /** Wir werden die Zeilen 1-basiert bzgl. der Daten durchlaufen */
    /** Die erste Zeile enthält die Spalteninformationen und keine Daten,
      d.h. wir erhöhen den Zeilenzähler erst, wenn diese Zeile übersprungen wurde */
    if (is_array($zeilenInhalte) == true) {
        foreach ($zeilenInhalte as $zeile) {
            $spaltenNummer = 0;
            /** Wir werden die Spalten 1-basiert durchgehen */
            /** Ausgabe der Zeile des Datensatzes */
            echo "\nZeile Nr." . $zeilenNummer . " der CSV-Datei...";
            echo "\n" . $zeile . "\n\n";
            $spalten = explode($spaltenTrennzeichen, $zeile);
            if (is_array($spalten) == true) {
                foreach ($spalten as $spalte) {
                    ++$spaltenNummer;
                    if ($spaltenNummer == $spalteFuerBlaetter) {
                        # if (is_string($spalte)) {
                        #     $blattZahl = 0;
                        # } else {
                        $blattZahl = $spalte;
                        # }
                    }
                    if ($spaltenNummer == $kontrollSpaltenNummer) {
                        echo "Spalte Nr.: " . $spaltenNummer;
                        echo " - " . $spalte . "\n" . "\n";
                        echo ("Vergleich: " . (strpos($spalte, $kontrollString01)));
                        if (strpos($spalte, $kontrollString01) === false) {
                            echo "\n\nSpalteneintrag: " . $spalte . "\n\n";
                            /*                             * usleep(4000000); */
                        } else {
                            ++$kontrollString01Counter;
                        }
                        if (strpos($spalte, $kontrollString02) === false) {
                            echo "\n\nSpalteneintrag: " . $spalte . "\n\n";
                            /*                             * usleep(4000000); */
                        } else {
                            ++$kontrollString02Counter;
                        }
                        /** usleep($kontrollZeitInMilliSekunden*1000); */
                        /** jetzt kommt eigentlich der für später relevantere Code */
                        $theKeywordWasFound = false;
                        foreach ($arrayOfKontrollStrings as $keyword => $keywordCounter) {
                            echo "\nSpalte: " . $spalte . " -- zu suchendes Keyword: " . $keyword;
                            if (strpos($spalte, $keyword) === false) {
                                
                            } else {
                                $theKeywordWasFound = true;
                                $arrayOfKontrollStrings[$keyword] ++;
                                $arrayOfLetterPages[$keyword] += $blattZahl;
                                if (($keyword == "Standard") && $blattZahl > 1) {
                                    $arrayOfLetterPagesZusatz[$keyword] += $blattZahl - 1;
                                } else if (($keyword == "Kompakt") && $blattZahl > 4) {
                                    $arrayOfLetterPagesZusatz[$keyword] += $blattZahl - 4;
                                } else if (($keyword == "Gross") && $blattZahl > 10) {
                                    $arrayOfLetterPagesZusatz[$keyword] += $blattZahl - 10;
                                }
                            }
                            echo "\nKeyword: " . $keyword . " | Keyword-Counter: " . $arrayOfKontrollStrings[$keyword];
#                                   usleep(4000000);
                            /**
                              echo "\nKeyword: ".$keyword[0]."\n";
                              usleep(4000000);
                             */
                        }
                        if ($theKeywordWasFound === false && $zeilenNummer > 0) {
                            echo "\nNeues Keyword aufzunehmen?" . $spalte;
                            echo "In 4 Sekunden geht es weiter";
                            for ($k = 0; $k < 4; ++$k) {
                                usleep(1000000);
                                echo " .";
                            }
                            echo "\n";
                        }
                    }
                }
            }
            if ($zeilenNummer == $kontrollAbbruchszahl) {
                break;
            }
            ++$zeilenNummer; /* siehe oben: kontrollAbbruchszahl soll der letzte ausgegebene Datensatz sein */
        }
    }
    echo "\n" . $kontrollString01 . " kam " . $kontrollString01Counter . " mal vor!";
    echo "\n" . $kontrollString02 . " kam " . $kontrollString02Counter . " mal vor!";
    echo "\n";
    echo "\nTestausgabe:";
    foreach ($arrayOfKontrollStrings as $keyword => $keywordCounter) {
        echo "\nKeyword: " . $keyword . " | Keyword-Counter : " . $arrayOfKontrollStrings[$keyword];
        echo "\nKeyword: " . $keyword . " | Blattzahl       : " . $arrayOfLetterPages[$keyword];
        echo "\nKeyword: " . $keyword . " | Blattzahl-Zusatz: " . $arrayOfLetterPagesZusatz[$keyword];
        echo "\n";
    }
    echo "\n";
}
?>
