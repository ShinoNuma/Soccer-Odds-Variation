<?php
/**
 * @author Samy Younsi <samyyounsi@hotmail.fr>
 * Export a table in CSV
 */

class Export {
    public function __construct() {
        include 'config.php';
        if(empty($_GET['export'])){
            header("Location: ".$base_url);
            exit;
        }
        $championship = $_GET['export'];
        return $this->CSV($championship);
    }

    public function connect_mysql() {
        $config = new Config();
        $default = $config->default;
        $mysqli = new mysqli($default['host'], $default['login'], $default['password'], $default['database']);
        if ($mysqli->connect_error) {
          die("Connection failed: " . $mysqli->connect_error."\r\n");
        } 
        return $mysqli;
      }

    public function CSV($championship){
        $mysqli = $this->connect_mysql();
        // Create and open new csv file
        $csv  = $championship . "-" . date('d-m-Y-his') . '.csv';
        $file = fopen('csv/'.$csv, 'w');
        // Get the table
        if (!$mysqli_result = mysqli_query($mysqli, "SELECT * FROM odds_{$championship}")){
            die(printf("Error: %s\n", $mysqli->error));
        }
        // Get column names 
         while ($column = mysqli_fetch_field($mysqli_result)) {
            $column_names[] = $column->name;
        }
        // Write column names in csv file
        if (!fputcsv($file, $column_names)){
            die('Can\'t write column names in csv file'."\n");
        }
        // Get table rows
        while ($row = mysqli_fetch_row($mysqli_result)) {
            // Write table rows in csv files
            if (!fputcsv($file, $row)){
                die('Can\'t write rows in csv file'."\n");
            }
        }
        fclose($file);
        $mysqli->close();
        // Export the data and prompt a csv file for download
        header("Content-type: text/x-csv");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=".basename('csv/'.$csv));
        readfile('csv/'.$csv); 
    }
}
new Export();
?>