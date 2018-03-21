<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CSVReader {

    var $fields;/** columns names retrieved after parsing */
    var $separator = ';';/** separator used to explode each line */
    var $enclosure = '"';/** enclosure used to decorate each field */
    var $max_row_size = 4096;/** maximum row size to be used for decoding */

    function parse_file($p_Filepath) {

        $file = fopen($p_Filepath, 'r');
        $this->fields = fgetcsv($file, $this->max_row_size, $this->separator, $this->enclosure);
        $keys = str_getcsv($this->fields[0]);

        $i = 1;
        while (($row = fgetcsv($file, $this->max_row_size, $this->separator, $this->enclosure)) != false) {
            if ($row != null) { // skip empty lines
                $values = str_getcsv($row[0]);
                if (count($keys) == count($values)) {
                    $arr = array();
                    for ($j = 0; $j < count($keys); $j++) {
                        if ($keys[$j] != "") {
                            $arr[$keys[$j]] = $values[$j];
                        }
                    }

                    $content[$i] = $arr;
                    $i++;
                }
            }
        }
        fclose($file);
        return $content;
    }

    function csvToArray($file, $delimiter)
    {
        if (($handle = fopen($file, 'r')) !== FALSE) {
          $i = 0;
          while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) {
            for ($j = 0; $j < count($lineArray); $j++) {
              $arr[$i][$j] = $lineArray[$j];
            }
            $i++;
          }
          fclose($handle);
          }
        return $arr;
    }

    function csvToArrayBNI($file, $delimiter)
    {
        if (($handle = fopen($file, 'r')) !== FALSE) {
          $i = 0;
          while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) {
            for ($j = 0; $j < count($lineArray); $j++) {
              $arr[$i][$j] = $lineArray[$j];
            }
            $i++;
          }
          fclose($handle);
          }
        return $arr;
    }

    function csvToArrayBRI($file, $delimiter)
    {
      if (($handle = fopen($file, 'r')) !== FALSE) {
        $i = 0;
        while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) {
          $i++;
          for ($j = 0; $j < count($lineArray); $j++) {
            if (in_array('textbox102', $lineArray)) break;
            if (in_array('OPENING BALANCE', $lineArray)) break;
            if($i < 10) continue;
            $arr[$i][$j] = $lineArray[$j];
          }

        }
        fclose($handle);
        }
      return $arr;
    }


    function toArrayMandiri($file, $delimiter)
    {
        if (($handle = fopen($file, 'r')) !== FALSE) {
            $i = 0;
            while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) {
              for ($j = 0; $j < count($lineArray); $j++) {
                $arr[$i][$j] = $lineArray[$j];
              }
              $i++;
            }
            fclose($handle);
        }
        return $arr;
    }

}
?>
