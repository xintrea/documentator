<?php

// Каталог с документами, которые надо распознать
$docDir='../Компьютерра/Komputerra/2009';  

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

    
    public function run()
    {
        echo 'Documentator v.'.$this->version."\n";
        
        $this->createExtractDir();
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
