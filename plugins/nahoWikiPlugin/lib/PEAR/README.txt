Librairies statically extracted from PEAR and adapted to Symfony environment
- Autoloading compatibility
- PHP5 strict compatibility




Changes done :

- Removed all the "require_once" instructions, and files renamed so that Symfony Autoloader can find the classes
$ find -name "*.php" | xargs sed 's/require_once/\/\/ require_once/g' -i # Commenting out all "require_once" instructions
$ find -name "*.php" | sed 's/^\.\///' | while read f; do mv $f $(echo $f | sed 's/\//_/g'); done # Rename all Directory/File.php to Directory_File.php

- Assigning the return value of new by reference is deprecated
$ grep -RF "&new" ./* | sed 's/:.*$//' | xargs sed 's/&new /new /' -i # Replace all "&new" by "new"

- Add the "static" keyword to method Text_Diff::trimNewLines() (Text_Diff.php:174)

- Replaced is_a() with instanceof (Text_Diff_Renderer.php:88)
