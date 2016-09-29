<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 4/21/2016
 * Time: 1:12 PM
 */

$host_name = "db618070060.db.1and1.com";
$database = "db618070060";
$user_name = "dbo618070060";
$password = "Umcu@54!#";
//$webhome   = "/kunden/homepages/8/d617627196/htdocs";
//mail("9897210902@vtext.com", "", "Starting Parking DB Backup", "From: UMCU Lobby <walter@umculobby.com>");
$para = array(
    'db_host' => $host_name,    //mysql host
    'db_uname' => $user_name,     //user
    'db_password' => $password,  //pass
    'db_to_backup' => $database,    //database name
    'db_backup_path' => "backups/", //where to backup
    'db_exclude_tables' => array('VehicleInfo', 'VisitorsTEST') //tables to exclude
);
__backup_mysql_database($para);

function __backup_mysql_database($params)
{
    $mtables = array();
    $contents = "-- Database: `" . $params['db_to_backup'] . "` --\n";

    $mysqli = new mysqli($params['db_host'], $params['db_uname'], $params['db_password'], $params['db_to_backup']);
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    $results = $mysqli->query("SHOW TABLES");

    while ($row = $results->fetch_array()) {
        if (!in_array($row[0], $params['db_exclude_tables'])) {
            $mtables[] = $row[0];
        }
    }

    foreach ($mtables as $table) {
        $contents .= "-- Table `" . $table . "` --\n";

        $results = $mysqli->query("SHOW CREATE TABLE " . $table);
        while ($row = $results->fetch_array()) {
            $contents .= $row[1] . ";\n\n";
        }

        $results = $mysqli->query("SELECT * FROM " . $table);
        $row_count = $results->num_rows;
        $fields = $results->fetch_fields();
        $fields_count = count($fields);

        $insert_head = "INSERT INTO `" . $table . "` (";
        for ($i = 0; $i < $fields_count; $i++) {
            $insert_head .= "`" . $fields[$i]->name . "`";
            if ($i < $fields_count - 1) {
                $insert_head .= ', ';
            }
        }
        $insert_head .= ")";
        $insert_head .= " VALUES\n";

        if ($row_count > 0) {
            $r = 0;
            while ($row = $results->fetch_array()) {
                if (($r % 400) == 0) {
                    $contents .= $insert_head;
                }
                $contents .= "(";
                for ($i = 0; $i < $fields_count; $i++) {
                    $row_content = str_replace("\n", "\\n", $mysqli->real_escape_string($row[$i]));

                    switch ($fields[$i]->type) {
                        case 8:
                        case 3:
                            $contents .= $row_content;
                            break;
                        default:
                            $contents .= "'" . $row_content . "'";
                    }
                    if ($i < $fields_count - 1) {
                        $contents .= ', ';
                    }
                }
                if (($r + 1) == $row_count || ($r % 400) == 399) {
                    $contents .= ");\n\n";
                } else {
                    $contents .= "),\n";
                }
                $r++;
            }
        }
    }

    if (!is_dir($params['db_backup_path'])) {
        mkdir($params['db_backup_path'], 0777, true);
    }

    $backup_file_name = "ParkingBkup-" . date("d-m-Y--h-i-s") . ".sql";
    //echo $params['db_backup_path'] . $backup_file_name . "\n";
    $fp = fopen($params['db_backup_path'] . $backup_file_name, 'w+');
    if (($result = fwrite($fp, $contents))) {
        echo "Backup file created '--$backup_file_name' ($result)\n";
        $msg = "Parking Database Backup Complete\n";
        //$msg .= $backup_file_name;
        $emailTo = "9897210902@vtext.com";
        $emailFrom = "walter@umculobby.com";
        $headers = "From: UMCU Lobby <" . $emailFrom . ">\r\n";
        //mail($emailTo, "", $msg, $headers);
    } else {
        $msg = "Parking Database Backup Failed\n";
        //$msg .= $backup_file_name;
        $emailTo = "9897210902@vtext.com";
        $emailFrom = "walter@umculobby.com";
        $headers = "From: UMCU Lobby <" . $emailFrom . ">\r\n";
        mail($emailTo, "", $msg, $headers);
    }
    fclose($fp);
}