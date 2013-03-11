<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__).'/../../bootstrap/unit.php');
require_once($_test_dir.'/unit/sfContextMock.class.php');

$t = new lime_test(48, new lime_output_color());

$context = new sfContext();
$context->getUser()->setCulture('en_US');

$v = new sfDateValidator();
$v->initialize($context);

// ->execute()
$t->diag('->execute()');

$validDates = array(
  '2/21/2008',
  '02/01/1990',
  '12/31/2001',
  '2/29/2004'
);

$invalidDates = array(
  '2/21',
  '2/29/2005',
  '3/32/2001',
  '13/1/2001',
  '2007ghgre7-1-120',
  'foobar'
);

$validCompareDates = array(
  array('2/21/2008', '==', '2/21/2008'),
  array('2/21/2008', '>', '2/20/2007'),
  array('2/21/2008', '>=', '2/21/2008'),
  array('2/21/2008', '>=' , '2/20/2007'),
  array('2/21/2008', '<', '3/22/2009'),
  array('2/21/2008', '<=', '3/22/2009'),
  array('2/21/2008', '<=', '2/21/2008')
);

$invalidCompareDates = array(
  array('2/1/2008', '==', '2/2/2008'),
  array('2/1/2008', '>', '2/2/2008'),
  array('2/1/2008', '>', '2/1/2008'),
  array('2/1/2008', '>=', '2/2/2008'),
  array('2/1/2008', '<', '1/31/2008'),
  array('2/1/2008', '<', '2/1/2008'),
  array('2/1/2008', '<=', '1/31/2008')
);

$v->initialize($context);

foreach ($validDates as $value)
{
  $error = null;
  $t->ok($v->execute($value, $error), sprintf('->execute() returns true for a valid date "%s"', $value));
  $t->is($error, null, '->execute() doesn\'t change "$error" if it returns true');
}

foreach ($invalidDates as $value)
{
  $error = null;
  $t->ok(!$v->execute($value, $error), sprintf('->execute() returns false for an invalid date "%s"', $value));
  $t->isnt($error, null, '->execute() changes "$error" with a default message if it returns false');
}

// comparing
$t->diag('->execute() - comparing');
$v->getParameterHolder()->set('compare', 'date_2');

foreach ($validCompareDates as $value)
{
  $v->getParameterHolder()->set('operator', $value[1]);
  $context->getRequest()->setParameter('date_2', $value[2]);
  $error = null;
  $t->ok($v->execute($value[0], $error), sprintf('->execute() returns true for valid date "%s" when compared by "%s" to "%s"', $value[0], $value[1], $value[2]));
  $t->is($error, null, '->execute() doesn\'t change "$error" if it returns true');
}

foreach ($invalidCompareDates as $value)
{
  $v->getParameterHolder()->set('operator', $value[1]);
  $context->getRequest()->setParameter('date_2', $value[2]);
  $error = null;
  $t->ok(!$v->execute($value[0], $error), sprintf('->execute() returns false for invalid date "%s" when compared by "%s" to "%s"', $value[0], $value[1], $value[2]));
  $t->isnt($error, null, '->execute() changes "$error" with a default message if it returns false');
}
