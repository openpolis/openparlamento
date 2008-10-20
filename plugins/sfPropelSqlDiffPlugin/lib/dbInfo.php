<?php

class dbInfo {
  public $tables;
  public $debug = true;

  function loadFromDb() {
    $con = Propel::getConnection();

    $rs = $con->executeQuery("SHOW TABLES LIKE '%'");
    $rs->setFetchmode(ResultSet::FETCHMODE_NUM);
    if($rs->getRecordCount() ==0) return false;
    while($rs->next()) {
      $name = $rs->getString(1);
      $this->tables[$name] = array();
    };

    foreach($this->tables as $table => $null) {
      $rs = $con->executeQuery("show create table `".$table."`");
      $rs->next();
      $create_table = $rs->getString("create table");
      $this->getTableInfoFromCreate($create_table);
    }

    return true;
  }

  public function loadFromFile($filename) {
    $dump = file_get_contents($filename);
    preg_match_all('/create table ([^\'";]+|\'[^\']*\'|"[^"]*")+;/i', $dump, $matches);
    foreach($matches[0] as $key=>$value) {
      $this->getTableInfoFromCreate($value);
    }
  }

  public function loadAllFilesInDir($dir) {
    $finder = sfFinder::type('file')->name('/schema.sql$/')->follow_link();
    $files = $finder->in($dir);
    foreach($files as $file) $this->loadFromFile($file);
  }

  public function getTableInfoFromCreate($create_table) {
    preg_match("/^\s*create table `?([^\s`]+)`?\s+\((.*)\)[^\)]*$/mis", $create_table, $matches);
    $table = $matches[1];
    $code = $matches[2];

    $this->tables[$table]['create'] = $create_table;
    $this->tables[$table]['fields'] = array();
    $this->tables[$table]['keys'] = array();
    $this->tables[$table]['fkeys'] = array();

    preg_match_all('/\s*(([^,\'"\(]+|\'[^\']*\'|"[^"]*"|\(([^\(\)]|\([^\(\)]*\))*\))+)\s*(,|$)/', $code, $matches);
    foreach($matches[1] as $key=>$value) {
      $this->getInfoFromPart($table, trim($value));
    }


  }

  public function getInfoFromPart($table, $part) {
    //get fields codes
    if(preg_match("/^`(\w+)`\s+(.*)$/m", $part, $matches)) {
      $fieldname = $matches[1];
      $code = $matches[2];
      $this->tables[$table]['fields'][$fieldname]['code'] = $code;
      preg_match('/([^\s]+)\s*(NOT NULL)?\s*(default (\'([^\']*)\'|(\d+)))?\s*(NOT NULL)?/i', $code, $matches2);
      $type = strtoupper($matches2[1]);
      if($type=='TINYINT') $type = 'TINYINT(4)';
      if($type=='SMALLINT') $type = 'SMALLINT(6)';
      if($type=='INTEGER') $type = 'INT(11)';
      if($type=='LONGVARCHAR') $type = 'TEXT';
      if($type=='BIGINT') $type = 'BIGINT(20)';
      if($type=='BLOB') $type = 'TEXT';   //propel fix, blob is TEXT field with BINARY collation 
      $type = str_replace('VARBINARY', 'VARCHAR', $type);
      $this->tables[$table]['fields'][$fieldname] = array(
        'code'    => $code,
        'type'    => $type,
		    'null'    => ((!isset($matches2[2]) || $matches2[2] != "NOT NULL") && (!isset($matches2[7]) || $matches2[7] != "NOT NULL")),
		    'default' => !empty($matches2[5]) ? $matches2[5] : ( !empty($matches2[6]) ? $matches2[6] : ''), 
      );

    }

    //get key codes
    elseif(preg_match("/^(primary|unique|fulltext)?\s*(key|index)\s+(`(\w+)`\s*)?(.*?)$/mi", $part, $matches)) {
      $keyname = $matches[4];
      $this->tables[$table]['keys'][$keyname]['type'] = $matches[1];
      $this->tables[$table]['keys'][$keyname]['code'] = $matches[5];
      $this->tables[$table]['keys'][$keyname]['fields'] = preg_split('/,\s*/', substr($matches[5], 1, -1));
    }

    elseif(preg_match("/CONSTRAINT\s+\`(.+)\`\s+FOREIGN KEY\s+\(\`(.+)\`\)\s+REFERENCES \`(.+)\` \(\`(.+)\`\)/mi", $part, $matches)) {
      $name = $matches[1];
      $this->tables[$table]['fkeys'][$name] = array(
						'field' => $matches[2],
						'ref_table' => $matches[3],
						'ref_field' => $matches[4],
						'code' => $part,
      );
      if(preg_match('/ON DELETE (RESTRICT|CASCADE|SET NULL|NO ACTION)/i', $part, $matches)) {
        $this->tables[$table]['fkeys'][$name]['on_delete'] = strtoupper($matches[1]);
      } else {
        $this->tables[$table]['fkeys'][$name]['on_delete'] = 'RESTRICT';
      }
      if(preg_match('/ON UPDATE (RESTRICT|CASCADE|NO ACTION)/i', $part, $matches)) {
        $this->tables[$table]['fkeys'][$name]['on_update'] = strtoupper($matches[1]);
      } else {
        $this->tables[$table]['fkeys'][$name]['on_update'] = 'RESTRICT';
      }

    }


    else {
      throw new Exception("can't parse line '$part' in table $table");
    }



  }


