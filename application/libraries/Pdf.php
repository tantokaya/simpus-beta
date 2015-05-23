<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

// TCPDF configuration
require_once(dirname(__FILE__).'/tcpdf/tcpdf_autoconfig.php');
// TCPDF static font methods and data
require_once(dirname(__FILE__).'/tcpdf/include/tcpdf_font_data.php');
// TCPDF static font methods and data
require_once(dirname(__FILE__).'/tcpdf/include/tcpdf_fonts.php');
// TCPDF static color methods and data
require_once(dirname(__FILE__).'/tcpdf/include/tcpdf_colors.php');
// TCPDF static image methods and data
require_once(dirname(__FILE__).'/tcpdf/include/tcpdf_images.php');
// TCPDF static methods and data
require_once(dirname(__FILE__).'/tcpdf/include/tcpdf_static.php');


class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
}