<?php
//require_once "../vendor/autoload.php";

class PDF extends TCPDF {

    public $Background;

    public function __construct($Background=null,$orientation = 'P', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = 'UTF-8', $diskcache = false, $pdfa = false)
    {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
        $this->Background = $Background;
    }


    //设置水印背景图片
    //设置水印背景后页眉将失效
    public function Header() {
        //get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        $this->Image($this->Background, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
    }


    /**
     * 生成pdf
     * @param $Content          页面内容（html）
     * @param $fileName         输出文件
     * @param array $Options    设置项
     * @param string $dest      输出类型-默认是I：在浏览器中打开，D：下载，F：在服务器生成pdf
     * @return bool
     * @author  lxy
     * @time    2019-03-13
     */
    public function CreatePDF($Content,$fileName,$Options=array(),$dest="I"){
        $this->SetCreator(PDF_CREATOR);
        $this->SetAuthor($Options['author']);
        $this->SetTitle($Options['title']);

        $this->SetSubject($Options['title']);
        $this->SetKeywords($Options['keywords']);

        if($Options['isHeader']){
            $Header = $Options['isHeader'];
            // 是否显示页眉
            $this->setPrintHeader(true);
            // 设置页眉显示的内容
            $this->SetHeaderData($Header["logo"], $Header["logoW"],$Header["title"],$Header["content"],$Header["textC"],$Header["lineC"]);
            // 设置页眉字体
            $this->setHeaderFont($Header["font"]);
            // 页眉距离顶部的距离
            $this->SetHeaderMargin($Header["margin"]);
        }


        if($Options['isFoot']){
            $Foot = $Options['isFoot'];
            // 是否显示页脚
            $this->setPrintFooter(true);
            // 设置页脚显示的内容
            $this->setFooterData($Foot["textC"],$Foot["lineC"]);
            // 设置页脚的字体
            $this->setFooterFont($Foot["font"]);
            // 设置页脚距离底部的距离
            $this->SetFooterMargin($Foot["margin"]);
        }

        // 设置默认等宽字体
        $this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        // 设置行高
        $this->setCellHeightRatio($Options["lineHeight"]);
        // 设置左、上、右的间距
        $this->SetMargins($Options["cellHeight"]["left"],$Options["cellHeight"]["top"],$Options["cellHeight"]["right"]);
        // 设置是否自动分页 距离底部多少距离时分页
        $this->SetAutoPageBreak(TRUE, '15');
        // 设置图像比例因子
        $this->setImageScale(PDF_IMAGE_SCALE_RATIO);
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once (dirname(__FILE__) . '/lang/eng.php');
            $this->setLanguageArray();
        }
        $this->setFontSubsetting(true);
        $this->AddPage();
        // 设置字体
        $this->SetFont('stsongstdlight', ' ', 12, '', true);
        $this->writeHTMLCell(0, 0, '', '', $Content, 0, 1, 0, true, '', true);
        ob_clean();

        $this->Output($fileName, $dest);
        if($dest == "F"){
            return file_exists($fileName);
        }
    }
}


