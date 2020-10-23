<?php

// Каталог с документами, которые надо распознать
$docDir='../Компьютерра/Komputerra';  

// Служебный каталог, куда будут распаковываться изображения для последующего ORC
$extractDir='./extract';

// Каталог, куда будут положены txt-файлы с распознанным текстом
// данный каталог может совпадать с $docDir
$finishDir=$docDir;

// Наименование бинарника программы tesseract, можно с полным путем
$tesseractBin='tesseract';

// Наименование бинарника программы convert, можно с полным путем
$convertBin='convert';


include './lib/fileHelper.php';
include './lib/pdfHelper.php';


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
        $fileNames=$this->getFiles();
        
        // Рспознавание документов
        foreach($fileNames as $fileName)
        {
            echo 'Translate for '.$fileName."\n";
            
            $this->translate($fileName);
            
            echo 'Done'."\n";
        }
        
        echo 'All files translated.'."\n";
    }
    
    
    protected function translate($fileName)
    {
        global $extractDir;
        
        FileHelper::cleanDir($extractDir);
        $this->extractDoc($fileName);
        $this->ocrDocText($fileName);
        
        exit(0);
    }


    protected function extractDoc($fileName)
    {
        switch ( pathinfo( $fileName, PATHINFO_EXTENSION ) ) 
        {
            case 'pdf':
                $this->extractDocPdf($fileName);
                break;
            case 'fb2':
                $this->extractDocFb2($fileName);
                break;
            default:
                echo 'Incorrect file extention for '.$fileName;
                exit(1);
        }
    }
    

    // Разворачивание PDF-файла на отдельные файлы картинок
    protected function extractDocPdf($fileName)
    {
        global $extractDir, $convertBin;
    
        // $pagesCount=PdfHelper::getPagesCount($fileName);
        
        system('cd "'.$extractDir.'" ; '.$convertBin.' -density 196 "'.$fileName.'" -trim +repage -bordercolor white -border 10 page.png');
    }

    
    // Разворачивание из FB2-файла файлов иллюстраций
    protected function extractDocFb2($fileName)
    {
    
    }

    
    protected function ocrDocText($fileName)
    {

    }

    
    protected function getSupportFormats()
    {
        return array('pdf'); // array('pdf', 'fb2');
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
                echo 'Unavailable file extention. '.$fileName."\n";
                continue;
            }

            $result[]=realpath( $fileName );
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
