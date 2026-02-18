<?php

/**
 * Class pdfMaker
 * @property pdfMaker $pdfMaker
 */
class pdfMaker
{
    public $class;
    public $content;
    public $target;
    public $id;

    public function __construct()
    {
//        error_reporting(1);
//        error_reporting(E_ALL | E_STRICT);
//        @ini_set('display_errors', 1);
//        @ini_set('display_errors', 'on');

        $this->target = isset($_GET['target']) ? $_GET['target'] : '';
        $this->id = isset($_GET['id']) ? $_GET['id'] : '';
        $noCash = isset($_GET['cash']) ? $_GET['cash'] : '';
        $cancelStatus = isset($_GET['cancelStatus']) ? $_GET['cancelStatus'] : '';
        $html = isset($_GET['html']) ? $_GET['html'] : false;
        $class = Load::controller($this->target);
        if (!is_object($class)) {
            $class = Load::library($this->target);
        }

        $this->content = $class->createPdfContent($this->id, $noCash, $cancelStatus);
        if($html == true){
            echo $this->content;
            exit();
        }
        $this->showPdf($this->content, $this->id);
    }

    public function showPdf($content, $RequestNumber)
    {

// Assuming $RequestNumber and $content are defined somewhere in your code
         $lang = isset($_GET['lang']) ? $_GET['lang'] : 'fa';

// Load the Mpdf class
        require_once './vendor/autoload.php';

// Create an instance of Mpdf
            $mpdf = new \Mpdf\Mpdf([
                'mode' => '', // Auto detect mode
                'format' => 'A3', // Set the page format to A3
                'default_font_size' => 0, // Use default font size
                'default_font' => 'yekanbakh', // Use default font
                'fontDir'      => array_merge(
                    (new Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'],
                    [__DIR__ . '/fonts',]
                ),
                'fontdata'    => array_merge(
                    (new Mpdf\Config\FontVariables())->getDefaults()['fontdata'],[
                        'IranianSans' => [
                            'R'     =>  'IranianSans.ttf',
                            'B'     =>  'IranianSans.ttf',
                            'I'     =>  'IranianSans.ttf',
                            'BI'     =>  'IranianSans.ttf',
                            'useOTL'     =>  0xFF1,
                            'useKashida'     => 75,
                        ],
                        'iranyekan' => [
                            'R'     =>  'iranyekanwebregular.ttf',
                            'B'     =>  'iranyekanwebregular.ttf',
                            'I'     =>  'iranyekanwebregular.ttf',
                            'BI'     =>  'iranyekanwebregular.ttf',
                            'useOTL'     =>  0xFF1,
                            'useKashida'     => 75,
                            'sip-ext' => 'dejavusanscondensed',
                            'smp-ext' => 'dejavusanscondensed',
                        ],
                        'yekanbakh' => [
                            'R'     =>  'BYekan+.ttf',
                            'B'     =>  'BYekan+.ttf',
                            'I'     =>  'BYekan+.ttf',
                            'BI'     =>  'BYekan+.ttf',
                            'useOTL'     =>  0xFF1,
                            'useKashida'     => 75,
                            'sip-ext' => 'dejavusanscondensed',
                            'smp-ext' => 'dejavusanscondensed',
                        ]
                    ]
                ),
            'margin_left' => 0, // Set left margin
            'margin_right' => 0, // Set right margin
            'margin_top' => 2, // Set top margin
            'margin_bottom' => 2, // Set bottom margin
            'margin_header' => 0,
            'margin_footer' => 0,
            'shrink_tables_to_fit' => 1,
                'autoLangToFont' => true,
                'setAutoBottomMargin' => 'stretch',
            'direction' => ( ((SOFTWARE_LANG == 'en' || $lang == 'en') && $this->target != 'parvazBookingLocal') ? 'ltr' : 'rtl'), // Set text direction (ltr or rtl)
            'title' => 'ایران تکنولوژی' // Set the document title
        ]);
         
// Generate the barcode
//        $barcode = sprintf('%03d-%04d-%03d-%03d', mt_rand(0, 999), mt_rand(0, 9999), mt_rand(0, 999), mt_rand(0, 999));
//        $mpdf->write2DBarcode($barcode, 'QRCODE,H', '', '', 40, 15, 1.0, null, 'N');

// Load the custom CSS file
        $stylesheet = file_get_contents(FRONT_CURRENT_ADMIN . '/assets/css/custom.css');
        $mpdf->WriteHTML($stylesheet, 1);

            $dir = (((SOFTWARE_LANG == 'en' || $lang == 'en') && $this->target == 'parvazBookingLocal') ? 'ltr' : 'rtl');
            $mpdf->SetDirectionality($dir);
// Add the main content to the PDF
        $mpdf->WriteHTML($content);

// Output the PDF as a file
        $mpdf->Output($RequestNumber . ".pdf", 'I');

        exit();
    }

}

?>