  function getDiffWith(dbInfo $db_info2) {

    $diff_sql = '';

    foreach($db_info2->tables as $tablename=>$tabledata) {

      if(!isset($this->tables[$tablename])) {
        $diff_sql .= "\n".$db_info2->tables[$tablename]['create']."\n";
        continue;
      }

      foreach($tabledata['fields'] as $field=>$fielddata) {
        $mycode = $fielddata['code'];
        $othercode = @$this->tables[$tablename]['fields'][$field]['code'];
        if($mycode and !$othercode) {
          $diff_sql .= "ALTER TABLE `$tablename` ADD `$field` $mycode;\n";
        };
      };

      if($tabledata['keys']) foreach($tabledata['keys'] as $field=>$fielddata) {
        $mycode = $fielddata['code'];
        $otherdata = @$this->tables[$tablename]['keys'][$field];
        $othercode = @$otherdata['code'];
        if($mycode and !$othercode) {
          if($otherdata['type']=='PRIMARY') {
            $diff_sql .= "ALTER TABLE `$tablename` ADD PRIMARY KEY $mycode;\n";
          } else {
            $diff_sql .= "ALTER TABLE `$tablename` ADD {$fielddata['type']} INDEX `$field` $mycode;\n";
          }
        };
      };

      if($tabledata['fkeys']) foreach($tabledata['fkeys'] as $fkeyname=>$data) {
        $mycode = $data['code'];
        $otherfkname = $this->get_fk_name_by_field($tablename, $data['field']);
        $otherdata = @$this->tables[$tablename]['fkeys'][$otherfkname];
        if($data['ref_table']!=$otherdata['ref_table']
        or $data['ref_field']!=$otherdata['ref_field']
        or $data['on_delete']!=$otherdata['on_delete']
        or $data['on_update']!=$otherdata['on_update'] ) {
          $diff_sql .= "ALTER TABLE `$tablename` ADD {$mycode};\n";
        };
      };
    };
    
    foreach($this->tables as $tablename=>$tabledata) {

      if(!isset($db_info2->tables[$tablename])) {
        $diff_sql .= "DROP TABLE `$tablename`;\n";
        continue;
      }

      //drop, alter foreign key
      if($tabledata['fkeys']) foreach($tabledata['fkeys'] as $fkeyname=>$data) {
        $mycode = $data['code'];
        $otherfkname = $db_info2->get_fk_name_by_field($tablename, $data['field']);
        $othercode = @$db_info2->tables[$tablename]['fkeys'][$otherfkname]['code'];
        if($mycode and !$othercode) {
          $diff_sql .= "ALTER TABLE `$tablename` DROP FOREIGN KEY `$fkeyname`;\n";
        } else {
          $data2 = $db_info2->tables[$tablename]['fkeys'][$otherfkname];
          if ($data['ref_table'] != $data2['ref_table'] ||
          $data['ref_field'] != $data2['ref_field'] ||
          $data['on_delete'] != $data2['on_delete'] ||
          $data['on_update'] != $data2['on_update']) {
            if($this->debug) {
              $diff_sql .= "/* old definition: $mycode\n   new definition: $othercode */\n";
            }
            $diff_sql .= "ALTER TABLE `$tablename` DROP FOREIGN KEY `$fkeyname`;\n";
            $diff_sql .= "ALTER TABLE `$tablename` ADD {$othercode};\n";
          }
        };
      };

      //drop, alter index
      if($tabledata['keys']) foreach($tabledata['keys'] as $field=>$fielddata) {
        $otherdata = @$db_info2->tables[$tablename]['keys'][$field];
        $ind_name = @$otherdata['type']=='PRIMARY'?'PRIMARY KEY':"{$otherdata['type']} INDEX";
        if($fielddata['code'] and !$otherdata['code']) {
          if($fielddata['type']=='PRIMARY') {
            $diff_sql .= "ALTER TABLE `$tablename` DROP PRIMARY KEY;\n";
          } else {
            $diff_sql .= "ALTER TABLE `$tablename` DROP INDEX $field;\n";
          }
        } elseif($fielddata['fields'] != $otherdata['fields'] or $fielddata['type']!=$otherdata['type']) {
          if($this->debug) {
            $diff_sql .= "/* old definition: {$fielddata['code']}\n   new definition: {$otherdata['code']} */\n";
          }
          if($fielddata['type']=='PRIMARY') {
            $diff_sql .= "ALTER TABLE `$tablename` DROP PRIMARY KEY,";
          } else {
            $diff_sql .= "ALTER TABLE `$tablename` DROP INDEX $field,";
          }
          $diff_sql .= "        ADD $ind_name ".($field?"`$field`":"")." {$otherdata['code']};\n";
        };
      };

      //drop, alter field
      foreach($tabledata['fields'] as $field=>$fielddata) {
        $mycode = $fielddata['code'];
        $otherdata = @$db_info2->tables[$tablename]['fields'][$field];
        $othercode = @$otherdata['code'];
        if($mycode and !$othercode) {
          $diff_sql .= "ALTER TABLE `$tablename` DROP `$field`;\n";
        } elseif($fielddata['type'] != $otherdata['type']
        or $fielddata['type'] != $otherdata['type']
        or $fielddata['null'] != $otherdata['null']
        or $fielddata['default'] != $otherdata['default']   ) {
          if($this->debug) {
            $diff_sql .= "/* old definition: $mycode\n   new definition: $othercode */\n";
          }
          $diff_sql .= "ALTER TABLE `$tablename` CHANGE `$field` `$field` $othercode;\n";
        };
      };
    };

    return $diff_sql;
  }

  private function get_fk_name_by_field($tablename, $fieldname) {
    if($this->tables[$tablename]['fkeys']) {
      foreach($this->tables[$tablename]['fkeys'] as $fkeyname=>$data) {
        if($data['field'] == $fieldname) return $fkeyname;
      }
    };
    return null;
  }
  
  public function executeSql($sql) {
  	$queries = $this->explodeSql($sql);
  	foreach($queries as $query) {
  	  $this->executeQuery($query);
  	}
  }
  
  public function explodeSql($sql) {
    $result = array();
    preg_match_all('/([^\'";]+|\'[^\']*\'|"[^"]*")+;/i', $sql, $matches);
    foreach($matches[0] as $query) {
      $result[] = $query;
    }
    return $result;    
  }
  
  public function executeQuery($query) {
  	$con = Propel::getConnection();
  	$con->executeUpdate($query);
  }
  
  
};
?>