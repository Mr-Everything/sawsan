<?php

namespace PHPMVC\LIB;

class FileUpload
{

    private $name ;
    private $type;
    private $size ;
    private $error ;
    private $tmpPath ;
    private $fileExtension ;
    private $allowedExtension = [
        'pdf', 'docx'
    ];

    public function __construct(array $file)
    {
        $this->name     = $this->name($file['name']);
        $this->type     = $file['type'];
        $this->size     = $file['size'];
        $this->error    = $file['error'];
        $this->tmpPath  = $file['tmp_name'];
    }

    public function name($name){
        preg_match_all('/([a-z]{1,4})$/i', $name, $m);
        $this->fileExtension = $m[0][0];
        $salt = '$2y$10$YMJdyhiJK.NU7Y6qDFOfGO$';
        return substr(strtolower(base64_encode($name . $salt)), 0, 26);
    }

    private function isAllowedType(){
        return in_array(strtolower($this->fileExtension), $this->allowedExtension);
    }
    public function isSizeNotAcceptable(){
        preg_match_all('/(\d+)([MG])$/i', MAX_FILE_SIZE_ALLOWED, $m);
        $maxFileSizeToUpload = $m[1][0];
        $sizeUnit = $m[2][0];
        $currentFileSize = ($sizeUnit == 'M') ? ceil($this->size / (1024*1024)) : ceil($this->size / (1024*1024*1024)) ;
        return (int) $currentFileSize > (int) $maxFileSizeToUpload ;
    }
    private function isImage()
    {
        return preg_match('/image/i', $this->type);
    }
    public function getFileName()
    {
        return $this->name . '.' .$this->fileExtension ;
    }
    public function upload(){
        if ($this->error  != 0){
            exit('Error uploading the image!');
        }elseif (!$this->isAllowedType()){
            exit('Error Image Type isn\'t Allowed ');
        }elseif ($this->isSizeNotAcceptable()){
            exit('Size Doesn\'t Acceptable');
        }else {
            $storageFolder = $this->isImage() ? IMAGES_UPLOAD_PATH : DOCUMENTS_UPLOAD_PATH ;
            if (is_writable($storageFolder)){
                move_uploaded_file($this->tmpPath, $storageFolder. DS . $this->getFileName());
            }else{
                exit('No write permission Doesn\'t Acceptable');
            }
        }
        return $this ;
    }

}