<?php

class PdfHelper
{

    public function __construct()
    {

    }


    // Удаление всех файлов и поддиректорий в указанном каталоге    
    public static function getPagesCount($pdf_filename) 
    {
        $f = fopen($pdf_filename, "r");
        while(!feof($f)) 
        {
            $line = fgets($f,255);
            if (preg_match('/\/Count [0-9]+/', $line, $matches))
            {
              preg_match('/[0-9]+/',$matches[0], $matches2);
              
              if ($count<$matches2[0])
              {
                  $count=$matches2[0]; 
              }
            } 
        }
        fclose($fp);
        
        // echo "Count: {$count}";
        
        return $count;
    }    
   
}   

?>
