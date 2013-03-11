<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__).'/../../bootstrap/unit.php');
require_once(sfConfig::get('sf_symfony_lib_dir').'/i18n/sfI18N.class.php');

$t = new lime_test(9, new lime_output_color());

$t->diag('i18n');
$i18n = sfI18n::getInstance();

$time =  mktime(10, 30, 0, 8, 1, 2008);

$t->is(sfI18N::getTimestampForCulture('01/08/2008 10:30', 'fr'), $time, '->getTimestampForCulture() returns the timestamp for a data formatted in the current culture');
$t->is(sfI18N::getTimestampForCulture('08/01/2008 10:30', 'en_US'), $time, '->getTimestampForCulture() returns the timestamp for a data formatted in the current culture');
$t->is(sfI18N::getTimestampForCulture('08/01/2008', 'en_US'), mktime(0, 0, 0, 8, 1, 2008), '->getTimestampForCulture() returns the timestamp for a data formatted in the current culture');
$t->is(sfI18N::getTimestampForCulture('', 'en_US'), mktime(0, 0, 0, 0, 0, 0), '->getTimestampForCulture() returns the timestamp for a data formatted in the current culture');
$t->is(sfI18N::getTimestampForCulture('not a date', 'en_US'), mktime(0, 0, 0, 0, 0, 0), '->getTimestampForCulture() returns the timestamp for a data formatted in the current culture');
$t->is(sfI18N::getTimestampForCulture('10:30', 'en_US'), mktime(10, 30, 0, 0, 0, 0), '->getTimestampForCulture() returns the timestamp for a data formatted in the current culture');

$t->is(sfI18N::getDateForCulture('01/08/2008 10:30', 'fr'), array(1, 8, 2008), '->getDateForCulture() returns the day, month and year for a data formatted in the current culture');
$t->is(sfI18N::getDateForCulture('08/01/2008 10:30', 'en_US'), array(1, 8, 2008), '->getDateForCulture() returns the day, month and year for a data formatted in the current culture');
$t->is(sfI18N::getDateForCulture('not a date', 'en_US'), null, '->getTimeForCulture() returns null in case of conversion problem');

