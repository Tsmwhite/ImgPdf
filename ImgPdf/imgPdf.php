<?php
require_once "pdf.php";
class ImgPDF {

    /**
     * 生成图片pdf
     * 流程：
     * 1.将pdf转换图片（需要Imagick扩展）
     * 2.将图片通过 tcpdf 生成pdf
     * @param   $source   pdf文件
     * @param   $target   生成文件
     * @param int page  待导出的页面 -1为全部 0为第一页 1为第二页
     * @return  bool|string
     * @throws  ImagickException
     * @author  lxy
     * @time    2019-03-13
     */
    public function PdfToImg($source, $target, $page = -1)
    {

        if (!extension_loaded('imagick'))
            return '缺少imagick扩展';

        if (!file_exists($source))
            return '文件不存在或路径不正确';

        if (!is_readable($source))
            return '权限不足，无法读取该文件';

        $IMG = new Imagick();
        $IMG->setResolution(150, 150);
        $IMG->setCompressionQuality(100);

        if ($page == -1)
            $IMG->readImage($source);
        else
            $IMG->readImage($source . "[" . $page . "]");


        foreach ($IMG as $Key => $Var) {
            $Var->setImageBackgroundColor('white');
            $Var->setImageFormat('jpg');
            $filename = $target . $Key . '.jpg';

            if ($Var->writeImage($filename) == true) {
                //$img = imgToBase64($filename);
                $imgs[] = $filename;
            }
        }

        if (empty($imgs)) return false;

        @unlink($source);
        //返回转化图片数组，由于pdf可能多页，此处返回二维数组。
        return $this->pdf_pictrue($imgs, $target);
    }

    /**
     * 将生成的pdf图片贴到新的pdf上-
     * @return  bool
     * @param   array $imgs       图片文件[array]
     * @param   string $filename  生成pdf文件
     * @return  bool
     * @author  lxy
     * @time    2019-03-13
     */
    private function pdf_pictrue($imgs=array(), $filename="")
    {
        if (empty($imgs) || empty($filename)) return false;

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->setPrintHeader(false);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set JPEG quality
        $pdf->setJPEGQuality(75);

        $bMargin = $pdf->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $pdf->getAutoPageBreak();
        // disable auto-page-break
        $pdf->SetAutoPageBreak(false, 0);

        foreach ($imgs as $value) {
            $pdf->AddPage();
            $pdf->Image($value, 0, 0, 210, 0, 'jpg');
            @unlink($value);
        }

        $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $pdf->setPageMark();
        $pdf->Output($filename, 'F');
        return true;

    }
}