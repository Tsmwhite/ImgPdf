<?php
require_once "vendor/autoload.php";
require_once "ImgPdf/imgPdf.php";

//设置背景水印
$pdf = new Pdf("./logo.png");
$html = file_get_contents("test.html");
$Options = array(
    "author"    => "theSmallWhiteMe",
    "title"     => "Simple is complex",
    "keywords"  => "go,go,go,php",
//            "isHeader"  => array(
//                "logo"    => "./logo.png",
//                "logoW"   => 36,
//                "title"   => "https://studygolang.com/articles/12907#hacker-news",
//                "content" => "go语言中文网",
//                "textC"   => [1, 32, 255],
//                "lineC"   => [0, 64, 128],
//                "font"    => [PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN],
//                "margin"  => 1
//
//            ),
    "isFoot"    => array(
        "textC" => [0, 64, 0],
        "lineC" => [0, 64, 128],
        "font"  => ['stsongstdlight', '', 10],
        "margin" => 5
    ),
    "lineHeight" => 2,
    "cellHeight" => [
        "right"  => 8,
        "top"    => 5,
        "left"   => 10
    ],

);

$res = $pdf->CreatePDF($html,"C:/htdocs/PDF/example.pdf",$Options,"F");
if($res===true){
    $IMG_PDF = new ImgPDF();
    $res = $IMG_PDF ->PdfToImg("C:/htdocs/PDF/example.pdf","C:/htdocs/PDF/exampleImg.pdf");
    print_r($res);
}