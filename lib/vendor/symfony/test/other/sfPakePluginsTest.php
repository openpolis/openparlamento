<?php

$_test_dir = realpath(dirname(__FILE__).'/..');
require_once($_test_dir.'/../lib/vendor/lime/lime.php');
require_once($_test_dir.'/../lib/vendor/pake/pakeFunction.php');
require_once($_test_dir.'/../lib/util/sfToolkit.class.php');
require_once($_test_dir.'/../data/tasks/sfPakePlugins.php');

$t = new lime_test(6, new lime_output_color());

$t->diag('_absolute_path_difference()');
$t->is(_absolute_path_difference('/a/b/c/d', '/a/b/d'), '../../d', '_absolute_path_difference() return a relative path to a "parent" directory');
$t->is(_absolute_path_difference('/a/b/c/d', '/a/b/c/d/e/f/g'), 'e/f/g', '_absolute_path_difference() return a relative path difference to a "descendant" directory');
$t->is(_absolute_path_difference('/a/b/c/d', '/a/b/c'), '..', '_absolute_path_difference() return a relative path difference to the "parent" directory');
$t->is(_absolute_path_difference('/a/b/c/d/', '/a/b/c/d'), '.', '_absolute_path_difference() return a relative path difference to "current" directory');
$t->is(_absolute_path_difference('../a/b', '/a/b/c'), '/a/b/c', '_absolute_path_difference() can\'t build difference between an absolute and relative path');
$t->is(_absolute_path_difference('/a/b/c', '../a/b/c'), '../a/b/c', '_absolute_path_difference() can\'t build difference between an absolute and relative path');

