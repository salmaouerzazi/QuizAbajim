<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Concours;
use App\Models\VideoConcour;
use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class ConcoursController extends Controller
{
      
    /**
    * Algo Insert an icon to plus.
     *
     * @return \Illuminate\Http\Response
     */
    public function getConcoursBookAndInsertIconPlus($id)
    {
   
        $documents = Concours::where('id',$id)->pluck('pdf_path_url');
        $concour = Concours::where('id',$id)->first();

        $page = request('page');
        $pdfFilePathLocal = public_path($documents[0]) ;
        $pdfFilePathServer = env('APP_ENV_URL').$documents[0];    //APP_ENV_URL1   Server
    
        if ($documents[0] == 'GG/concours/Math.pdf') { //CONCOURS MATH
            $icon1FilePath = public_path('pdf/imageinsert.png');

            $icon1X = 135;
            $icon1Y = 50;
            $icon1Width = 18;
            $icon1Height = 14;
            $icon2X = 135;
            $icon2Y = 124;
            $icon3X = 137;
            $icon3Y = 73;
            $icon4X = 137;
            $icon4Y = 56;
            $icon5X = 137;
            $icon5Y = 140;
            $icon6X = 127;
            $icon6Y = 28;
            $icon7X = 134;
            $icon7Y = 50;
            $icon8X = 134;
            $icon8Y = 158;
            $icon9X = 134;
            $icon9Y = 22;
            $icon10X = 132;
            $icon10Y = 67;
            $icon11X = 132;
            $icon11Y = 200;
            $icon12X = 132;
            $icon12Y = 28;
            $icon13X = 139;
            $icon13Y = 55;
            $icon14X = 139;
            $icon14Y = 147;
            $icon15X = 120;
            $icon15Y = 26;
            $icon16X = 131;
            $icon16Y = 55;
            $icon17X = 131;
            $icon17Y = 181;
            $icon18X = 131;
            $icon18Y = 75;
            $icon19X = 135;
            $icon19Y = 57;
            $icon20X = 135;
            $icon20Y = 166;
            $icon21X = 132;
            $icon21Y = 32;
            $icon22X = 137;
            $icon22Y = 63;
            $icon23X = 137;
            $icon23Y = 150;
            $icon24X = 135;
            $icon24Y = 26;
            $icon25X = 133;
            $icon25Y = 63;
            $icon26X = 133;
            $icon26Y = 150;
            $icon27X = 135;
            $icon27Y = 27;
            $icon28X = 143;
            $icon28Y = 70;
            $icon29X = 143;
            $icon29Y = 159;
            $icon30X = 148;
            $icon30Y = 24;
            $icon31X = 140;
            $icon31Y = 64;
            $icon32X = 140;
            $icon32Y = 173;
            $icon33X = 136;
            $icon33Y = 22;
            $icon34X = 132;
            $icon34Y = 52;
            $icon35X = 132;
            $icon35Y = 222;
            $icon36X = 132;
            $icon36Y = 59;
            $icon37X = 132;
            $icon37Y = 57;
            $icon38X = 132;
            $icon38Y = 179;
            $icon39X = 130;
            $icon39Y = 19;
            $icon40X = 140;
            $icon40Y = 56;
            $icon41X = 140;
            $icon41Y = 170;
            $icon42X = 142;
            $icon42Y = 18;
            $icon43X = 135;
            $icon43Y = 48;
            $icon44X = 135;
            $icon44Y = 173;
            $icon45X = 137;
            $icon45Y = 90;
             
            $linkUrlBase =  "https://www.abajim.com/panel/concours/teacher/".$id;
            $linkUrlBase1 = url('showvideo',);
            
            $iconUrlParam = '?icon=';
            $pageUrlParam = '&page=';

            $pdf = new Fpdi();
             // Import the pages of the original PDF and add the icons to each page
            $pageCount = $pdf->setSourceFile($pdfFilePathLocal);

              for ($pageNo = 1; $pageNo <= 2; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
              }
              for ($pageNo =3; $pageNo <= 3; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 1;
                  $pdf->Image($icon1FilePath, $icon1X, $icon1Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon1X, $icon1Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 2;
                  $pdf->Image($icon1FilePath, $icon2X, $icon2Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon2X, $icon2Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =4; $pageNo <= 4; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 3;
                  $pdf->Image($icon1FilePath, $icon3X, $icon3Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon3X, $icon3Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =5; $pageNo <= 5; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 4;
                  $pdf->Image($icon1FilePath, $icon4X, $icon4Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon4X, $icon4Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 5;
                  $pdf->Image($icon1FilePath, $icon5X, $icon5Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon5X, $icon5Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =6; $pageNo <= 6; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 6;
                  $pdf->Image($icon1FilePath, $icon6X, $icon6Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon6X, $icon6Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =7; $pageNo <= 7; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 7;
                  $pdf->Image($icon1FilePath, $icon7X, $icon7Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon7X, $icon7Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 8;
                  $pdf->Image($icon1FilePath, $icon8X, $icon8Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon8X, $icon8Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =8; $pageNo <= 8; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 9;
                  $pdf->Image($icon1FilePath, $icon9X, $icon9Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon9X, $icon9Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =9; $pageNo <= 9; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 10;
                  $pdf->Image($icon1FilePath, $icon10X, $icon10Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon10X, $icon10Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 11;
                  $pdf->Image($icon1FilePath, $icon11X, $icon11Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon11X, $icon11Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =10; $pageNo <= 10; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 12;
                  $pdf->Image($icon1FilePath, $icon12X, $icon12Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon12X, $icon12Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =11; $pageNo <= 11; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 13;
                  $pdf->Image($icon1FilePath, $icon13X, $icon13Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon13X, $icon13Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 14;
                  $pdf->Image($icon1FilePath, $icon14X, $icon14Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon14X, $icon14Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =12; $pageNo <= 12; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 15;
                  $pdf->Image($icon1FilePath, $icon15X, $icon15Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon15X, $icon15Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =13; $pageNo <= 13; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 16;
                  $pdf->Image($icon1FilePath, $icon16X, $icon16Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon16X, $icon16Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 17;
                  $pdf->Image($icon1FilePath, $icon17X, $icon17Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon17X, $icon17Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =14; $pageNo <= 14; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 18;
                  $pdf->Image($icon1FilePath, $icon18X, $icon18Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon18X, $icon18Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =15; $pageNo <= 15; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 19;
                  $pdf->Image($icon1FilePath, $icon19X, $icon19Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon19X, $icon19Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 20;
                  $pdf->Image($icon1FilePath, $icon20X, $icon20Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon20X, $icon20Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =16; $pageNo <= 16; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 21;
                  $pdf->Image($icon1FilePath, $icon21X, $icon21Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon21X, $icon21Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =17; $pageNo <= 17; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 22;
                  $pdf->Image($icon1FilePath, $icon22X, $icon22Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon22X, $icon22Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 23;
                  $pdf->Image($icon1FilePath, $icon23X, $icon23Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon23X, $icon23Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =18; $pageNo <= 18; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 24;
                  $pdf->Image($icon1FilePath, $icon24X, $icon24Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon24X, $icon24Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =19; $pageNo <= 19; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 25;
                  $pdf->Image($icon1FilePath, $icon25X, $icon25Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon25X, $icon25Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 26;
                  $pdf->Image($icon1FilePath, $icon26X, $icon26Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon26X, $icon26Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =20; $pageNo <= 20; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 27;
                  $pdf->Image($icon1FilePath, $icon27X, $icon27Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon27X, $icon27Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =21; $pageNo <= 21; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 28;
                  $pdf->Image($icon1FilePath, $icon28X, $icon28Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon28X, $icon28Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 29;
                  $pdf->Image($icon1FilePath, $icon29X, $icon29Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon29X, $icon29Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =22; $pageNo <= 22; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 30;
                  $pdf->Image($icon1FilePath, $icon30X, $icon30Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon30X, $icon30Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =23; $pageNo <= 23; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 31;
                  $pdf->Image($icon1FilePath, $icon31X, $icon31Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon31X, $icon31Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 32;
                  $pdf->Image($icon1FilePath, $icon32X, $icon32Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon32X, $icon32Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =24; $pageNo <= 24; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 33;
                  $pdf->Image($icon1FilePath, $icon33X, $icon33Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon33X, $icon33Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =25; $pageNo <= 25; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 34;
                  $pdf->Image($icon1FilePath, $icon34X, $icon34Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon34X, $icon34Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 35;
                  $pdf->Image($icon1FilePath, $icon35X, $icon35Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon35X, $icon35Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =26; $pageNo <= 26; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 36;
                  $pdf->Image($icon1FilePath, $icon36X, $icon36Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon36X, $icon36Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =27; $pageNo <= 27; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 37;
                  $pdf->Image($icon1FilePath, $icon37X, $icon37Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon37X, $icon37Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 38;
                  $pdf->Image($icon1FilePath, $icon38X, $icon38Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon38X, $icon38Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =28; $pageNo <= 28; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 39;
                  $pdf->Image($icon1FilePath, $icon39X, $icon39Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon39X, $icon39Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =29; $pageNo <= 29; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 40;
                  $pdf->Image($icon1FilePath, $icon40X, $icon40Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon40X, $icon40Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 41;
                  $pdf->Image($icon1FilePath, $icon41X, $icon41Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon41X, $icon41Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =30; $pageNo <= 30; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 42;
                  $pdf->Image($icon1FilePath, $icon42X, $icon42Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon42X, $icon42Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =31; $pageNo <= 31; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 43;
                  $pdf->Image($icon1FilePath, $icon43X, $icon43Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon43X, $icon43Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 44;
                  $pdf->Image($icon1FilePath, $icon44X, $icon44Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon44X, $icon44Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =32; $pageNo <= 32; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 45;
                  $pdf->Image($icon1FilePath, $icon45X, $icon45Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon45X, $icon45Y, $icon1Width, $icon1Height, $linkUrl);
              } 

              $pdf->Output('modified1.pdf', 'F'); //stocker dans le serveur//

              $pdfPath = 'modified1.pdf'; // Chemin vers le fichier PDF généré
              // Déplacer le fichier PDF généré dans un répertoire spécifique
              $destinationPath = public_path('/'); // Chemin vers le répertoire de destination
              File::move($pdfPath, $destinationPath . $pdfPath);
        }
        elseif($documents[0] == 'GG/concours/Arabe.pdf'){ //CONCOURS ARABE
            $icon1FilePath = public_path('pdf/imageinsert.png');
            //ICON POSITION 
            $icon1X = 140;
            $icon1Y =68;
            $icon1Width = 18;
            $icon1Height = 14;

            $icon2X = 140;
            $icon2Y =105;
            $icon2Width = 18;
            $icon2Height = 14;

            $icon3X = 140;
            $icon3Y =101;
            $icon3Width = 18;
            $icon3Height = 14;

            $icon4X = 143;
            $icon4Y =34;
            $icon4Width = 18;
            $icon4Height = 14;

            $icon5X = 140;
            $icon5Y =21;
            $icon5Width = 18;
            $icon5Height = 14;

            $icon6X = 140;
            $icon6Y =100;
            $icon6Width = 18;
            $icon6Height = 14;

            $icon7X = 140;
            $icon7Y = 38;
            $icon7Width = 18;
            $icon7Height = 14;

            $icon8X = 140;
            $icon8Y = 15;
            $icon8Width = 18;
            $icon8Height = 14;

            $icon9X = 140;
            $icon9Y = 57;
            $icon9Width = 18;
            $icon9Height = 14;

            $icon10X = 134;
            $icon10Y = 47;
            $icon10Width = 18;
            $icon10Height = 14;

            $icon11X = 130;
            $icon11Y = 52;
            $icon11Width = 18;
            $icon11Height = 14;

            $icon12X = 133;
            $icon12Y = 139;
            $icon12Width = 18;
            $icon12Height = 14;

            $icon13X = 138;
            $icon13Y = 49;
            $icon13Width = 18;
            $icon13Height = 14;

            $icon14X = 133;
            $icon14Y = 59;
            $icon14Width = 18;
            $icon14Height = 14;

            $icon15X = 128;
            $icon15Y = 61;
            $icon15Width = 18;
            $icon15Height = 14;

            $icon16X = 132;
            $icon16Y = 58;
            $icon16Width = 18;
            $icon16Height = 14;

            $icon17X = 122;
            $icon17Y = 228;
            $icon17Width = 18;
            $icon17Height = 14;

            $icon18X = 117;
            $icon18Y = 85;
            $icon18Width = 18;
            $icon18Height = 14;

            $icon19X = 150;
            $icon19Y = 53;
            $icon19Width = 18;
            $icon19Height = 14;

            $icon20X = 150;
            $icon20Y = 12;
            $icon20Width = 18;
            $icon20Height = 14;

            $icon21X = 152;
            $icon21Y = 14;
            $icon21Width = 18;
            $icon21Height = 14;

            $icon22X = 150;
            $icon22Y = 35;
            $icon22Width = 18;
            $icon22Height = 14;

            $icon23X = 147;
            $icon23Y = 29;
            $icon23Width = 18;
            $icon23Height = 14;

            $icon24X = 147;
            $icon24Y = 33;
            $icon24Width = 18;
            $icon24Height = 14;

            $icon25X = 149;
            $icon25Y = 51;
            $icon25Width = 18;
            $icon25Height = 14;

            $icon26X = 146;
            $icon26Y = 37;
            $icon26Width = 18;
            $icon26Height = 14;

            $icon27X = 148;
            $icon27Y = 35;
            $icon27Width = 18;
            $icon27Height = 14;

            $icon28X = 148;
            $icon28Y = 45;
            $icon28Width = 18;
            $icon28Height = 14;

            $icon29X = 154;
            $icon29Y = 41;
            $icon29Width = 18;
            $icon29Height = 14;

            $icon30X = 146;
            $icon30Y = 46;
            $icon30Width = 18;
            $icon30Height = 14;

            $icon31X = 146;
            $icon31Y = 44;
            $icon31Width = 18;
            $icon31Height = 14;

            $icon32X = 147;
            $icon32Y = 48;
            $icon32Width = 18;
            $icon32Height = 14;

            $icon33X = 144;
            $icon33Y = 49;
            $icon33Width = 18;
            $icon33Height = 14;

            $icon34X = 144;
            $icon34Y = 45;
            $icon34Width = 18;
            $icon34Height = 14;

            $icon35X = 142;
            $icon35Y = 43;
            $icon35Width = 18;
            $icon35Height = 14;

            $icon36X = 140;
            $icon36Y = 41;
            $icon36Width = 18;
            $icon36Height = 14;

            $icon37X = 137;
            $icon37Y = 53;
            $icon37Width = 18;
            $icon37Height = 14;

            $icon38X = 133;
            $icon38Y = 48;
            $icon38Width = 18;
            $icon38Height = 14;

            $icon39X = 136;
            $icon39Y = 47;
            $icon39Width = 18;
            $icon39Height = 14;

            $icon40X = 138;
            $icon40Y = 48;
            $icon40Width = 18;
            $icon40Height = 14;

            $icon41X = 142;
            $icon41Y = 40;
            $icon41Width = 18;
            $icon41Height = 14;

            $icon42X = 134;
            $icon42Y = 45;
            $icon42Width = 18;
            $icon42Height = 14;


            $linkUrlBase =  "https://www.abajim.com/panel/concours/teacher/".$id;
            $linkUrlBase1 = url('showvideo',);
            
            $iconUrlParam = '?icon=';
            $pageUrlParam = '&page=';

            $pdf = new Fpdi();
             // Import the pages of the original PDF and add the icons to each page
            $pageCount = $pdf->setSourceFile($pdfFilePathLocal);

            //FOR pages
            for ($pageNo = 1; $pageNo <= 3; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }              
            for ($pageNo = 4; $pageNo <= 4; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 1;
                $pdf->Image($icon1FilePath, $icon1X, $icon1Y, $icon1Width, $icon1Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon1X, $icon1Y, $icon1Width, $icon1Height, $linkUrl);
            }
            for ($pageNo = 5; $pageNo <= 5; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 2;
                $pdf->Image($icon1FilePath, $icon2X, $icon2Y, $icon2Width, $icon2Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon2X, $icon2Y, $icon2Width, $icon2Height, $linkUrl);
            }   
            for ($pageNo = 6; $pageNo <= 6; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            } 
            for ($pageNo = 7; $pageNo <= 7; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 3;
                $pdf->Image($icon1FilePath, $icon3X, $icon3Y, $icon3Width, $icon3Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon3X, $icon3Y, $icon3Width, $icon3Height, $linkUrl);
            } 
            for ($pageNo = 8; $pageNo <= 8; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            } 
            for ($pageNo = 9; $pageNo <= 9; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 4;
                $pdf->Image($icon1FilePath, $icon4X, $icon4Y, $icon4Width, $icon4Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon4X, $icon4Y, $icon4Width, $icon4Height, $linkUrl);
            } 
            for ($pageNo = 10; $pageNo <= 10; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 5;
                $pdf->Image($icon1FilePath, $icon5X, $icon5Y, $icon5Width, $icon5Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon5X, $icon5Y, $icon5Width, $icon5Height, $linkUrl);
            }   
            for ($pageNo = 11; $pageNo <= 11; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 6;
                $pdf->Image($icon1FilePath, $icon6X, $icon6Y, $icon6Width, $icon6Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon6X, $icon6Y, $icon6Width, $icon6Height, $linkUrl);
            } 
            for ($pageNo = 12; $pageNo <= 12; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            } 
            for ($pageNo = 13; $pageNo <= 13; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 7;
                $pdf->Image($icon1FilePath, $icon7X, $icon7Y, $icon7Width, $icon7Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon7X, $icon7Y, $icon7Width, $icon7Height, $linkUrl);
            } 
            for ($pageNo = 14; $pageNo <= 14; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 8;
                $pdf->Image($icon1FilePath, $icon8X, $icon8Y, $icon8Width, $icon8Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon8X, $icon8Y, $icon8Width, $icon8Height, $linkUrl);
            } 
            for ($pageNo = 15; $pageNo <= 15; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 9;
                $pdf->Image($icon1FilePath, $icon9X, $icon9Y, $icon9Width, $icon9Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon9X, $icon9Y, $icon9Width, $icon9Height, $linkUrl);
            }
            for ($pageNo = 16; $pageNo <=16; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 17; $pageNo <= 17; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 10;
                $pdf->Image($icon1FilePath, $icon10X, $icon10Y, $icon10Width, $icon10Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon10X, $icon10Y, $icon10Width, $icon10Height, $linkUrl);
            }
            for ($pageNo = 18; $pageNo <= 18; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 11;
                $pdf->Image($icon1FilePath, $icon11X, $icon11Y, $icon11Width, $icon11Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon11X, $icon11Y, $icon11Width, $icon11Height, $linkUrl);
            }
            for ($pageNo = 19; $pageNo <= 19; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 12;
                $pdf->Image($icon1FilePath, $icon12X, $icon12Y, $icon12Width, $icon12Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon12X, $icon12Y, $icon12Width, $icon12Height, $linkUrl);
            }
            for ($pageNo = 20; $pageNo <=20; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 21; $pageNo <= 21; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 13;
                $pdf->Image($icon1FilePath, $icon13X, $icon13Y, $icon13Width, $icon13Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon13X, $icon13Y, $icon13Width, $icon13Height, $linkUrl);
            }
            for ($pageNo = 22; $pageNo <= 22; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 14;
                $pdf->Image($icon1FilePath, $icon14X, $icon14Y, $icon14Width, $icon14Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon14X, $icon14Y, $icon14Width, $icon14Height, $linkUrl);
            }
            for ($pageNo = 23; $pageNo <= 23; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 15;
                $pdf->Image($icon1FilePath, $icon15X, $icon15Y, $icon15Width, $icon15Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon15X, $icon15Y, $icon15Width, $icon15Height, $linkUrl);
            }
            for ($pageNo = 24; $pageNo <=24; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 25; $pageNo <= 25; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 16;
                $pdf->Image($icon1FilePath, $icon16X, $icon16Y, $icon16Width, $icon16Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon16X, $icon16Y, $icon16Width, $icon16Height, $linkUrl);
                $iconNo = 17;
                $pdf->Image($icon1FilePath, $icon17X, $icon17Y, $icon17Width, $icon17Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon17X, $icon17Y, $icon17Width, $icon17Height, $linkUrl);
            }
            for ($pageNo = 26; $pageNo <=26; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 27; $pageNo <= 27; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 18;
                $pdf->Image($icon1FilePath, $icon18X, $icon18Y, $icon18Width, $icon18Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon18X, $icon18Y, $icon18Width, $icon18Height, $linkUrl);
            }
            for ($pageNo = 28; $pageNo <=28; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 29; $pageNo <= 29; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 19;
                $pdf->Image($icon1FilePath, $icon19X, $icon19Y, $icon19Width, $icon19Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon19X, $icon19Y, $icon19Width, $icon19Height, $linkUrl);
            }
            for ($pageNo = 30; $pageNo <= 30; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 20;
                $pdf->Image($icon1FilePath, $icon20X, $icon20Y, $icon20Width, $icon20Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon20X, $icon20Y, $icon20Width, $icon20Height, $linkUrl);
            }
            for ($pageNo = 31; $pageNo <= 31; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 21;
                $pdf->Image($icon1FilePath, $icon21X, $icon21Y, $icon21Width, $icon21Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon21X, $icon21Y, $icon21Width, $icon21Height, $linkUrl);
            }
            for ($pageNo = 32; $pageNo <=32; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 33; $pageNo <= 33; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 22;
                $pdf->Image($icon1FilePath, $icon22X, $icon22Y, $icon22Width, $icon22Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon22X, $icon22Y, $icon22Width, $icon22Height, $linkUrl);
            }
            for ($pageNo = 34; $pageNo <= 34; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 23;
                $pdf->Image($icon1FilePath, $icon23X, $icon23Y, $icon23Width, $icon23Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon23X, $icon23Y, $icon23Width, $icon23Height, $linkUrl);
            }
            for ($pageNo = 35; $pageNo <= 35; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 24;
                $pdf->Image($icon1FilePath, $icon24X, $icon24Y, $icon24Width, $icon24Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon24X, $icon24Y, $icon24Width, $icon24Height, $linkUrl);
            }
            for ($pageNo = 36; $pageNo <= 36; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 37; $pageNo <= 37; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 25;
                $pdf->Image($icon1FilePath, $icon25X, $icon25Y, $icon25Width, $icon25Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon25X, $icon25Y, $icon25Width, $icon25Height, $linkUrl);
            }
            for ($pageNo = 38; $pageNo <= 38; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 26;
                $pdf->Image($icon1FilePath, $icon26X, $icon26Y, $icon26Width, $icon26Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon26X, $icon26Y, $icon26Width, $icon26Height, $linkUrl);
            }
            for ($pageNo = 39; $pageNo <= 39; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 27;
                $pdf->Image($icon1FilePath, $icon27X, $icon27Y, $icon27Width, $icon27Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon27X, $icon27Y, $icon27Width, $icon27Height, $linkUrl);
            }
            for ($pageNo = 40; $pageNo <=40; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 41; $pageNo <= 41; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 28;
                $pdf->Image($icon1FilePath, $icon28X, $icon28Y, $icon28Width, $icon28Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon28X, $icon28Y, $icon28Width, $icon28Height, $linkUrl);
            }
            for ($pageNo = 42; $pageNo <= 42; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 29;
                $pdf->Image($icon1FilePath, $icon29X, $icon29Y, $icon29Width, $icon29Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon29X, $icon29Y, $icon29Width, $icon29Height, $linkUrl);
            }
            for ($pageNo = 43; $pageNo <= 43; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 30;
                $pdf->Image($icon1FilePath, $icon30X, $icon30Y, $icon30Width, $icon30Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon30X, $icon30Y, $icon30Width, $icon30Height, $linkUrl);
            }
            for ($pageNo = 44; $pageNo <=44; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 45; $pageNo <= 45; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 31;
                $pdf->Image($icon1FilePath, $icon31X, $icon31Y, $icon31Width, $icon31Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon31X, $icon31Y, $icon31Width, $icon31Height, $linkUrl);
            }
            for ($pageNo = 46; $pageNo <= 46; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 32;
                $pdf->Image($icon1FilePath, $icon32X, $icon32Y, $icon32Width, $icon32Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon32X, $icon32Y, $icon32Width, $icon32Height, $linkUrl);
            }
            for ($pageNo = 47; $pageNo <= 47; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 33;
                $pdf->Image($icon1FilePath, $icon33X, $icon33Y, $icon33Width, $icon33Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon33X, $icon33Y, $icon33Width, $icon33Height, $linkUrl);
            }
            for ($pageNo = 48; $pageNo <=48; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 49; $pageNo <= 49; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 34;
                $pdf->Image($icon1FilePath, $icon34X, $icon34Y, $icon34Width, $icon34Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon34X, $icon34Y, $icon34Width, $icon34Height, $linkUrl);
            }
            for ($pageNo = 50; $pageNo <= 50; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 35;
                $pdf->Image($icon1FilePath, $icon35X, $icon35Y, $icon35Width, $icon35Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon35X, $icon35Y, $icon35Width, $icon35Height, $linkUrl);
            }
            for ($pageNo = 51; $pageNo <= 51; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 36;
                $pdf->Image($icon1FilePath, $icon36X, $icon36Y, $icon36Width, $icon36Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon36X, $icon36Y, $icon36Width, $icon36Height, $linkUrl);
            }
            for ($pageNo = 52; $pageNo <=52; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 53; $pageNo <= 53; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 37;
                $pdf->Image($icon1FilePath, $icon37X, $icon37Y, $icon37Width, $icon37Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon37X, $icon37Y, $icon37Width, $icon37Height, $linkUrl);
            }
            for ($pageNo = 54; $pageNo <= 54; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 38;
                $pdf->Image($icon1FilePath, $icon38X, $icon38Y, $icon38Width, $icon38Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon38X, $icon38Y, $icon38Width, $icon38Height, $linkUrl);
            }
            for ($pageNo = 55; $pageNo <= 55; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 39;
                $pdf->Image($icon1FilePath, $icon39X, $icon39Y, $icon39Width, $icon39Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon39X, $icon39Y, $icon39Width, $icon39Height, $linkUrl);
            }
            for ($pageNo = 56; $pageNo <=56; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 57; $pageNo <= 57; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 40;
                $pdf->Image($icon1FilePath, $icon40X, $icon40Y, $icon40Width, $icon40Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon40X, $icon40Y, $icon40Width, $icon40Height, $linkUrl);
            }
            for ($pageNo = 58; $pageNo <= 58; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 41;
                $pdf->Image($icon1FilePath, $icon41X, $icon41Y, $icon41Width, $icon41Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon41X, $icon41Y, $icon41Width, $icon41Height, $linkUrl);
            }
            for ($pageNo = 59; $pageNo <= 59; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 42;
                $pdf->Image($icon1FilePath, $icon42X, $icon42Y, $icon42Width, $icon42Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon42X, $icon42Y, $icon42Width, $icon42Height, $linkUrl);
            }
             
            



            for ($pageNo = 60; $pageNo <=60; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            

            $pdf->Output('modified1.pdf', 'F'); //stocker dans le serveur//

            $pdfPath = 'modified1.pdf'; // Chemin vers le fichier PDF généré
            // Déplacer le fichier PDF généré dans un répertoire spécifique
            $destinationPath = public_path('/'); // Chemin vers le répertoire de destination
            File::move($pdfPath, $destinationPath . $pdfPath);

        }
        elseif($documents[0] == 'GG/concours/SVT.pdf'){ //CONCOURS IKADELMI
            $icon1FilePath = public_path('pdf/imageinsert.png');
            //ICON POSITION 
            $icon1X =161;
            $icon1Y = 67;
            $icon1Width = 18;
            $icon1Height = 14;

            $icon2X = 30;
            $icon2Y = 178;
            $icon2Width = 18;
            $icon2Height = 14;

            $icon3X =34;
            $icon3Y = 239;
            $icon3Width = 18;
            $icon3Height = 14;
            
            $icon4X =108;
            $icon4Y = 49;
            $icon4Width = 18;
            $icon4Height = 14;
            
            $icon5X =80;
            $icon5Y = 173;
            $icon5Width = 18;
            $icon5Height = 14;

            $icon6X =122;
            $icon6Y = 207;
            $icon6Width = 18;
            $icon6Height = 14;

            $icon7X =83;
            $icon7Y = 53;
            $icon7Width = 18;
            $icon7Height = 14;

            $icon8X =153;
            $icon8Y = 164;
            $icon8Width = 18;
            $icon8Height = 14;

            $icon9X =10;
            $icon9Y = 32;
            $icon9Width = 18;
            $icon9Height = 14;

            $icon10X =72;
            $icon10Y = 174;
            $icon10Width = 18;
            $icon10Height = 14;

            $icon11X =30;
            $icon11Y =217;
            $icon11Width = 18;
            $icon11Height = 14;

            $icon12X =165;
            $icon12Y = 74;
            $icon12Width = 18;
            $icon12Height = 14;

            $icon13X =63;
            $icon13Y = 220;
            $icon13Width = 18;
            $icon13Height = 14;

            $icon14X =56;
            $icon14Y = 54;
            $icon14Width = 18;
            $icon14Height = 14;

            $icon15X =58;
            $icon15Y = 137;
            $icon15Width = 18;
            $icon15Height = 14;

            $icon16X =163;
            $icon16Y = 205;
            $icon16Width = 18;
            $icon16Height = 14;

            $icon17X = 87;
            $icon17Y = 238;
            $icon17Width = 18;
            $icon17Height = 14;

            $icon21X =104;
            $icon21Y = 76;
            $icon21Width = 16;
            $icon21Height = 12;

            $icon22X =75;
            $icon22Y = 139;
            $icon22Width = 18;
            $icon22Height = 14;

            $icon23X =20;
            $icon23Y = 238;
            $icon23Width = 18;
            $icon23Height = 14;

            $icon24X =33;
            $icon24Y = 47;
            $icon24Width = 18;
            $icon24Height = 14;

            $icon25X =113;
            $icon25Y = 130;
            $icon25Width = 18;
            $icon25Height = 14;

            $icon26X =107;
            $icon26Y = 262;
            $icon26Width = 18;
            $icon26Height = 14;

            $icon27X =75;
            $icon27Y = 69;
            $icon27Width = 18;
            $icon27Height = 14;

            $icon28X =23;
            $icon28Y = 116;
            $icon28Width = 18;
            $icon28Height = 14;

            $icon29X =30;
            $icon29Y = 180;
            $icon29Width = 18;
            $icon29Height = 14;

            $icon30X =23;
            $icon30Y = 42;
            $icon30Width = 18;
            $icon30Height = 14;

            $icon300X =57;
            $icon300Y = 168;
            $icon300Width = 18;
            $icon300Height = 14;

            $icon31X =15;
            $icon31Y = 54;
            $icon31Width = 18;
            $icon31Height = 14;

            $icon32X =37;
            $icon32Y = 127;
            $icon32Width = 18;
            $icon32Height = 14;

            $icon33X =34;
            $icon33Y = 188;
            $icon33Width = 18;
            $icon33Height = 14;

            $icon34X =59;
            $icon34Y = 24;
            $icon34Width = 18;
            $icon34Height = 14;

            $icon35X =125;
            $icon35Y = 151;
            $icon35Width = 18;
            $icon35Height = 14;

            $icon36X =45;
            $icon36Y = 62;
            $icon36Width = 18;
            $icon36Height = 14;

            $icon37X =30;
            $icon37Y = 110;
            $icon37Width = 18;
            $icon37Height = 14;

            $icon38X =63;
            $icon38Y = 166;
            $icon38Width = 18;
            $icon38Height = 14;

            $icon39X =103;
            $icon39Y = 50;
            $icon39Width = 18;
            $icon39Height = 14;

            $icon40X =26;
            $icon40Y = 81;
            $icon40Width = 18;
            $icon40Height = 14;

            $icon41X =24;
            $icon41Y = 162;
            $icon41Width = 18;
            $icon41Height = 14;

            $icon42X =113;
            $icon42Y = 214;
            $icon42Width = 18;
            $icon42Height = 14;

            $icon43X =99;
            $icon43Y = 64;
            $icon43Width = 16;
            $icon43Height = 12;

            $icon44X =23;
            $icon44Y = 120;
            $icon44Width = 16;
            $icon44Height = 12;

            $icon45X =78;
            $icon45Y = 182;
            $icon45Width = 17;
            $icon45Height = 13;

            $icon46X =132;
            $icon46Y = 235;
            $icon46Width = 17;
            $icon46Height = 13;

            $icon47X =100;
            $icon47Y = 84;
            $icon47Width = 18;
            $icon47Height = 14;

            $icon48X =16;
            $icon48Y = 185;
            $icon48Width = 18;
            $icon48Height = 14;

            $icon49X =35;
            $icon49Y = 66;
            $icon49Width = 18;
            $icon49Height = 14;

            $icon50X =164;
            $icon50Y = 183;
            $icon50Width = 18;
            $icon50Height = 14;

            $icon51X =100;
            $icon51Y = 69;
            $icon51Width = 18;
            $icon51Height = 14;

            $icon52X =21;
            $icon52Y = 114;
            $icon52Width = 18;
            $icon52Height = 14;

            $icon53X =82;
            $icon53Y = 65;
            $icon53Width = 18;
            $icon53Height = 14;

            $icon54X =86;
            $icon54Y = 173;
            $icon54Width = 17;
            $icon54Height = 13;

            $icon55X =173;
            $icon55Y =243;
            $icon55Width = 17;
            $icon55Height = 13;

            $icon56X =32;
            $icon56Y = 217;
            $icon56Width = 18;
            $icon56Height = 14;

            $icon560X =122;
            $icon560Y = 68;
            $icon560Width = 18;
            $icon560Height = 14;

            $icon57X =122;
            $icon57Y = 178;
            $icon57Width = 18;
            $icon57Height = 14;

            $icon58X =120;
            $icon58Y = 159;
            $icon58Width = 18;
            $icon58Height = 14;

            $icon59X =130;
            $icon59Y = 61;
            $icon59Width = 18;
            $icon59Height = 14;

            $icon60X =128;
            $icon60Y = 31;
            $icon60Width = 18;
            $icon60Height = 14;

            $icon61X =123;
            $icon61Y = 35;
            $icon61Width = 18;
            $icon61Height = 14;

            $icon62X =136;
            $icon62Y = 57;
            $icon62Width = 18;
            $icon62Height = 14;

            $icon63X =136;
            $icon63Y = 36;
            $icon63Width = 18;
            $icon63Height = 14;

            $icon64X =132;
            $icon64Y = 21;
            $icon64Width = 18;
            $icon64Height = 14;

            $icon65X =138;
            $icon65Y = 55;
            $icon65Width = 18;
            $icon65Height = 14;

            $icon66X =135;
            $icon66Y = 25;
            $icon66Width = 18;
            $icon66Height = 14;

            $icon67X =130;
            $icon67Y = 22;
            $icon67Width = 18;
            $icon67Height = 14;

            $icon68X =133;
            $icon68Y = 60;
            $icon68Width = 18;
            $icon68Height = 14;

            $icon69X =130;
            $icon69Y = 30;
            $icon69Width = 18;
            $icon69Height = 14;

            $icon70X =130;
            $icon70Y = 29;
            $icon70Width = 18;
            $icon70Height = 14;

            $icon71X =133;
            $icon71Y = 78;
            $icon71Width = 18;
            $icon71Height = 14;

            $icon72X =127;
            $icon72Y = 30;
            $icon72Width = 18;
            $icon72Height = 14;

            $icon73X =123;
            $icon73Y = 26;
            $icon73Width = 18;
            $icon73Height = 14;
            
            

            $linkUrlBase =  "https://www.abajim.com/panel/concours/teacher/".$id;
            $linkUrlBase1 = url('showvideo',);
            
            $iconUrlParam = '?icon=';
            $pageUrlParam = '&page=';

            $pdf = new Fpdi();
             // Import the pages of the original PDF and add the icons to each page
            $pageCount = $pdf->setSourceFile($pdfFilePathLocal);

            //FOR pages
            for ($pageNo = 1; $pageNo <= 2; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }              
            for ($pageNo = 3; $pageNo <= 3; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 1;
                $pdf->Image($icon1FilePath, $icon1X, $icon1Y, $icon1Width, $icon1Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon1X, $icon1Y, $icon1Width, $icon1Height, $linkUrl);
                $iconNo = 2;
                $pdf->Image($icon1FilePath, $icon2X, $icon2Y, $icon2Width, $icon2Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon2X, $icon2Y, $icon2Width, $icon2Height, $linkUrl);
                $iconNo = 3;
                $pdf->Image($icon1FilePath, $icon3X, $icon3Y, $icon3Width, $icon3Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon3X, $icon3Y, $icon3Width, $icon3Height, $linkUrl);
            }
            for ($pageNo = 4; $pageNo <= 4; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 4;
                $pdf->Image($icon1FilePath, $icon4X, $icon4Y, $icon4Width, $icon4Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon4X, $icon4Y, $icon4Width, $icon4Height, $linkUrl);
                $iconNo = 5;
                $pdf->Image($icon1FilePath, $icon5X, $icon5Y, $icon5Width, $icon5Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon5X, $icon5Y, $icon5Width, $icon5Height, $linkUrl);
                $iconNo = 6;
                $pdf->Image($icon1FilePath, $icon6X, $icon6Y, $icon6Width, $icon6Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon6X, $icon6Y, $icon6Width, $icon6Height, $linkUrl);
            }
            for ($pageNo = 5; $pageNo <=5; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 6; $pageNo <= 6; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 7;
                $pdf->Image($icon1FilePath, $icon7X, $icon7Y, $icon7Width, $icon7Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon7X, $icon7Y, $icon7Width, $icon7Height, $linkUrl);
                $iconNo = 8;
                $pdf->Image($icon1FilePath, $icon8X, $icon8Y, $icon8Width, $icon8Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon8X, $icon8Y, $icon8Width, $icon8Height, $linkUrl);
            }
            for ($pageNo = 7; $pageNo <= 7; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 9;
                $pdf->Image($icon1FilePath, $icon9X, $icon9Y, $icon9Width, $icon9Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon9X, $icon9Y, $icon9Width, $icon9Height, $linkUrl);
                $iconNo = 10;
                $pdf->Image($icon1FilePath, $icon10X, $icon10Y, $icon10Width, $icon10Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon10X, $icon10Y, $icon10Width, $icon10Height, $linkUrl);
                $iconNo = 11;
                $pdf->Image($icon1FilePath, $icon11X, $icon11Y, $icon11Width, $icon11Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon11X, $icon11Y, $icon11Width, $icon11Height, $linkUrl);
            }
            for ($pageNo = 8; $pageNo <= 8; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 12;
                $pdf->Image($icon1FilePath, $icon12X, $icon12Y, $icon12Width, $icon12Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon12X, $icon12Y, $icon12Width, $icon12Height, $linkUrl);
                $iconNo = 13;
                $pdf->Image($icon1FilePath, $icon13X, $icon13Y, $icon13Width, $icon13Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon13X, $icon13Y, $icon13Width, $icon13Height, $linkUrl);
            }
            for ($pageNo = 9; $pageNo <= 9; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 14;
                $pdf->Image($icon1FilePath, $icon14X, $icon14Y, $icon14Width, $icon14Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon14X, $icon14Y, $icon14Width, $icon14Height, $linkUrl);
                $iconNo = 15;
                $pdf->Image($icon1FilePath, $icon15X, $icon15Y, $icon15Width, $icon15Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon15X, $icon15Y, $icon15Width, $icon15Height, $linkUrl);
                $iconNo = 16;
                $pdf->Image($icon1FilePath, $icon16X, $icon16Y, $icon16Width, $icon16Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon16X, $icon16Y, $icon16Width, $icon16Height, $linkUrl);
                $iconNo = 17;
                $pdf->Image($icon1FilePath, $icon17X, $icon17Y, $icon17Width, $icon17Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon17X, $icon17Y, $icon17Width, $icon17Height, $linkUrl);
            }
            for ($pageNo = 10; $pageNo <= 10; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 21;
                $pdf->Image($icon1FilePath, $icon21X, $icon21Y, $icon21Width, $icon21Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon21X, $icon21Y, $icon21Width, $icon21Height, $linkUrl);
                $iconNo = 22;
                $pdf->Image($icon1FilePath, $icon22X, $icon22Y, $icon22Width, $icon22Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon22X, $icon22Y, $icon22Width, $icon22Height, $linkUrl);
                $iconNo = 23;
                $pdf->Image($icon1FilePath, $icon23X, $icon23Y, $icon23Width, $icon23Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon23X, $icon23Y, $icon23Width, $icon23Height, $linkUrl);
            }
            for ($pageNo = 11; $pageNo <= 11; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 24;
                $pdf->Image($icon1FilePath, $icon24X, $icon24Y, $icon24Width, $icon24Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon24X, $icon24Y, $icon24Width, $icon24Height, $linkUrl);
                $iconNo = 25;
                $pdf->Image($icon1FilePath, $icon25X, $icon25Y, $icon25Width, $icon25Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon25X, $icon25Y, $icon25Width, $icon25Height, $linkUrl);
                $iconNo = 26;
                $pdf->Image($icon1FilePath, $icon26X, $icon26Y, $icon26Width, $icon26Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon26X, $icon26Y, $icon26Width, $icon26Height, $linkUrl);
            }
            for ($pageNo = 12; $pageNo <= 12; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 27;
                $pdf->Image($icon1FilePath, $icon27X, $icon27Y, $icon27Width, $icon27Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon27X, $icon27Y, $icon27Width, $icon27Height, $linkUrl);
                $iconNo = 28;
                $pdf->Image($icon1FilePath, $icon28X, $icon28Y, $icon28Width, $icon28Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon28X, $icon28Y, $icon28Width, $icon28Height, $linkUrl);
                $iconNo = 29;
                $pdf->Image($icon1FilePath, $icon29X, $icon29Y, $icon29Width, $icon29Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon29X, $icon29Y, $icon29Width, $icon29Height, $linkUrl);
            }
            for ($pageNo = 13; $pageNo <= 13; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 30;
                $pdf->Image($icon1FilePath, $icon30X, $icon30Y, $icon30Width, $icon30Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon30X, $icon30Y, $icon30Width, $icon30Height, $linkUrl);
                $iconNo = 300;
                $pdf->Image($icon1FilePath, $icon300X, $icon300Y, $icon300Width, $icon300Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon300X, $icon300Y, $icon300Width, $icon300Height, $linkUrl);
            }
            for ($pageNo = 14; $pageNo <= 14; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 31;
                $pdf->Image($icon1FilePath, $icon31X, $icon31Y, $icon31Width, $icon31Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon31X, $icon31Y, $icon31Width, $icon31Height, $linkUrl);
                $iconNo = 32;
                $pdf->Image($icon1FilePath, $icon32X, $icon32Y, $icon32Width, $icon32Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon32X, $icon32Y, $icon32Width, $icon32Height, $linkUrl);
                $iconNo = 33;
                $pdf->Image($icon1FilePath, $icon33X, $icon33Y, $icon33Width, $icon33Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon33X, $icon33Y, $icon33Width, $icon33Height, $linkUrl);
            }
            for ($pageNo = 15; $pageNo <= 15; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 34;
                $pdf->Image($icon1FilePath, $icon34X, $icon34Y, $icon34Width, $icon34Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon34X, $icon34Y, $icon34Width, $icon34Height, $linkUrl);
                $iconNo = 35;
                $pdf->Image($icon1FilePath, $icon35X, $icon35Y, $icon35Width, $icon35Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon35X, $icon35Y, $icon35Width, $icon35Height, $linkUrl);
            }
            for ($pageNo = 16; $pageNo <= 16; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 36;
                $pdf->Image($icon1FilePath, $icon36X, $icon36Y, $icon36Width, $icon36Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon36X, $icon36Y, $icon36Width, $icon36Height, $linkUrl);
                $iconNo = 37;
                $pdf->Image($icon1FilePath, $icon37X, $icon37Y, $icon37Width, $icon37Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon37X, $icon37Y, $icon37Width, $icon37Height, $linkUrl);
                $iconNo = 38;
                $pdf->Image($icon1FilePath, $icon38X, $icon38Y, $icon38Width, $icon38Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon38X, $icon38Y, $icon38Width, $icon38Height, $linkUrl);
            }
            for ($pageNo = 17; $pageNo <= 17; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 39;
                $pdf->Image($icon1FilePath, $icon39X, $icon39Y, $icon39Width, $icon39Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon39X, $icon39Y, $icon39Width, $icon39Height, $linkUrl);
                $iconNo = 40;
                $pdf->Image($icon1FilePath, $icon40X, $icon40Y, $icon40Width, $icon40Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon40X, $icon40Y, $icon40Width, $icon40Height, $linkUrl);
                $iconNo = 41;
                $pdf->Image($icon1FilePath, $icon41X, $icon41Y, $icon41Width, $icon41Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon41X, $icon41Y, $icon41Width, $icon41Height, $linkUrl);
                $iconNo = 42;
                $pdf->Image($icon1FilePath, $icon42X, $icon42Y, $icon42Width, $icon42Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon42X, $icon42Y, $icon42Width, $icon42Height, $linkUrl);
            }
            for ($pageNo = 18; $pageNo <= 18; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 43;
                $pdf->Image($icon1FilePath, $icon43X, $icon43Y, $icon43Width, $icon43Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon43X, $icon43Y, $icon43Width, $icon43Height, $linkUrl);
                $iconNo = 44;
                $pdf->Image($icon1FilePath, $icon44X, $icon44Y, $icon44Width, $icon44Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon44X, $icon44Y, $icon44Width, $icon44Height, $linkUrl);
                $iconNo = 45;
                $pdf->Image($icon1FilePath, $icon45X, $icon45Y, $icon45Width, $icon45Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon45X, $icon45Y, $icon45Width, $icon45Height, $linkUrl);
                $iconNo = 46;
                $pdf->Image($icon1FilePath, $icon46X, $icon46Y, $icon46Width, $icon46Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon46X, $icon46Y, $icon46Width, $icon46Height, $linkUrl);
            }
            for ($pageNo = 19; $pageNo <= 19; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 47;
                $pdf->Image($icon1FilePath, $icon47X, $icon47Y, $icon47Width, $icon47Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon47X, $icon47Y, $icon47Width, $icon47Height, $linkUrl);
                $iconNo = 48;
                $pdf->Image($icon1FilePath, $icon48X, $icon48Y, $icon48Width, $icon48Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon48X, $icon48Y, $icon48Width, $icon48Height, $linkUrl);
            }
            for ($pageNo = 20; $pageNo <= 20; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 49;
                $pdf->Image($icon1FilePath, $icon49X, $icon49Y, $icon49Width, $icon49Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon49X, $icon49Y, $icon49Width, $icon49Height, $linkUrl);
                $iconNo = 50;
                $pdf->Image($icon1FilePath, $icon50X, $icon50Y, $icon50Width, $icon50Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon50X, $icon50Y, $icon50Width, $icon50Height, $linkUrl);
            }
            for ($pageNo = 21; $pageNo <= 21; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 51;
                $pdf->Image($icon1FilePath, $icon51X, $icon51Y, $icon51Width, $icon51Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon51X, $icon51Y, $icon51Width, $icon51Height, $linkUrl);
                $iconNo = 52;
                $pdf->Image($icon1FilePath, $icon52X, $icon52Y, $icon52Width, $icon52Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon52X, $icon52Y, $icon52Width, $icon52Height, $linkUrl);
            }
            for ($pageNo = 22; $pageNo <= 22; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 53;
                $pdf->Image($icon1FilePath, $icon53X, $icon53Y, $icon53Width, $icon53Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon53X, $icon53Y, $icon53Width, $icon53Height, $linkUrl);
                $iconNo = 54;
                $pdf->Image($icon1FilePath, $icon54X, $icon54Y, $icon54Width, $icon54Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon54X, $icon54Y, $icon54Width, $icon54Height, $linkUrl);
                $iconNo = 55;
                $pdf->Image($icon1FilePath, $icon55X, $icon55Y, $icon55Width, $icon55Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon55X, $icon55Y, $icon55Width, $icon55Height, $linkUrl);
            }
            for ($pageNo = 23; $pageNo <= 23; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 56;
                $pdf->Image($icon1FilePath, $icon56X, $icon56Y, $icon56Width, $icon56Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon56X, $icon56Y, $icon56Width, $icon56Height, $linkUrl);
            }
            for ($pageNo = 24; $pageNo <= 24; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 560;
                $pdf->Image($icon1FilePath, $icon560X, $icon560Y, $icon560Width, $icon560Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon560X, $icon560Y, $icon560Width, $icon560Height, $linkUrl);
                $iconNo = 57;
                $pdf->Image($icon1FilePath, $icon57X, $icon57Y, $icon57Width, $icon57Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon57X, $icon57Y, $icon57Width, $icon57Height, $linkUrl);
            }
            for ($pageNo = 25; $pageNo <= 25; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 58;
                $pdf->Image($icon1FilePath, $icon58X, $icon58Y, $icon58Width, $icon58Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon58X, $icon58Y, $icon58Width, $icon58Height, $linkUrl);
            }
            for ($pageNo = 26; $pageNo <=26; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 27; $pageNo <=27; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 28; $pageNo <= 28; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 59;
                $pdf->Image($icon1FilePath, $icon59X, $icon59Y, $icon59Width, $icon59Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon59X, $icon59Y, $icon59Width, $icon59Height, $linkUrl);
            }
            for ($pageNo = 29; $pageNo <= 29; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 60;
                $pdf->Image($icon1FilePath, $icon60X, $icon60Y, $icon60Width, $icon60Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon60X, $icon60Y, $icon60Width, $icon60Height, $linkUrl);
            }
            for ($pageNo = 30; $pageNo <= 30; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 61;
                $pdf->Image($icon1FilePath, $icon61X, $icon61Y, $icon61Width, $icon61Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon61X, $icon61Y, $icon61Width, $icon61Height, $linkUrl);
            }
            for ($pageNo = 31; $pageNo <=31; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 32; $pageNo <= 32; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 62;
                $pdf->Image($icon1FilePath, $icon62X, $icon62Y, $icon62Width, $icon62Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon62X, $icon62Y, $icon62Width, $icon62Height, $linkUrl);
            }
            for ($pageNo = 33; $pageNo <= 33; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 63;
                $pdf->Image($icon1FilePath, $icon63X, $icon63Y, $icon63Width, $icon63Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon63X, $icon63Y, $icon63Width, $icon63Height, $linkUrl);
            }
            for ($pageNo = 34; $pageNo <= 34; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 64;
                $pdf->Image($icon1FilePath, $icon64X, $icon64Y, $icon64Width, $icon64Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon64X, $icon64Y, $icon64Width, $icon64Height, $linkUrl);
            }
            for ($pageNo = 35; $pageNo <=3; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 36; $pageNo <= 36; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 65;
                $pdf->Image($icon1FilePath, $icon65X, $icon65Y, $icon65Width, $icon65Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon65X, $icon65Y, $icon65Width, $icon65Height, $linkUrl);
            }
            for ($pageNo = 37; $pageNo <= 37; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 66;
                $pdf->Image($icon1FilePath, $icon66X, $icon66Y, $icon66Width, $icon66Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon66X, $icon66Y, $icon66Width, $icon66Height, $linkUrl);
            }
            for ($pageNo = 38; $pageNo <= 38; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 67;
                $pdf->Image($icon1FilePath, $icon67X, $icon67Y, $icon67Width, $icon67Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon67X, $icon67Y, $icon67Width, $icon67Height, $linkUrl);
            }
            for ($pageNo = 39; $pageNo <=39; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 40; $pageNo <= 40; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 68;
                $pdf->Image($icon1FilePath, $icon68X, $icon68Y, $icon68Width, $icon68Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon68X, $icon68Y, $icon68Width, $icon68Height, $linkUrl);
            }
            for ($pageNo = 41; $pageNo <= 41; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 69;
                $pdf->Image($icon1FilePath, $icon69X, $icon69Y, $icon69Width, $icon69Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon69X, $icon69Y, $icon69Width, $icon69Height, $linkUrl);
            }
            for ($pageNo = 42; $pageNo <= 42; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 70;
                $pdf->Image($icon1FilePath, $icon70X, $icon70Y, $icon70Width, $icon70Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon70X, $icon70Y, $icon70Width, $icon70Height, $linkUrl);
            }
            for ($pageNo = 43; $pageNo <=43; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 44; $pageNo <= 44; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 71;
                $pdf->Image($icon1FilePath, $icon71X, $icon71Y, $icon71Width, $icon71Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon71X, $icon71Y, $icon71Width, $icon71Height, $linkUrl);
            }
            for ($pageNo = 45; $pageNo <= 45; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 72;
                $pdf->Image($icon1FilePath, $icon72X, $icon72Y, $icon72Width, $icon72Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon72X, $icon72Y, $icon72Width, $icon72Height, $linkUrl);
            }
            for ($pageNo = 46; $pageNo <= 46; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 73;
                $pdf->Image($icon1FilePath, $icon73X, $icon73Y, $icon73Width, $icon73Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon73X, $icon73Y, $icon73Width, $icon73Height, $linkUrl);
            }
            for ($pageNo = 47; $pageNo <=47; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            



            for ($pageNo = 48; $pageNo <=48; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            

            $pdf->Output('modified1.pdf', 'F'); //stocker dans le serveur//

            $pdfPath = 'modified1.pdf'; // Chemin vers le fichier PDF généré
            // Déplacer le fichier PDF généré dans un répertoire spécifique
            $destinationPath = public_path('/'); // Chemin vers le répertoire de destination
            File::move($pdfPath, $destinationPath . $pdfPath);

        }
        elseif($documents[0] == 'GG/concours/FR.pdf'){ //CONCOURS FRANCE
            $icon1FilePath = public_path('pdf/imageinsert.png');
            //ICON POSITION 
            $icon1X = 60;
            $icon1Y = 59;
            $icon1Width = 18;
            $icon1Height = 14;

            $icon2X =47;
            $icon2Y = 50;
            $icon2Width = 18;
            $icon2Height = 14;

            $icon3X =51;
            $icon3Y = 190;
            $icon3Width = 18;
            $icon3Height = 14;

            $icon4X =66;
            $icon4Y = 80;
            $icon4Width = 18;
            $icon4Height = 14;

            $icon5X =57;
            $icon5Y = 17;
            $icon5Width = 18;
            $icon5Height = 14;

            $icon6X =42;
            $icon6Y = 17;
            $icon6Width = 18;
            $icon6Height = 14;

            $icon7X =46;
            $icon7Y = 161;
            $icon7Width = 18;
            $icon7Height = 14;

            $icon8X =62;
            $icon8Y = 42;
            $icon8Width = 18;
            $icon8Height = 14;

            $icon9X =53;
            $icon9Y = 42;
            $icon9Width = 18;
            $icon9Height = 14;

            $icon10X = 39;
            $icon10Y = 34;
            $icon10Width = 18;
            $icon10Height = 14;

            $icon11X = 42;
            $icon11Y = 149;
            $icon11Width = 18;
            $icon11Height = 14;

            $icon12X = 60;
            $icon12Y = 23;
            $icon12Width = 18;
            $icon12Height = 14;

            $icon13X = 53;
            $icon13Y = 43;
            $icon13Width = 18;
            $icon13Height = 14;

            $icon14X =36;
            $icon14Y = 44;
            $icon14Width = 18;
            $icon14Height = 14;

            $icon15X =43;
            $icon15Y = 168;
            $icon15Width = 18;
            $icon15Height = 14;

            $icon16X =70;
            $icon16Y = 53;
            $icon16Width = 18;
            $icon16Height = 14;

            $icon17X =53;
            $icon17Y = 46;
            $icon17Width = 18;
            $icon17Height = 14;

            $icon18X =60;
            $icon18Y = 155;
            $icon18Width = 18;
            $icon18Height = 14;

            $icon19X =73;
            $icon19Y = 46;
            $icon19Width = 18;
            $icon19Height = 14;

            $icon20X =70;
            $icon20Y = 53;
            $icon20Width = 18;
            $icon20Height = 14;

            $icon21X =55;
            $icon21Y = 55;
            $icon21Width = 18;
            $icon21Height = 14;

            $icon22X = 60;
            $icon22Y = 169;
            $icon22Width = 18;
            $icon22Height = 14;

            $icon23X =68;
            $icon23Y = 53;
            $icon23Width = 18;
            $icon23Height = 14;

            $icon24X =66;
            $icon24Y = 49;
            $icon24Width = 18;
            $icon24Height = 14;

            $icon25X =57;
            $icon25Y = 43;
            $icon25Width = 18;
            $icon25Height = 14;

            $icon26X =57;
            $icon26Y = 168;
            $icon26Width = 18;
            $icon26Height = 14;

            $icon27X =78;
            $icon27Y = 47;
            $icon27Width = 18;
            $icon27Height = 14;

            $icon28X =70;
            $icon28Y = 65;
            $icon28Width = 18;
            $icon28Height = 14;

            $icon29X =54;
            $icon29Y = 44;
            $icon29Width = 18;
            $icon29Height = 14;

            $icon30X =60;
            $icon30Y = 127;
            $icon30Width = 18;
            $icon30Height = 14;

            $icon31X =70;
            $icon31Y = 45;
            $icon31Width = 18;
            $icon31Height = 14;

            $icon32X =66;
            $icon32Y = 56;
            $icon32Width = 18;
            $icon32Height = 14;

            $icon33X =53;
            $icon33Y = 37;
            $icon33Width = 18;
            $icon33Height = 14;

            $icon34X = 59;
            $icon34Y = 178;
            $icon34Width = 18;
            $icon34Height = 14;

            $icon35X =73;
            $icon35Y = 45;
            $icon35Width = 18;
            $icon35Height = 14;

            $icon36X =68;
            $icon36Y = 51;
            $icon36Width = 18;
            $icon36Height = 14;

            $icon37X =50;
            $icon37Y = 47;
            $icon37Width = 18;
            $icon37Height = 14;

            $icon38X =55;
            $icon38Y = 154;
            $icon38Width = 18;
            $icon38Height = 14;

            $icon39X =74;
            $icon39Y = 47;
            $icon39Width = 18;
            $icon39Height = 14;

            $icon40X =65;
            $icon40Y = 60;
            $icon40Width = 18;
            $icon40Height = 14;

            $icon41X =50;
            $icon41Y = 50;
            $icon41Width = 18;
            $icon41Height = 14;

            $icon42X =53;
            $icon42Y = 162;
            $icon42Width = 18;
            $icon42Height = 14;

            $icon43X =68;
            $icon43Y = 52;
            $icon43Width = 18;
            $icon43Height = 14;

            $icon44X =92;
            $icon44Y = 59;
            $icon44Width = 18;
            $icon44Height = 14;

            $icon45X =63;
            $icon45Y = 54;
            $icon45Width = 18;
            $icon45Height = 14;

            $icon46X =69;
            $icon46Y = 172;
            $icon46Width = 18;
            $icon46Height = 14;

            $icon47X =96;
            $icon47Y = 44;
            $icon47Width = 18;
            $icon47Height = 14;

            $icon48X =93;
            $icon48Y = 52;
            $icon48Width = 18;
            $icon48Height = 14;

            $icon49X =66;
            $icon49Y = 46;
            $icon49Width = 18;
            $icon49Height = 14;

            $icon50X =64;
            $icon50Y = 186;
            $icon50Width = 18;
            $icon50Height = 14;

            $icon51X =94;
            $icon51Y = 43;
            $icon51Width = 18;
            $icon51Height = 14;

            $icon52X =90;
            $icon52Y = 54;
            $icon52Width = 18;
            $icon52Height = 14;

            $icon53X =68;
            $icon53Y = 45;
            $icon53Width = 18;
            $icon53Height = 14;

            $icon54X =66;
            $icon54Y = 179;
            $icon54Width = 18;
            $icon54Height = 14;

            $icon55X =93;
            $icon55Y = 51;
            $icon55Width = 18;
            $icon55Height = 14;


            $icon56X =86;
            $icon56Y = 51;
            $icon56Width = 18;
            $icon56Height = 14;

            $icon57X =73;
            $icon57Y = 48;
            $icon57Width = 18;
            $icon57Height = 14;

            $icon58X =76;
            $icon58Y = 163;
            $icon58Width = 18;
            $icon58Height = 14;

            $icon59X =88;
            $icon59Y = 51;
            $icon59Width = 18;
            $icon59Height = 14;

            $icon60X =89;
            $icon60Y = 57;
            $icon60Width = 18;
            $icon60Height = 14;

            $icon61X =76;
            $icon61Y = 47;
            $icon61Width = 18;
            $icon61Height = 14;

            $icon62X =78;
            $icon62Y = 156;
            $icon62Width = 18;
            $icon62Height = 14;

            $icon63X =86;
            $icon63Y = 46;
            $icon63Width = 18;
            $icon63Height = 14;

            

            $linkUrlBase =  "https://www.abajim.com/panel/concours/teacher/".$id;
            $linkUrlBase1 = url('showvideo',);
            
            $iconUrlParam = '?icon=';
            $pageUrlParam = '&page=';

            $pdf = new Fpdi();
             // Import the pages of the original PDF and add the icons to each page
            $pageCount = $pdf->setSourceFile($pdfFilePathLocal);

            //FOR pages
           
            for ($pageNo = 1; $pageNo <= 3; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }              
            for ($pageNo = 4; $pageNo <= 4; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 1;
                $pdf->Image($icon1FilePath, $icon1X, $icon1Y, $icon1Width, $icon1Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon1X, $icon1Y, $icon1Width, $icon1Height, $linkUrl);
            }
            for ($pageNo = 5; $pageNo <= 5; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 2;
                $pdf->Image($icon1FilePath, $icon2X, $icon2Y, $icon2Width, $icon2Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon2X, $icon2Y, $icon2Width, $icon2Height, $linkUrl);
                $iconNo = 3;
                $pdf->Image($icon1FilePath, $icon3X, $icon3Y, $icon3Width, $icon3Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon3X, $icon3Y, $icon3Width, $icon3Height, $linkUrl);
            }
            for ($pageNo = 6; $pageNo <= 6; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 4;
                $pdf->Image($icon1FilePath, $icon4X, $icon4Y, $icon4Width, $icon4Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon4X, $icon4Y, $icon4Width, $icon4Height, $linkUrl);
            }
            for ($pageNo = 7; $pageNo <=7; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 8; $pageNo <= 8; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 5;
                $pdf->Image($icon1FilePath, $icon5X, $icon5Y, $icon5Width, $icon5Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon5X, $icon5Y, $icon5Width, $icon5Height, $linkUrl);
            }
            for ($pageNo = 9; $pageNo <= 9; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 6;
                $pdf->Image($icon1FilePath, $icon6X, $icon6Y, $icon6Width, $icon6Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon6X, $icon6Y, $icon6Width, $icon6Height, $linkUrl);
                $iconNo = 7;
                $pdf->Image($icon1FilePath, $icon7X, $icon7Y, $icon7Width, $icon7Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon7X, $icon7Y, $icon7Width, $icon7Height, $linkUrl);
            }
            for ($pageNo = 10; $pageNo <= 10; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 8;
                $pdf->Image($icon1FilePath, $icon8X, $icon8Y, $icon8Width, $icon8Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon8X, $icon8Y, $icon8Width, $icon8Height, $linkUrl);
            }
            for ($pageNo = 11; $pageNo <=11; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 12; $pageNo <= 12; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 9;
                $pdf->Image($icon1FilePath, $icon9X, $icon9Y, $icon9Width, $icon9Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon9X, $icon9Y, $icon9Width, $icon9Height, $linkUrl);
            }
            for ($pageNo = 13; $pageNo <= 13; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 10;
                $pdf->Image($icon1FilePath, $icon10X, $icon10Y, $icon10Width, $icon10Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon10X, $icon10Y, $icon10Width, $icon10Height, $linkUrl);
                $iconNo = 11;
                $pdf->Image($icon1FilePath, $icon11X, $icon11Y, $icon11Width, $icon11Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon11X, $icon11Y, $icon11Width, $icon11Height, $linkUrl);
            }
            for ($pageNo = 14; $pageNo <= 14; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 12;
                $pdf->Image($icon1FilePath, $icon12X, $icon12Y, $icon12Width, $icon12Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon12X, $icon12Y, $icon12Width, $icon12Height, $linkUrl);
            }
            for ($pageNo = 15; $pageNo <=15; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 16; $pageNo <= 16; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 13;
                $pdf->Image($icon1FilePath, $icon13X, $icon13Y, $icon13Width, $icon13Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon13X, $icon13Y, $icon13Width, $icon13Height, $linkUrl);
            }
            for ($pageNo = 17; $pageNo <= 17; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 14;
                $pdf->Image($icon1FilePath, $icon14X, $icon14Y, $icon14Width, $icon14Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon14X, $icon14Y, $icon14Width, $icon14Height, $linkUrl);
                $iconNo = 15;
                $pdf->Image($icon1FilePath, $icon15X, $icon15Y, $icon15Width, $icon15Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon15X, $icon15Y, $icon15Width, $icon15Height, $linkUrl);
            }
            for ($pageNo = 18; $pageNo <=18; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 19; $pageNo <= 19; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 16;
                $pdf->Image($icon1FilePath, $icon16X, $icon16Y, $icon16Width, $icon16Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon16X, $icon16Y, $icon16Width, $icon16Height, $linkUrl);
            }
            for ($pageNo = 20; $pageNo <= 20; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 17;
                $pdf->Image($icon1FilePath, $icon17X, $icon17Y, $icon17Width, $icon17Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon17X, $icon17Y, $icon17Width, $icon17Height, $linkUrl);
                $iconNo = 18;
                $pdf->Image($icon1FilePath, $icon18X, $icon18Y, $icon18Width, $icon18Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon18X, $icon18Y, $icon18Width, $icon18Height, $linkUrl);
            }
            for ($pageNo = 21; $pageNo <= 21; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 19;
                $pdf->Image($icon1FilePath, $icon19X, $icon19Y, $icon19Width, $icon19Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon19X, $icon19Y, $icon19Width, $icon19Height, $linkUrl);
            }
            for ($pageNo = 22; $pageNo <=22; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 23; $pageNo <= 23; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 20;
                $pdf->Image($icon1FilePath, $icon20X, $icon20Y, $icon20Width, $icon20Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon20X, $icon20Y, $icon20Width, $icon20Height, $linkUrl);
            }
            for ($pageNo = 24; $pageNo <= 24; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 21;
                $pdf->Image($icon1FilePath, $icon21X, $icon21Y, $icon21Width, $icon21Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon21X, $icon21Y, $icon21Width, $icon21Height, $linkUrl);
                $iconNo = 22;
                $pdf->Image($icon1FilePath, $icon22X, $icon22Y, $icon22Width, $icon22Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon22X, $icon22Y, $icon22Width, $icon22Height, $linkUrl);
            }
            for ($pageNo = 25; $pageNo <= 25; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 23;
                $pdf->Image($icon1FilePath, $icon23X, $icon23Y, $icon23Width, $icon23Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon23X, $icon23Y, $icon23Width, $icon23Height, $linkUrl);
            }
            for ($pageNo = 26; $pageNo <=26; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 27; $pageNo <= 27; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 24;
                $pdf->Image($icon1FilePath, $icon24X, $icon24Y, $icon24Width, $icon24Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon24X, $icon24Y, $icon24Width, $icon24Height, $linkUrl);
            }
            for ($pageNo = 28; $pageNo <= 28; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 25;
                $pdf->Image($icon1FilePath, $icon25X, $icon25Y, $icon25Width, $icon25Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon25X, $icon25Y, $icon25Width, $icon25Height, $linkUrl);
                $iconNo = 26;
                $pdf->Image($icon1FilePath, $icon26X, $icon26Y, $icon26Width, $icon26Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon26X, $icon26Y, $icon26Width, $icon26Height, $linkUrl);
            }
            for ($pageNo = 29; $pageNo <= 29; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 27;
                $pdf->Image($icon1FilePath, $icon27X, $icon27Y, $icon27Width, $icon27Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon27X, $icon27Y, $icon27Width, $icon27Height, $linkUrl);
            }
            for ($pageNo = 30; $pageNo <=30; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 31; $pageNo <= 31; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 28;
                $pdf->Image($icon1FilePath, $icon28X, $icon28Y, $icon28Width, $icon28Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon28X, $icon28Y, $icon28Width, $icon28Height, $linkUrl);
            }
            for ($pageNo = 32; $pageNo <= 32; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 29;
                $pdf->Image($icon1FilePath, $icon29X, $icon29Y, $icon29Width, $icon29Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon29X, $icon29Y, $icon29Width, $icon29Height, $linkUrl);
                $iconNo = 30;
                $pdf->Image($icon1FilePath, $icon30X, $icon30Y, $icon30Width, $icon30Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon30X, $icon30Y, $icon30Width, $icon30Height, $linkUrl);
            }
            for ($pageNo = 33; $pageNo <= 33; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 31;
                $pdf->Image($icon1FilePath, $icon31X, $icon31Y, $icon31Width, $icon31Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon31X, $icon31Y, $icon31Width, $icon31Height, $linkUrl);
            }
            for ($pageNo = 34; $pageNo <=34; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 35; $pageNo <= 35; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 32;
                $pdf->Image($icon1FilePath, $icon32X, $icon32Y, $icon32Width, $icon32Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon32X, $icon32Y, $icon32Width, $icon32Height, $linkUrl);
            }
            for ($pageNo = 36; $pageNo <= 36; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 33;
                $pdf->Image($icon1FilePath, $icon33X, $icon33Y, $icon33Width, $icon33Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon33X, $icon33Y, $icon33Width, $icon33Height, $linkUrl);
                $iconNo = 34;
                $pdf->Image($icon1FilePath, $icon34X, $icon34Y, $icon34Width, $icon34Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon34X, $icon34Y, $icon34Width, $icon34Height, $linkUrl);
            }
            for ($pageNo = 37; $pageNo <= 37; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 35;
                $pdf->Image($icon1FilePath, $icon35X, $icon35Y, $icon35Width, $icon35Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon35X, $icon35Y, $icon35Width, $icon35Height, $linkUrl);
            }
            for ($pageNo = 38; $pageNo <=38; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 39; $pageNo <= 39; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 36;
                $pdf->Image($icon1FilePath, $icon36X, $icon36Y, $icon36Width, $icon36Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon36X, $icon36Y, $icon36Width, $icon36Height, $linkUrl);
            }
            for ($pageNo = 40; $pageNo <= 40; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 37;
                $pdf->Image($icon1FilePath, $icon37X, $icon37Y, $icon37Width, $icon37Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon37X, $icon37Y, $icon37Width, $icon37Height, $linkUrl);
                $iconNo = 38;
                $pdf->Image($icon1FilePath, $icon38X, $icon38Y, $icon38Width, $icon38Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon38X, $icon38Y, $icon38Width, $icon38Height, $linkUrl);
            }
            for ($pageNo = 41; $pageNo <= 41; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 39;
                $pdf->Image($icon1FilePath, $icon39X, $icon39Y, $icon39Width, $icon39Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon39X, $icon39Y, $icon39Width, $icon39Height, $linkUrl);
            }
            for ($pageNo = 42; $pageNo <=42; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 43; $pageNo <= 43; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 40;
                $pdf->Image($icon1FilePath, $icon40X, $icon40Y, $icon40Width, $icon40Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon40X, $icon40Y, $icon40Width, $icon40Height, $linkUrl);
            }
            for ($pageNo = 44; $pageNo <= 44; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 41;
                $pdf->Image($icon1FilePath, $icon41X, $icon41Y, $icon41Width, $icon41Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon41X, $icon41Y, $icon41Width, $icon41Height, $linkUrl);
                $iconNo = 42;
                $pdf->Image($icon1FilePath, $icon42X, $icon42Y, $icon42Width, $icon42Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon42X, $icon42Y, $icon42Width, $icon42Height, $linkUrl);
            }
            for ($pageNo = 45; $pageNo <= 45; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 43;
                $pdf->Image($icon1FilePath, $icon43X, $icon43Y, $icon43Width, $icon43Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon43X, $icon43Y, $icon43Width, $icon43Height, $linkUrl);
            }
            for ($pageNo = 46; $pageNo <=46; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 47; $pageNo <= 47; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 44;
                $pdf->Image($icon1FilePath, $icon44X, $icon44Y, $icon44Width, $icon44Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon44X, $icon44Y, $icon44Width, $icon44Height, $linkUrl);
            }
            for ($pageNo = 48; $pageNo <= 48; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 45;
                $pdf->Image($icon1FilePath, $icon45X, $icon45Y, $icon45Width, $icon45Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon45X, $icon45Y, $icon45Width, $icon45Height, $linkUrl);
                $iconNo = 46;
                $pdf->Image($icon1FilePath, $icon46X, $icon46Y, $icon46Width, $icon46Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon46X, $icon46Y, $icon46Width, $icon46Height, $linkUrl);
            }
            for ($pageNo = 49; $pageNo <= 49; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 47;
                $pdf->Image($icon1FilePath, $icon47X, $icon47Y, $icon47Width, $icon47Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon47X, $icon47Y, $icon47Width, $icon47Height, $linkUrl);
            }
            for ($pageNo = 50; $pageNo <=50; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 51; $pageNo <= 51; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 48;
                $pdf->Image($icon1FilePath, $icon48X, $icon48Y, $icon48Width, $icon48Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon48X, $icon48Y, $icon48Width, $icon48Height, $linkUrl);
            }
            for ($pageNo = 52; $pageNo <= 52; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 49;
                $pdf->Image($icon1FilePath, $icon49X, $icon49Y, $icon49Width, $icon49Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon49X, $icon49Y, $icon49Width, $icon49Height, $linkUrl);
                $iconNo = 50;
                $pdf->Image($icon1FilePath, $icon50X, $icon50Y, $icon50Width, $icon50Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon50X, $icon50Y, $icon50Width, $icon50Height, $linkUrl);
            }
            for ($pageNo = 53; $pageNo <= 53; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 51;
                $pdf->Image($icon1FilePath, $icon51X, $icon51Y, $icon51Width, $icon51Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon51X, $icon51Y, $icon51Width, $icon51Height, $linkUrl);
            }
            for ($pageNo = 54; $pageNo <=54; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 55; $pageNo <= 55; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 52;
                $pdf->Image($icon1FilePath, $icon52X, $icon52Y, $icon52Width, $icon52Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon52X, $icon52Y, $icon52Width, $icon52Height, $linkUrl);
            }
            for ($pageNo = 56; $pageNo <= 56; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 53;
                $pdf->Image($icon1FilePath, $icon53X, $icon53Y, $icon53Width, $icon53Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon53X, $icon53Y, $icon53Width, $icon53Height, $linkUrl);
                $iconNo = 54;
                $pdf->Image($icon1FilePath, $icon54X, $icon54Y, $icon54Width, $icon54Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon54X, $icon54Y, $icon54Width, $icon54Height, $linkUrl);
            }
            for ($pageNo = 57; $pageNo <= 57; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 55;
                $pdf->Image($icon1FilePath, $icon55X, $icon55Y, $icon55Width, $icon55Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon55X, $icon55Y, $icon55Width, $icon55Height, $linkUrl);
            }
            for ($pageNo = 58; $pageNo <=58; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 59; $pageNo <= 59; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 56;
                $pdf->Image($icon1FilePath, $icon56X, $icon56Y, $icon56Width, $icon56Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon56X, $icon56Y, $icon56Width, $icon56Height, $linkUrl);
            }
            for ($pageNo = 60; $pageNo <= 60; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 57;
                $pdf->Image($icon1FilePath, $icon57X, $icon57Y, $icon57Width, $icon57Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon57X, $icon57Y, $icon57Width, $icon57Height, $linkUrl);
                $iconNo = 58;
                $pdf->Image($icon1FilePath, $icon58X, $icon58Y, $icon58Width, $icon58Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon58X, $icon58Y, $icon58Width, $icon58Height, $linkUrl);
            }
            for ($pageNo = 61; $pageNo <= 61; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 59;
                $pdf->Image($icon1FilePath, $icon59X, $icon59Y, $icon59Width, $icon59Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon59X, $icon59Y, $icon59Width, $icon59Height, $linkUrl);
            }
            for ($pageNo = 62; $pageNo <=62; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            for ($pageNo = 63; $pageNo <= 63; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 60;
                $pdf->Image($icon1FilePath, $icon60X, $icon60Y, $icon60Width, $icon60Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon60X, $icon60Y, $icon60Width, $icon60Height, $linkUrl);
            }
            for ($pageNo = 64; $pageNo <= 64; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 61;
                $pdf->Image($icon1FilePath, $icon61X, $icon61Y, $icon61Width, $icon61Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon61X, $icon61Y, $icon61Width, $icon61Height, $linkUrl);
                $iconNo = 62;
                $pdf->Image($icon1FilePath, $icon62X, $icon62Y, $icon62Width, $icon62Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon62X, $icon62Y, $icon62Width, $icon62Height, $linkUrl);
            }
            for ($pageNo = 65; $pageNo <= 65; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 63;
                $pdf->Image($icon1FilePath, $icon63X, $icon63Y, $icon63Width, $icon63Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon63X, $icon63Y, $icon63Width, $icon63Height, $linkUrl);
            }
            



            for ($pageNo = 66; $pageNo <=66; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }

            $pdf->Output('modified1.pdf', 'F'); //stocker dans le serveur//

            $pdfPath = 'modified1.pdf'; // Chemin vers le fichier PDF généré
            // Déplacer le fichier PDF généré dans un répertoire spécifique
            $destinationPath = public_path('/'); // Chemin vers le répertoire de destination
            File::move($pdfPath, $destinationPath . $pdfPath);

        }
        elseif($documents[0] == 'GG/concours/ENG.pdf'){ //CONCOURS ENGLISH
            $icon1FilePath = public_path('pdf/imageinsert.png');
            //ICON POSITION 
            $icon1X = 100;
            $icon1Y =106;
            $icon1Width = 18;
            $icon1Height = 14;

            $icon2X = 88;
            $icon2Y =219;
            $icon2Width = 18;
            $icon2Height = 14;

            $icon3X = 107;
            $icon3Y =130;
            $icon3Width = 18;
            $icon3Height = 14;

            $icon4X = 95;
            $icon4Y =100;
            $icon4Width = 18;
            $icon4Height = 14;

            $icon5X = 80;
            $icon5Y =10;
            $icon5Width = 18;
            $icon5Height = 14;

            $icon6X = 100;
            $icon6Y =139;
            $icon6Width = 18;
            $icon6Height = 14;

            $icon7X = 97;
            $icon7Y =143;
            $icon7Width = 18;
            $icon7Height = 14;

            $icon8X = 77;
            $icon8Y =54;
            $icon8Width = 18;
            $icon8Height = 14;

            $icon9X = 74;
            $icon9Y =143;
            $icon9Width = 18;
            $icon9Height = 14;

            $icon10X = 77;
            $icon10Y =121;
            $icon10Width = 18;
            $icon10Height = 14;

            $icon11X = 66;
            $icon11Y =227;
            $icon11Width = 17;
            $icon11Height = 13;

            $icon12X = 68;
            $icon12Y =124;
            $icon12Width = 18;
            $icon12Height = 14;

            $icon13X = 78;
            $icon13Y = 116;
            $icon13Width = 18;
            $icon13Height = 14;

            $icon14X = 68;
            $icon14Y = 52;
            $icon14Width = 18;
            $icon14Height = 14;

            $icon15X = 64;
            $icon15Y = 161;
            $icon15Width = 18;
            $icon15Height = 14;

            $icon16X = 85;
            $icon16Y = 121;
            $icon16Width = 18;
            $icon16Height = 14;

            $icon17X = 76;
            $icon17Y = 56;
            $icon17Width = 18;
            $icon17Height = 14;

            $icon18X = 74;
            $icon18Y = 166;
            $icon18Width = 18;
            $icon18Height = 14;

            $icon19X = 72;
            $icon19Y = 113;
            $icon19Width = 18;
            $icon19Height = 14;

            $icon20X = 63;
            $icon20Y = 38;
            $icon20Width = 18;
            $icon20Height = 14;

            $icon21X = 61;
            $icon21Y = 165;
            $icon21Width = 18;
            $icon21Height = 14;

            $icon22X = 72;
            $icon22Y = 135;
            $icon22Width = 18;
            $icon22Height = 14;

            $icon23X = 64;
            $icon23Y = 55;
            $icon23Width = 18;
            $icon23Height = 14;

            $icon24X = 63;
            $icon24Y = 178;
            $icon24Width = 18;
            $icon24Height = 14;

            $icon25X = 75;
            $icon25Y = 148;
            $icon25Width = 18;
            $icon25Height = 14;

            $icon26X = 62;
            $icon26Y = 42;
            $icon26Width = 18;
            $icon26Height = 14;

            $icon27X = 65;
            $icon27Y = 146;
            $icon27Width = 18;
            $icon27Height = 14;

            $icon28X = 110;
            $icon28Y = 141;
            $icon28Width = 18;
            $icon28Height = 14;

            $icon29X = 75;
            $icon29Y = 236;
            $icon29Width = 18;
            $icon29Height = 14;

            $icon30X = 72;
            $icon30Y = 104;
            $icon30Width = 18;
            $icon30Height = 14;

            $icon31X = 132;
            $icon31Y = 133;
            $icon31Width = 18;
            $icon31Height = 14;

            $icon32X = 93;
            $icon32Y = 235;
            $icon32Width = 18;
            $icon32Height = 14;

            $icon33X = 88;
            $icon33Y = 93;
            $icon33Width = 18;
            $icon33Height = 14;

            $icon34X = 114;
            $icon34Y = 123;
            $icon34Width = 17;
            $icon34Height = 13;

            $icon35X = 78;
            $icon35Y = 187;
            $icon35Width = 18;
            $icon35Height = 14;

            $icon36X = 82;
            $icon36Y = 83;
            $icon36Width = 18;
            $icon36Height = 14;

            $icon37X = 123;
            $icon37Y = 117;
            $icon37Width = 18;
            $icon37Height = 14;

            $icon38X = 83;
            $icon38Y = 213;
            $icon38Width = 18;
            $icon38Height = 14;

            $icon39X = 75;
            $icon39Y = 123;
            $icon39Width = 18;
            $icon39Height = 14;

            $icon40X = 128;
            $icon40Y = 54;
            $icon40Width = 18;
            $icon40Height = 14;

            $icon41X = 82;
            $icon41Y = 119;
            $icon41Width = 18;
            $icon41Height = 14;

            $icon42X = 77;
            $icon42Y = 46;
            $icon42Width = 18;
            $icon42Height = 14;

            $icon43X = 137;
            $icon43Y = 72;
            $icon43Width = 18;
            $icon43Height = 14;

            $icon44X = 97;
            $icon44Y = 182;
            $icon44Width = 18;
            $icon44Height = 14;

            $icon45X = 80;
            $icon45Y = 140;
            $icon45Width = 18;
            $icon45Height = 14;

            

            $linkUrlBase =  "https://www.abajim.com/panel/concours/teacher/".$id;
            $linkUrlBase1 = url('showvideo',);
            
            $iconUrlParam = '?icon=';
            $pageUrlParam = '&page=';

            $pdf = new Fpdi();
             // Import the pages of the original PDF and add the icons to each page
            $pageCount = $pdf->setSourceFile($pdfFilePathLocal);

            //FOR pages
            for ($pageNo = 1; $pageNo <= 2; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }              
            for ($pageNo = 3; $pageNo <= 3; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 1;
                $pdf->Image($icon1FilePath, $icon1X, $icon1Y, $icon1Width, $icon1Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon1X, $icon1Y, $icon1Width, $icon1Height, $linkUrl);
                $iconNo = 2;
                $pdf->Image($icon1FilePath, $icon2X, $icon2Y, $icon2Width, $icon2Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon2X, $icon2Y, $icon2Width, $icon2Height, $linkUrl);
            }
            for ($pageNo = 4; $pageNo <= 4; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 3;
                $pdf->Image($icon1FilePath, $icon3X, $icon3Y, $icon3Width, $icon3Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon3X, $icon3Y, $icon3Width, $icon3Height, $linkUrl);
            }
            for ($pageNo = 5; $pageNo <= 5; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 4;
                $pdf->Image($icon1FilePath, $icon4X, $icon4Y, $icon4Width, $icon4Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon4X, $icon4Y, $icon4Width, $icon4Height, $linkUrl);
            }
            for ($pageNo = 6; $pageNo <= 6; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 5;
                $pdf->Image($icon1FilePath, $icon5X, $icon5Y, $icon5Width, $icon5Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon5X, $icon5Y, $icon5Width, $icon5Height, $linkUrl);
                $iconNo = 6;
                $pdf->Image($icon1FilePath, $icon6X, $icon6Y, $icon6Width, $icon6Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon6X, $icon6Y, $icon6Width, $icon6Height, $linkUrl);
            }
            for ($pageNo = 7; $pageNo <= 7; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 7;
                $pdf->Image($icon1FilePath, $icon7X, $icon7Y, $icon7Width, $icon7Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon7X, $icon7Y, $icon7Width, $icon7Height, $linkUrl);
            }
            for ($pageNo = 8; $pageNo <= 8; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 8;
                $pdf->Image($icon1FilePath, $icon8X, $icon8Y, $icon8Width, $icon8Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon8X, $icon8Y, $icon8Width, $icon8Height, $linkUrl);
                $iconNo = 9;
                $pdf->Image($icon1FilePath, $icon9X, $icon9Y, $icon9Width, $icon9Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon9X, $icon9Y, $icon9Width, $icon9Height, $linkUrl);
            }
            for ($pageNo = 9; $pageNo <= 9; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 10;
                $pdf->Image($icon1FilePath, $icon10X, $icon10Y, $icon10Width, $icon10Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon10X, $icon10Y, $icon10Width, $icon10Height, $linkUrl);
                $iconNo = 11;
                $pdf->Image($icon1FilePath, $icon11X, $icon11Y, $icon11Width, $icon11Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon11X, $icon11Y, $icon11Width, $icon11Height, $linkUrl);
            }
            for ($pageNo = 10; $pageNo <= 10; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 12;
                $pdf->Image($icon1FilePath, $icon12X, $icon12Y, $icon12Width, $icon12Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon12X, $icon12Y, $icon12Width, $icon12Height, $linkUrl);
            }
            for ($pageNo = 11; $pageNo <= 11; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 13;
                $pdf->Image($icon1FilePath, $icon13X, $icon13Y, $icon13Width, $icon13Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon13X, $icon13Y, $icon13Width, $icon13Height, $linkUrl);
            }
            for ($pageNo = 12; $pageNo <= 12; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 14;
                $pdf->Image($icon1FilePath, $icon14X, $icon14Y, $icon14Width, $icon14Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon14X, $icon14Y, $icon14Width, $icon14Height, $linkUrl);
                $iconNo = 15;
                $pdf->Image($icon1FilePath, $icon15X, $icon15Y, $icon15Width, $icon15Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon15X, $icon15Y, $icon15Width, $icon15Height, $linkUrl);
            }
            for ($pageNo = 13; $pageNo <= 13; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 16;
                $pdf->Image($icon1FilePath, $icon16X, $icon16Y, $icon16Width, $icon16Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon16X, $icon16Y, $icon16Width, $icon16Height, $linkUrl);
            }
            for ($pageNo = 14; $pageNo <= 14; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 17;
                $pdf->Image($icon1FilePath, $icon17X, $icon17Y, $icon17Width, $icon17Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon17X, $icon17Y, $icon17Width, $icon17Height, $linkUrl);
                $iconNo = 18;
                $pdf->Image($icon1FilePath, $icon18X, $icon18Y, $icon18Width, $icon18Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon18X, $icon18Y, $icon18Width, $icon18Height, $linkUrl);
            }
            for ($pageNo = 15; $pageNo <= 15; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 19;
                $pdf->Image($icon1FilePath, $icon19X, $icon19Y, $icon19Width, $icon19Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon19X, $icon19Y, $icon19Width, $icon19Height, $linkUrl);
            }
            for ($pageNo = 16; $pageNo <= 16; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 20;
                $pdf->Image($icon1FilePath, $icon20X, $icon20Y, $icon20Width, $icon20Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon20X, $icon20Y, $icon20Width, $icon20Height, $linkUrl);
                $iconNo = 21;
                $pdf->Image($icon1FilePath, $icon21X, $icon21Y, $icon21Width, $icon21Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon21X, $icon21Y, $icon21Width, $icon21Height, $linkUrl);
            }
            for ($pageNo = 17; $pageNo <= 17; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 22;
                $pdf->Image($icon1FilePath, $icon22X, $icon22Y, $icon22Width, $icon22Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon22X, $icon22Y, $icon22Width, $icon22Height, $linkUrl);
            }
            for ($pageNo = 18; $pageNo <= 18; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 23;
                $pdf->Image($icon1FilePath, $icon23X, $icon23Y, $icon23Width, $icon23Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon23X, $icon23Y, $icon23Width, $icon23Height, $linkUrl);
                $iconNo = 24;
                $pdf->Image($icon1FilePath, $icon24X, $icon24Y, $icon24Width, $icon24Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon24X, $icon24Y, $icon24Width, $icon24Height, $linkUrl);
            }
            for ($pageNo = 19; $pageNo <= 19; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 25;
                $pdf->Image($icon1FilePath, $icon25X, $icon25Y, $icon25Width, $icon25Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon25X, $icon25Y, $icon25Width, $icon25Height, $linkUrl);
            }
            for ($pageNo = 20; $pageNo <= 20; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 26;
                $pdf->Image($icon1FilePath, $icon26X, $icon26Y, $icon26Width, $icon26Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon26X, $icon26Y, $icon26Width, $icon26Height, $linkUrl);
                $iconNo = 27;
                $pdf->Image($icon1FilePath, $icon27X, $icon27Y, $icon27Width, $icon27Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon27X, $icon27Y, $icon27Width, $icon27Height, $linkUrl);
            }
            for ($pageNo = 21; $pageNo <= 21; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 28;
                $pdf->Image($icon1FilePath, $icon28X, $icon28Y, $icon28Width, $icon28Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon28X, $icon28Y, $icon28Width, $icon28Height, $linkUrl);
                $iconNo = 29;
                $pdf->Image($icon1FilePath, $icon29X, $icon29Y, $icon29Width, $icon29Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon29X, $icon29Y, $icon29Width, $icon29Height, $linkUrl);
            }
            for ($pageNo = 22; $pageNo <= 22; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 30;
                $pdf->Image($icon1FilePath, $icon30X, $icon30Y, $icon30Width, $icon30Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon30X, $icon30Y, $icon30Width, $icon30Height, $linkUrl);
            }
            for ($pageNo = 23; $pageNo <= 23; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 31;
                $pdf->Image($icon1FilePath, $icon31X, $icon31Y, $icon31Width, $icon31Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon31X, $icon31Y, $icon31Width, $icon31Height, $linkUrl);
                $iconNo = 32;
                $pdf->Image($icon1FilePath, $icon32X, $icon32Y, $icon32Width, $icon32Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon32X, $icon32Y, $icon32Width, $icon32Height, $linkUrl);
            }
            for ($pageNo = 24; $pageNo <= 24; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 33;
                $pdf->Image($icon1FilePath, $icon33X, $icon33Y, $icon33Width, $icon33Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon33X, $icon33Y, $icon33Width, $icon33Height, $linkUrl);
            }
            for ($pageNo = 25; $pageNo <= 25; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 34;
                $pdf->Image($icon1FilePath, $icon34X, $icon34Y, $icon34Width, $icon34Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon34X, $icon34Y, $icon34Width, $icon34Height, $linkUrl);
                $iconNo = 35;
                $pdf->Image($icon1FilePath, $icon35X, $icon35Y, $icon35Width, $icon35Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon35X, $icon35Y, $icon35Width, $icon35Height, $linkUrl);
            }
            for ($pageNo = 26; $pageNo <= 26; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 36;
                $pdf->Image($icon1FilePath, $icon36X, $icon36Y, $icon36Width, $icon36Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon36X, $icon36Y, $icon36Width, $icon36Height, $linkUrl);
            }
            for ($pageNo = 27; $pageNo <= 27; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 37;
                $pdf->Image($icon1FilePath, $icon37X, $icon37Y, $icon37Width, $icon37Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon37X, $icon37Y, $icon37Width, $icon37Height, $linkUrl);
                $iconNo = 38;
                $pdf->Image($icon1FilePath, $icon38X, $icon38Y, $icon38Width, $icon38Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon38X, $icon38Y, $icon38Width, $icon38Height, $linkUrl);
            }
            for ($pageNo = 28; $pageNo <= 28; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 39;
                $pdf->Image($icon1FilePath, $icon39X, $icon39Y, $icon39Width, $icon39Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon39X, $icon39Y, $icon39Width, $icon39Height, $linkUrl);
            }
            for ($pageNo = 29; $pageNo <= 29; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 40;
                $pdf->Image($icon1FilePath, $icon40X, $icon40Y, $icon40Width, $icon40Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon40X, $icon40Y, $icon40Width, $icon40Height, $linkUrl);
            }
            for ($pageNo = 30; $pageNo <= 30; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 41;
                $pdf->Image($icon1FilePath, $icon41X, $icon41Y, $icon41Width, $icon41Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon41X, $icon41Y, $icon41Width, $icon41Height, $linkUrl);
            }
            for ($pageNo = 31; $pageNo <= 31; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 42;
                $pdf->Image($icon1FilePath, $icon42X, $icon42Y, $icon42Width, $icon42Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon42X, $icon42Y, $icon42Width, $icon42Height, $linkUrl);
            }
            for ($pageNo = 32; $pageNo <= 32; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 43;
                $pdf->Image($icon1FilePath, $icon43X, $icon43Y, $icon43Width, $icon43Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon43X, $icon43Y, $icon43Width, $icon43Height, $linkUrl);
            }
            for ($pageNo = 33; $pageNo <= 33; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 44;
                $pdf->Image($icon1FilePath, $icon44X, $icon44Y, $icon44Width, $icon44Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon44X, $icon44Y, $icon44Width, $icon44Height, $linkUrl);
            }
            for ($pageNo = 34; $pageNo <= 34; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
                $iconNo = 45;
                $pdf->Image($icon1FilePath, $icon45X, $icon45Y, $icon45Width, $icon45Height, 'PNG');
                $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                $pdf->Link($icon45X, $icon45Y, $icon45Width, $icon45Height, $linkUrl);
            }
            
            for ($pageNo = 35; $pageNo <=36; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
            $pdf->Output('modified1.pdf', 'F'); //stocker dans le serveur//

            $pdfPath = 'modified1.pdf'; // Chemin vers le fichier PDF généré
            // Déplacer le fichier PDF généré dans un répertoire spécifique
            $destinationPath = public_path('/'); // Chemin vers le répertoire de destination
            File::move($pdfPath, $destinationPath . $pdfPath);

        }

       
        $data=[
            'concour'=>$concour,
            'pdfFilePath' => $pdfFilePathServer,
            'page'=>$page,
            

            
        ];
        return view('web.default.panel.Concours.index',$data);
       
    }
      /**
    * Show the form  Upload Video  to icon plus .
     *
     * @return \Illuminate\Http\Response
     */
    public function UploadIconPlus($id) 
    {
   
        $documents = Concours::where('id',$id)->pluck('pdf_path_url');
        $concour = Concours::where('id',$id)->first();
        $icon = request('icon');
        $page = request('page');
        $pdfFilePathServer = env('APP_ENV_URL1').$documents[0];   
        $data=[
            'concour'=>$concour,
            'icon'=>$icon,
            'pdfFilePath' => $pdfFilePathServer,
            'page'=>$page,
            
        ];
        return view('web.default.panel.Concours.upload_video',$data);
       
    }


     /**
    * Insert Video  to icon plus .
     *
     * @return \Illuminate\Http\Response
     */

    public function getConcoursByLevelEnfant()
    {
        $concours = Concours::all();
        $data=[
            'concour'=>$concours,
        
        ];
        return view('web.default.panel.Concours.concoursEnfant',$data);
    }  
    public function getConcoursBookAndInsertIconPlay($id)
    {
        $documents = Concours::where('id',$id)->pluck('pdf_path_url');
        $concours = Concours::where('id',$id)->first();
        $page = request('page');
        $icon = request('icon');

        $pdfFilePathLocal = public_path($documents[0]) ;   //Use in insert Icon 
        $pdfFilePathServer = env('APP_ENV_URL').$documents[0];
        if ($documents[0] == '/concours/Math.pdf') { //CONCOURS MATH
            $icon1FilePath = public_path('pdf/imageinsert.png');

            $icon1X = 135;
            $icon1Y = 50;
            $icon1Width = 18;
            $icon1Height = 14;
            $icon2X = 135;
            $icon2Y = 124;
            $icon3X = 137;
            $icon3Y = 73;
            $icon4X = 137;
            $icon4Y = 56;
            $icon5X = 137;
            $icon5Y = 140;
            $icon6X = 127;
            $icon6Y = 28;
            $icon7X = 134;
            $icon7Y = 50;
            $icon8X = 134;
            $icon8Y = 158;
            $icon9X = 134;
            $icon9Y = 22;
            $icon10X = 132;
            $icon10Y = 67;
            $icon11X = 132;
            $icon11Y = 200;
            $icon12X = 132;
            $icon12Y = 28;
            $icon13X = 139;
            $icon13Y = 55;
            $icon14X = 139;
            $icon14Y = 147;
            $icon15X = 120;
            $icon15Y = 26;
            $icon16X = 131;
            $icon16Y = 55;
            $icon17X = 131;
            $icon17Y = 181;
            $icon18X = 131;
            $icon18Y = 75;
            $icon19X = 135;
            $icon19Y = 57;
            $icon20X = 135;
            $icon20Y = 166;
            $icon21X = 132;
            $icon21Y = 32;
            $icon22X = 137;
            $icon22Y = 63;
            $icon23X = 137;
            $icon23Y = 150;
            $icon24X = 135;
            $icon24Y = 26;
            $icon25X = 133;
            $icon25Y = 63;
            $icon26X = 133;
            $icon26Y = 150;
            $icon27X = 135;
            $icon27Y = 27;
            $icon28X = 143;
            $icon28Y = 70;
            $icon29X = 143;
            $icon29Y = 159;
            $icon30X = 148;
            $icon30Y = 24;
            $icon31X = 140;
            $icon31Y = 64;
            $icon32X = 140;
            $icon32Y = 173;
            $icon33X = 136;
            $icon33Y = 22;
            $icon34X = 132;
            $icon34Y = 52;
            $icon35X = 132;
            $icon35Y = 222;
            $icon36X = 132;
            $icon36Y = 59;
            $icon37X = 132;
            $icon37Y = 57;
            $icon38X = 132;
            $icon38Y = 179;
            $icon39X = 130;
            $icon39Y = 19;
            $icon40X = 140;
            $icon40Y = 56;
            $icon41X = 140;
            $icon41Y = 170;
            $icon42X = 142;
            $icon42Y = 18;
            $icon43X = 135;
            $icon43Y = 48;
            $icon44X = 135;
            $icon44Y = 173;
            $icon45X = 137;
            $icon45Y = 90;
             
            $linkUrlBase =  "https://www.abajim.com/panel/enfant/concours/".$id;
            $linkUrlBase1 = url('showvideo',);
            
            $iconUrlParam = '?icon=';
            $pageUrlParam = '&page=';

            $pdf = new Fpdi();
             // Import the pages of the original PDF and add the icons to each page
            $pageCount = $pdf->setSourceFile($pdfFilePathLocal);

              for ($pageNo = 1; $pageNo <= 2; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->addPage();
                $pdf->useTemplate($templateId);
              }
              for ($pageNo =3; $pageNo <= 3; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 1;
                  $pdf->Image($icon1FilePath, $icon1X, $icon1Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon1X, $icon1Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 2;
                  $pdf->Image($icon1FilePath, $icon2X, $icon2Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon2X, $icon2Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =4; $pageNo <= 4; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 3;
                  $pdf->Image($icon1FilePath, $icon3X, $icon3Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon3X, $icon3Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =5; $pageNo <= 5; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 4;
                  $pdf->Image($icon1FilePath, $icon4X, $icon4Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon4X, $icon4Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 5;
                  $pdf->Image($icon1FilePath, $icon5X, $icon5Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon5X, $icon5Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =6; $pageNo <= 6; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 6;
                  $pdf->Image($icon1FilePath, $icon6X, $icon6Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon6X, $icon6Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =7; $pageNo <= 7; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 7;
                  $pdf->Image($icon1FilePath, $icon7X, $icon7Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon7X, $icon7Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 8;
                  $pdf->Image($icon1FilePath, $icon8X, $icon8Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon8X, $icon8Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =8; $pageNo <= 8; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 9;
                  $pdf->Image($icon1FilePath, $icon9X, $icon9Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon9X, $icon9Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =9; $pageNo <= 9; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 10;
                  $pdf->Image($icon1FilePath, $icon10X, $icon10Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon10X, $icon10Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 11;
                  $pdf->Image($icon1FilePath, $icon11X, $icon11Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon11X, $icon11Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =10; $pageNo <= 10; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 12;
                  $pdf->Image($icon1FilePath, $icon12X, $icon12Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon12X, $icon12Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =11; $pageNo <= 11; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 13;
                  $pdf->Image($icon1FilePath, $icon13X, $icon13Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon13X, $icon13Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 14;
                  $pdf->Image($icon1FilePath, $icon14X, $icon14Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon14X, $icon14Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =12; $pageNo <= 12; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 15;
                  $pdf->Image($icon1FilePath, $icon15X, $icon15Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon15X, $icon15Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =13; $pageNo <= 13; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 16;
                  $pdf->Image($icon1FilePath, $icon16X, $icon16Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon16X, $icon16Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 17;
                  $pdf->Image($icon1FilePath, $icon17X, $icon17Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon17X, $icon17Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =14; $pageNo <= 14; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 18;
                  $pdf->Image($icon1FilePath, $icon18X, $icon18Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon18X, $icon18Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =15; $pageNo <= 15; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 19;
                  $pdf->Image($icon1FilePath, $icon19X, $icon19Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon19X, $icon19Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 20;
                  $pdf->Image($icon1FilePath, $icon20X, $icon20Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon20X, $icon20Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =16; $pageNo <= 16; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 21;
                  $pdf->Image($icon1FilePath, $icon21X, $icon21Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon21X, $icon21Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =17; $pageNo <= 17; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 22;
                  $pdf->Image($icon1FilePath, $icon22X, $icon22Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon22X, $icon22Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 23;
                  $pdf->Image($icon1FilePath, $icon23X, $icon23Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon23X, $icon23Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =18; $pageNo <= 18; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 24;
                  $pdf->Image($icon1FilePath, $icon24X, $icon24Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon24X, $icon24Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =19; $pageNo <= 19; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 25;
                  $pdf->Image($icon1FilePath, $icon25X, $icon25Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon25X, $icon25Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 26;
                  $pdf->Image($icon1FilePath, $icon26X, $icon26Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon26X, $icon26Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =20; $pageNo <= 20; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 27;
                  $pdf->Image($icon1FilePath, $icon27X, $icon27Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon27X, $icon27Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =21; $pageNo <= 21; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 28;
                  $pdf->Image($icon1FilePath, $icon28X, $icon28Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon28X, $icon28Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 29;
                  $pdf->Image($icon1FilePath, $icon29X, $icon29Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon29X, $icon29Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =22; $pageNo <= 22; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 30;
                  $pdf->Image($icon1FilePath, $icon30X, $icon30Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon30X, $icon30Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =23; $pageNo <= 23; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 31;
                  $pdf->Image($icon1FilePath, $icon31X, $icon31Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon31X, $icon31Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 32;
                  $pdf->Image($icon1FilePath, $icon32X, $icon32Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon32X, $icon32Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =24; $pageNo <= 24; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 33;
                  $pdf->Image($icon1FilePath, $icon33X, $icon33Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon33X, $icon33Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =25; $pageNo <= 25; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 34;
                  $pdf->Image($icon1FilePath, $icon34X, $icon34Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon34X, $icon34Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 35;
                  $pdf->Image($icon1FilePath, $icon35X, $icon35Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon35X, $icon35Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =26; $pageNo <= 26; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 36;
                  $pdf->Image($icon1FilePath, $icon36X, $icon36Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon36X, $icon36Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =27; $pageNo <= 27; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 37;
                  $pdf->Image($icon1FilePath, $icon37X, $icon37Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon37X, $icon37Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 38;
                  $pdf->Image($icon1FilePath, $icon38X, $icon38Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon38X, $icon38Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =28; $pageNo <= 28; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 39;
                  $pdf->Image($icon1FilePath, $icon39X, $icon39Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon39X, $icon39Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =29; $pageNo <= 29; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 40;
                  $pdf->Image($icon1FilePath, $icon40X, $icon40Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon40X, $icon40Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 41;
                  $pdf->Image($icon1FilePath, $icon41X, $icon41Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon41X, $icon41Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =30; $pageNo <= 30; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 42;
                  $pdf->Image($icon1FilePath, $icon42X, $icon42Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon42X, $icon42Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =31; $pageNo <= 31; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 43;
                  $pdf->Image($icon1FilePath, $icon43X, $icon43Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon43X, $icon43Y, $icon1Width, $icon1Height, $linkUrl);
                  $iconNo = 44;
                  $pdf->Image($icon1FilePath, $icon44X, $icon44Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon44X, $icon44Y, $icon1Width, $icon1Height, $linkUrl);
              }
              for ($pageNo =32; $pageNo <= 32; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $pdf->addPage();
                  $pdf->useTemplate($templateId);
                  $iconNo = 45;
                  $pdf->Image($icon1FilePath, $icon45X, $icon45Y, $icon1Width, $icon1Height, 'PNG');
                  $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
                  $pdf->Link($icon45X, $icon45Y, $icon1Width, $icon1Height, $linkUrl);
              } 

              $pdf->Output('modified1.pdf', 'F'); //stocker dans le serveur//

              $pdfPath = 'modified1.pdf'; // Chemin vers le fichier PDF généré
              // Déplacer le fichier PDF généré dans un répertoire spécifique
              $destinationPath = public_path('/'); // Chemin vers le répertoire de destination
              File::move($pdfPath, $destinationPath . $pdfPath);
        }
        $data = [
            'concour' => $concours,
            'icon'=>$icon,
            'pdfFilePath' => $pdfFilePathServer,
            'page'=>$page,
        ];
        return view('web.default.panel.Concours.concoursBook', $data);
    }

     /**
    * Insert Video  to icon plus .
     *
     * @return \Illuminate\Http\Response
     */

    public function Addvideo(Request $request)
    {
      if ($request->hasFile('video')) {
          
        $video = $request->file('video');
        $filename = time() . '_' . $video->getClientOriginalName();
        $path = $video->move(public_path('videos'), $filename);
        $url =  'https://www.abajim.com/Abajim/public/videos/' . $filename;
            $user = auth()->user();
            VideoConcour::insert([
                'video_path' => $url,
                'page' => $request->page,
                'numero_icon' => $request->numero,
                'concours_id' =>  $request->concour,
                'user_id' =>   $user->id,
                'status' => "published",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $toastData = [
              'title' => trans('public.request_success'),
              'msg' => trans('site.become_instructor_success_request'),
              'status' => 'success'
          ];
      
            return response()->json(['toast' =>$toastData, 'path' =>  $path ], 200);
        }   
    
        return response()->json(['message' => 'No file uploaded'], 400);
    }
    //-------------------------Server with S3 Add Video--------------------------------------------
    // public function Addvideo(Request $request)
    // {
    //   if ($request->hasFile('video')) {
    //     try {
    //             $video = $request->file('video');
    //             $filename = time() . '_' . $video->getClientOriginalName();
    //             $path = $video->move(public_path('videos'), $filename);
    //             $url =  'https://www.abajim.com/Abajim/public/videos/' . $filename;
    //             // $filename = time() . '_' . $video->getClientOriginalName();
    //             // $s3 = Storage::disk('s3');
    //             // $s3->putFileAs('videos', $video, $filename, 'public', [
    //             //     'multipart' => true
    //             // ]);
    //             // $url = 'https://videos-abajim-1.s3.de.io.cloud.ovh.net/videos/' . $filename;
    //                 $user = auth()->user();
    //                 $videoRecord =VideoConcour::insert([
    //                     'video_path' => $url,
    //                     'page' => $request->page,
    //                     'numero_icon' => $request->numero,
    //                     'concours_id' =>  $request->concour,
    //                     'user_id' =>   $user->id,
    //                     'status' => "published",
    //                     'created_at' => now(),
    //                     'updated_at' => now(),
    //                 ]);
    //                 $toastData = [
    //                 'title' => trans('public.request_success'),
    //                 'msg' => trans('site.become_instructor_success_request'),
    //                 'status' => 'success'
    //                 ];
    //                 return response()->json([
    //                     'message' => trans('panel.add_video_success'),
    //                     'url' => $url,
    //                     'videoId' => $videoRecord->id,
    //                     'toast' => $toastData
    //                 ], 200);
    //         } catch (\Exception $e) {
    //             $toastData = [
    //                 'title' => trans('public.request_failed'),
    //                 'msg' => trans('panel.add_video_failed'),
    //                 'status' => 'error',
    //             ];

    //             return response()->json([
    //                 'message' => 'Video upload failed',
    //                 'error' => $e->getMessage(),
    //                 'toast' => $toastData
    //             ], 500);
    //         }
    //         return response()->json(['toast' =>$toastData, 'path' =>  $path ], 200);
    //     }   
    
    //     return response()->json(['message' => 'No file uploaded'], 400);
    // }
    //---------------------------------------------------------------------------------------------


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
