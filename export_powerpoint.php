<!DOCTYPE html>
<html>
    <style>
    h1 {
      display: flex;
      justify-content: center;
      align-items: center;
      height: inherit;
      padding: 20px;
    }
    </style>
    <?php
    include('header.php'); 
    ?>
    <h1>PowerPoint Downloaded...</h1>
    <form form style="text-align: center;">
        <input type="button" value="Go back!" onclick="history.back()">
    </form>
</html>

<?php

use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Slide;
use PhpOffice\PhpPresentation\Slide\Iterator;

require_once 'vendor/autoload.php';

//Option Variables
$quantity = ($_POST['quantity']);
$display = ($_POST['option']);

$objPHPPowerPoint = new PhpPresentation();

// Create slide
$currentSlide = $objPHPPowerPoint->getActiveSlide();

// Create a shape (drawing)
$shape = $currentSlide->createDrawingShape();
$shape->setName('PHPPowerPoint logo')
->setDescription('PHPPowerPoint logo')
->setPath('images\about_images\abcd_logo.png')
->setHeight(72)
->setOffsetX(20)
->setOffsetY(20);
$shape->getShadow()->setVisible(true)
->setDirection(90)
->setDistance(20);

// Create a shape (text)
$shape = $currentSlide->createRichTextShape()
->setHeight(300)
->setWidth(600)
->setOffsetX(170)
->setOffsetY(180);
$shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
$textRun = $shape->createTextRun('Thank You For Using ABCD Project!');
$textRun->getFont()->setBold(true)
->setSize(60)
->setColor( new Color( 'FFE06B20' ) );
$intdisplay = intval($display);
if ($intdisplay == 1) {
    $x_val_pic = 30;
    $y_val_pic = 200;
    $x_val_text = 350;
    $y_val_text = 200;
} 
else {
    $x_val_pic = 700;
    $y_val_pic = 200;
    $x_val_text = 20;
    $y_val_text = 200;
}

$mysqli = mysqli_connect('localhost', 'root', '', 'abcd_db');
$TableName = "dresses";

$strSQL = "SELECT * FROM $TableName";
$sql = mysqli_query($mysqli, $strSQL);

if (mysqli_error($mysqli)) {
    echo mysqli_error($mysqli);
} else {
    if($sql->num_rows > 0) {
        $delimiter = ",";
        $filename = "dress-data_" . date('Y-m-d') . ".csv";
        
        $f = fopen('php://memory', 'w');
        $fields = array('id', 'name', 'description', 'did_you_know', 'category', 'type', 'state_name', 'key_words', 'image_url', 'status', 'notes');
        
         $count = 0;

        //testing prints
        echo("Quantity: ". $quantity);
        echo(" | Option: ".$display);

         while($count != $quantity) {            
            $row = $sql->fetch_assoc();
            $lineData = array($row['name'],$row['description'],$row['did_you_know'],$row['category'],$row['type'],$row['state_name'],$row['key_words'],$row['image_url'],$row['status'],$row['notes']);
            $slide = $objPHPPowerPoint->createSlide();

            //testing prints
            echo("<br><br>");
            
            echo($lineData[0]. "<br>" . $lineData[1] ."<br>" . $lineData[2] ."<br>" . $lineData[3] ."<br>" . $lineData[4] ."<br>" . $lineData[5] ."<br>" . $lineData[6] . "<br>". $lineData[7]);
            
            //create picture 
            $shape = $slide->createDrawingShape();
            $shape->setName('PHPPowerPoint logo')
            ->setDescription('PHPPowerPoint logo')
            ->setPath('images/dress_images/'.$lineData[7])
            ->setHeight(300)
            ->setOffsetX($x_val_pic)
            ->setOffsetY($y_val_pic);
            $shape->getShadow()->setVisible(true)
            ->setDirection(90)
            ->setDistance(20);

            // Create a shape (name)
            $shape = $slide->createRichTextShape()
            ->setHeight(300)
            ->setWidth(600)
            ->setOffsetX(20)
            ->setOffsetY(0);
            $textRun = $shape->createTextRun($lineData[0]);
            $textRun->getFont()->setBold(True)
            ->setSize(20)
            ->setColor( new Color( 'black' ) );

            // Create a Shape (category)
            $shape = $slide->createRichTextShape()
            ->setHeight(300)
            ->setWidth(600)
            ->setOffsetX(20)
            ->setOffsetY(600);
            $textRun = $shape->createTextRun($lineData[3]);
            $textRun->getFont()->setBold(True)
            ->setSize(20)
            ->setColor( new Color( 'black' ) );

            // Create a shape (description)
            $shape = $slide->createRichTextShape()
            ->setHeight(300)
            ->setWidth(600)
            ->setOffsetX($x_val_text)
            ->setOffsetY($y_val_pic);
            $textRun = $shape->createTextRun($lineData[1]);
            $textRun->getFont()->setBold(false)
            ->setSize(20)
            ->setColor( new Color( 'FFE06B20' ) );
                    
            $count++;
        }
        $oWriterPPTX = IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
        $oWriterPPTX->save(getenv("HOMEDRIVE").getenv("HOMEPATH")."\Downloads" . "\sample.pptx");
    }
}
?>






