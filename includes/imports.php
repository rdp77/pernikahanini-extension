<?php
// Prevent direct access
if (!defined('ABSPATH')) {
  exit;
}

use PhpOffice\PhpSpreadsheet\IOFactory;

class Imports
{
  public function import_csv(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'pernikahanini';
    
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['csv_file']['tmp_name'];
        if (($handle = fopen($file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $name = sanitize_text_field($data[0]);
                $slug = Helpers::slugify(sanitize_text_field($data[1]));

                $wpdb->insert(
                    $table_name,
                    array(
                        'name' => $name,
                        'slug' => $slug,
                    ),
                    array(
                        '%s',
                        '%s',
                    )
                );
            }
            fclose($handle);
        }
    }
  }

  public function import_excel(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_table';
    
    if (isset($_FILES['excel_file']) && $_FILES['excel_file']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['excel_file']['tmp_name'];
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        
        foreach ($sheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE);
            $data = [];
            foreach ($cellIterator as $cell) {
                $data[] = $cell->getValue();
            }
            $name = sanitize_text_field($data[0]);
            $slug = Helpers::slugify(sanitize_text_field($data[1]));
            
            $wpdb->insert(
                $table_name,
                array(
                    'name' => $name,
                    'slug' => $slug,
                ),
                array(
                    '%s',
                    '%s',
                )
            );
        }
    }
  }
}