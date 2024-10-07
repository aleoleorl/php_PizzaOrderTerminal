<?php
class ImageHandler 
{
    private $baseDir;

    public function __construct($baseDir) 
    {
        $this->baseDir = realpath($baseDir);
    }

    public function getImageUrl($imageName) 
    {
        $imagePath = realpath($this->baseDir . '/' . $imageName);

        if ($imagePath && file_exists($imagePath) && strpos($imagePath, $this->baseDir) === 0) 
        {
            return 'img/' . $imageName;
        } 
        else 
        {
            return null;
        }
    }
}
?>