<?php

class FileHelper
{

    public function __construct()
    {

    }


    // Удаление всех файлов и поддиректорий в указанном каталоге    
    public static function cleanDir($dir) 
    {
        $files = glob($dir."/*");
        $c = count($files);
        if (count($files) > 0) 
        {
            foreach ($files as $file) 
            {      
                if (file_exists($file)) 
                {
                    unlink($file);
                }   
            }
        }
    }    
    
}

?>
