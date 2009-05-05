#!/bin/sh

# invoca la generazione degli XML con le posizioni dei parlamentari
php batch/generateMPsDistancesMatrix.php S V
php batch/transformCoordsToXML.php S V

php batch/generateMPsDistancesMatrix.php C V
php batch/transformCoordsToXML.php C V

php batch/generateMPsDistancesMatrix.php S F
php batch/transformCoordsToXML.php S F

php batch/generateMPsDistancesMatrix.php C F
php batch/transformCoordsToXML.php C F
