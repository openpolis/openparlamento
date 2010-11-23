#!/bin/sh

# invoca l'aggiornamento (completo) delle matrici di similarita
php batch/updateSimilaritaForVoti.php  C 16
php batch/updateSimilaritaForVoti.php  S 16
#php batch/updateSimilaritaForFirme.php C 16
#php batch/updateSimilaritaForFirme.php S 16
