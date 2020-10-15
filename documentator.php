<?php

// Каталог с документами, которые надо распознать
$docDir='../Компьютерра/Komputerra';  

// Служебный каталог, куда будут распаковываться изображения для последующего ORC
$extractDir='./extract';

// Каталог, куда будут положены txt-файлы с распознанным текстом
// данный каталог может совпадать с $docDir
$finishDir=$docDir;

// Наименование бинарника tesseract, можно с полным путем
$tesseractBin='tesseract';


$documentator=new Documentator();
$documentator->run();


class Documentator
{
    protected $version = '0.1';

    public function __construct()
    {

    }

    
    // Запуск процесса распознавания всех файлов
    public function run()
    {
        echo 'Documentator v.'.$this->version."\n";
        
        $this->createExtractDir();
        
        // Список полных путей к файлам распознаваемых документов
        $files=$this->getFiles();
        
        // Рспознавание документов
        foreach($files as $file)
        {
            echo 'Translate for '.$file."\n";
            
            $this->translate($file);
            
            echo 'Done'."\n";
        }
        
        echo 'All files translated.'."\n";
    }
    
    
    protected function translate()
    {
        global $extractDir;
        
    }

    
    protected function getSupportFormats()
    {
        return array('pdf', 'fb2');
    }


    protected function getFiles()
    {
        global $docDir;
        
        $result=array();
        
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($docDir)) as $fileName)
        {
            // Исключение имен "." и ".."
            if($fileName->isDir()) 
            {
                continue;
            }
            
            if( !in_array( pathinfo( $fileName, PATHINFO_EXTENSION ), $this->getSupportFormats() ) )
            {
                echo 'Unavailavle file extention. '.$fileName."\n";
                continue;
            }

            $result[]=$fileName;
        }
        
        return $result;
    }

    
    protected function createExtractDir()
    {
        global $extractDir;
        
        if (!file_exists($extractDir)) {
            mkdir($extractDir, 0777, true);
        }
    }
}

?>
