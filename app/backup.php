<?php

function backup_tables($host, $user, $pass, $name, $nama_file, $tables = '*')
{

   // menghubungkan & memilih database
   $db = new mysqli($host, $user, $pass, $name);
   $content = '';

   // Mendapatkan semua Table dengan (*)
   if ($tables == '*') {
      $tables = array();
      $result = $db->query("SHOW TABLES");
      while ($row = $result->fetch_row()) {
         $tables[] = $row[0];
      }
   } else {
      $tables = is_array($tables) ? $tables : explode(',', $tables);
   }

   // Loop melalui Table
   foreach ($tables as $table) {
      $result         =   $db->query('SELECT * FROM ' . $table);
      $fields_amount  =   $result->field_count;
      $content        .=  "DROP TABLE $table;";
      $rows_num       =   $db->affected_rows;
      $res            =   $db->query('SHOW CREATE TABLE ' . $table);
      $TableMLine     =   $res->fetch_row();
      $content        =   (!isset($content) ?  '' : $content) . "\n\n" . $TableMLine[1] . ";\n\n";

      for ($i = 0, $st_counter = 0; $i < $fields_amount; $i++, $st_counter = 0) {
         while ($row = $result->fetch_row()) {
            if ($st_counter % 100 == 0 || $st_counter == 0) {
               $content .= "\nINSERT INTO " . $table . " VALUES";
            }
            $content .= "\n(";
            for ($j = 0; $j < $fields_amount; $j++) {
               $row[$j] = str_replace("\n", "\n", addslashes($row[$j]));
               if (isset($row[$j])) {
                  $content .= '"' . $row[$j] . '"';
               } else {
                  $content .= '""';
               }
               if ($j < ($fields_amount - 1)) {
                  $content .= ',';
               }
            }
            $content .= ")";

            if ((($st_counter + 1) % 100 == 0 && $st_counter != 0) || $st_counter + 1 == $rows_num) {
               $content .= ";";
            } else {
               $content .= ",";
            }
            $st_counter = $st_counter + 1;
         }
      }
      $content .= "\n\n\n";
   }

   $nama_file;
   $handle = fopen('./asset/backup/' . $nama_file, 'w+');
   fwrite($handle, $content);
   fclose($handle);
}

error_reporting(0);
$file = date("Ymd") . '_backup_database_' . time() . '.sql';

backup_tables($host, $user, $pass, $db, $file);
?>

<div class="container">
   <div class="row">
      <div class="col-md-6 col-12 mx-auto my-4">
         <div class="card border border-primary">
            <div class="card-body">
               <h1 class="display-1 text-center text-primary">
                  <i class="fas fa-download"></i>
               </h1>
               <p class="card-text text-center">
                  Database aplikasi telah berhasil dibackup. Klik tombol dibawah ini untuk mendownload file database
                  <a href="./asset/backup/<?= $file ?>" class="btn btn-lg btn-primary d-block mt-3">
                     Unduh File
                  </a>
               </p>
            </div>
         </div>
      </div>
   </div>
</div>