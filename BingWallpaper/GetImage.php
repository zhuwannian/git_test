<?php

namespace BingWallpaper;



/**
 * ls -la 
 * drwxr-xr-x   4 a123456  staff  128  9 14 13:48 BingWallpaper
 * -rw-r--r--   1 a123456  staff  820  9 14 13:43 README.en.md
 * -rw-r--r--   1 a123456  staff  909  9 14 13:43 README.md
 * 
 * 代码执行
 * php BingWallpaper/GetImage.php 
 * 
 * 
 */
include_once './BingWallpaper/UA.php';
// include_once '../BingWallpaper/UA.php';

use BingWallpaper\UA;



class GetImage
{

    public $enUrl = 'https://cn.bing.com/hp/api/model?FORM=BEHPTB&ensearch=1';
    public $enOldUrl = 'https://cn.bing.com/HPImageArchive.aspx?mkt=en-us&format=js&idx=0&n=8&nc=1614319565639&pid=hp&FORM=BEHPTB&uhd=1&uhdwidth=3840&uhdheight=2160';
    
    // public $enOldUrl = 'https://global.bing.com/HPImageArchive.aspx?mkt=en-us&format=js&idx=0&n=8&nc=1614319565639&pid=hp&FORM=BEHPTB&uhd=1&uhdwidth=3840&uhdheight=2160';
    // public $enOldUrl = 'https://www.bing.com/HPImageArchive.aspx?mkt=en-us&format=js&idx=0&n=8&nc=1614319565639&pid=hp&FORM=BEHPTB&uhd=1&uhdwidth=3840&uhdheight=2160';
    // public $enOldUrl = 'https://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1';  // 返回最近一个     一天一张图片
    // public $enOldUrl = 'https://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=8';  // 返回最近 8个图片  一天一张图片


    // public $zhUrl = 'https://cn.bing.com/hp/api/model?FORM=BEHPTB&ensearch=0';
    // public $zhUrl = 'https://www.bing.com/hp/api/model?FORM=Z9FD1&ensearch=0';
    // public $zhOldUrl = 'https://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1';
    public $zhUrl = 'https://cn.bing.com/hp/api/model?FORM=Z9FD1&ensearch=0';
    public $zhOldUrl = 'https://cn.bing.com/HPImageArchive.aspx?mkt=zh-CN&format=js&idx=0&n=1&nc=1614319565639&pid=hp&FORM=BEHPTB&uhd=1&uhdwidth=3840&uhdheight=2160';





    // $imaUrl = 'https://www.bing.com/th?id=OHR.MarbleCanyon_ZH-CN1066862981_UHD.jpg&rf=LaDigue_1920x1200.jpg';
    // $imaUrl = 'https://cn.bing.com/th?id=OHR.MarbleCanyon_ZH-CN1066862981_UHD.jpg&rf=LaDigue_1920x1200.jpg';
    // $imaUrl = 'https://www.bing.com/th?id=OHR.MarbleCanyon_ZH-CN1066862981_1920x1200.jpg&rf=LaDigue_1920x1200.jpg';
    // $imaUrl = 'https://cn.bing.com/th?id=OHR.MarbleCanyon_ZH-CN1066862981_1920x1200.jpg&rf=LaDigue_1920x1200.jpg';
    // $imaUrl = 'https://s.cn.bing.net/th?id=OHR.MarbleCanyon_ZH-CN1066862981_1920x1200.jpg&rf=LaDigue_1920x1200.jpg';


    // $imaUrl = 'https://s.cn.bing.net/th?id=OHR.GSDNPest_EN-CN4395150849_UHD.jpg&rf=LaDigue_UHD.jpg';
    // $imaUrl = 'https://www.bing.com/th?id=OHR.GSDNPest_EN-CN4395150849_UHD.jpg&rf=LaDigue_UHD.jpg';
    // $imaUrl = 'https://www.bing.com/th?id=OHR.GSDNPest_EN-CN4395150849_UHD.jpg&rf=LaDigue_UHD.jpg&pid=hp&w=3840&h=2160&rs=1&c=4';
    // $imaUrl = 'https://www.bing.com/th?id=OHR.GSDNPest_EN-CN4395150849_1920x1200.jpg&rf=LaDigue_1920x1200.jpg';
    // 

    public function make()
    {
        // return $this->startOne();
        return $this->startTwo();

    }
    public function startTwoOldUrlMake($retNum = 1)
    {
        $imageData = $this->startTwo();
        $url = $this->zhUrl;
        $urlList = parse_url($url);
        $host = $urlList['scheme'] . '://' . $urlList['host'] . '';
        $retData = $this->getRedDataTwoOldUrl($host,$imageData,$retNum);
        $this->dataToSaveJsonFile($retData);
        return $retData;
    }
    
    public function getRedDataTwoOldUrl($host,$imageData,$retNum)
    {
        $retData = [];
        foreach($imageData as $k =>$item){
            if($k >= $retNum){
                // 返回最新的几个
                break;
            }

            $enddate = $item['enddate'];
            $url = $item['url'];
            $urlbase = $item['urlbase'];
            $copyright = $item['copyright'];
            $title = $item['title'];
            /*
            // https://cn.bing.com/th?id=OHR.PianePuma_ZH-CN1482049046_UHD.jpg
            array(15) {
                ["startdate"]=>
                string(8) "20220915"
                ["fullstartdate"]=>
                string(12) "202209151600"
                ["enddate"]=>
                string(8) "20220916"
                ["url"]=>
                string(93) "/th?id=OHR.PianePuma_ZH-CN1482049046_UHD.jpg&rf=LaDigue_UHD.jpg&pid=hp&w=3840&h=2160&rs=1&c=4"
                ["urlbase"]=>
                string(36) "/th?id=OHR.PianePuma_ZH-CN1482049046"
                ["copyright"]=>
                string(95) "百内国家公园中的一头美洲狮，智利巴塔哥尼亚 (© Ingo Arndt/Minden Pictures)"
                ["copyrightlink"]=>
                string(59) "/search?q=%e7%be%8e%e6%b4%b2%e7%8b%ae&FORM=hpcapt&mkt=zh-cn"
                ["title"]=>
                string(15) "敏捷而隐秘"
                ["quiz"]=>
                string(88) "/search?q=Bing+homepage+quiz&filters=WQOskey:%22HPQuiz_20220915_PianePuma%22&FORM=HPQUIZ"
                ["wp"]=>
                bool(true)
                ["hsh"]=>
                string(32) "e26cdbfc792dcdcfc13e653a8a2ee2df"
                ["drk"]=>
                int(1)
                ["top"]=>
                int(1)
                ["bot"]=>
                int(1)
                ["hs"]=>
                array(0) {
                }
            }
            */

            $orgImageUrlBool = stripos($url,'http') === false ? false:true;
            if($orgImageUrlBool){
                $orgImageUrl = $url;
            }else{
                $orgImageUrl = $host . $url;
            }
            $orgImageBaseUrlBool = stripos($urlbase,'http') === false ? false:true;
            if($orgImageBaseUrlBool){
                $orgImageBaseUrl = $urlbase;
            }else{
                $orgImageBaseUrl = $host . $urlbase;
            }

            $urlList = parse_url($orgImageUrl);
                // var_dump($urlList);
                
            $arrQuery = $this->convertUrlQuery($urlList['query']);
            $urlId = $urlList['scheme'] . '://' . $urlList['host'] . $urlList['path'] . '?id=' . $arrQuery['id'];


            $retData[] = [
                'enddate'=>$enddate,
                'filedate'=>$this->dateFromToFormat( $enddate),
                // 'url'=>$orgImageUrl,
                'url_id'=>$urlId,
                // 'urlbase'=>$orgImageBaseUrl,
                'copyright'=>$copyright,
                'title'=>$title,
                // 'urlList'=>$urlList,
                // 'arrQuery'=>$arrQuery,
            ];






            
        }

        return $retData;
    }


    public function startTwo($num = 1)
    {
        $url = $this->zhOldUrl;
        $urlList = parse_url($url);
        $arrQuery = $this->convertUrlQuery($urlList['query']);
        $arrQuery['FORM'] = $this->getRandStr();
        $urlParams = $this->getUrlQuery($arrQuery);
        $url = $urlList['scheme'] . '://' . $urlList['host'] . '' . $urlList['path'] . '?' . $urlParams;

        $headerList = [
            'Referer'=> 'https://cn.bing.com/?FORM=' . $arrQuery['FORM'],
        ];
        $this->GetHeaderKeyFunc($headerList);

        $aHeader = [
            CURLOPT_HTTPHEADER=>$this->headerKeyArr,
        ];
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $ret = $this->getToCurl($url,$aHeader);
        if(!$ret['success'] || empty($ret['data'] )){
            sleep(4);
            $num ++;
            // var_dump('-$url-',$url);
            var_dump('-$num-',$num);
            if($num >= 7){
                return $ret;
            }
            return $this->startTwo($num);
        }
        $data = $ret['data'] ;
        return $data['images'] ;
        // return $data['tooltips'] ;

    }

// 
    /**
     * 时间格式转换
     * 根据指定格式解析时间字符串
     *  date（“Y-m-d”，strtotime("20170822")）
     * https://www.php.cn/php-ask-469262.html
     */
    public function dateFromToFormat($orgDate)
    {
        //  $dateData = \DateTime::createFromFormat('Ymd','20170822')->format('Y-m-d');
        return  \DateTime::createFromFormat('Ymd',$orgDate,new \DateTimeZone('Asia/Shanghai'))->format('Y/m/d');
    }
    /**
     * 时间格式转换
     * 根据指定格式解析时间字符串
     * 没有前导零 转成有前导零
     * 2022-9-16 ==>> 2022/09/16 这中可以转换
     * 2022916   ==>> 2029/07/06 这种转换不了  >>>>>>> 2022126
     * 2022126   ==>> 2029/07/06 这种转换不了  >>>>>>> 2022-12-6  >>>>>>> 2022-1-26
     * 
     * 设置时区 
     * https://www.php.net/manual/zh/datetime.settimezone.php
     * 
     */
    public function dateFromToYFormat($orgDate)
    {
        // 'timezone' => 'Asia/Shanghai',
        // 'timezone' => 'UTC',
        // return  \DateTime::createFromFormat('Y-n-j',$orgDate)->format('Y/m/d');
        return  \DateTime::createFromFormat('Y-n-j',$orgDate,new \DateTimeZone('Asia/Shanghai'))->format('Y/m/d');
        // return  \DateTime::createFromFormat('Ynj',$orgDate,new \DateTimeZone('Asia/Shanghai'))->format('Y/m/d');
        // return  date('Y/m/d' , strtotime($orgDate));

        // https://qastack.cn/programming/1699958/formatting-a-number-with-leading-zeros-in-php
        // $isodate = sprintf("%04d-%02d-%02d", $year, $month, $day);
    }
    /**
     * 数据保存至json文件中
     */
    public function dataToSaveJsonFile($orgDate)
    {
        $filedate = date("Y/m/d");
        foreach($orgDate as $v){
            $jsonData = json_encode($v,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            if(isset($v['filedate'])){
                $filedate = $v['filedate'];
            }
            $path = './bingImg/' . $filedate;
            $fileName = '1.json';
            
            $this->saveFile($path,$fileName ,$jsonData);
        }



    }

    public function saveFile($path,$fileName ,$jsonData ,$fileType = FILE_APPEND)
    {
        $this->mkdirDirname($path);
        file_put_contents($path . '/' . $fileName,$jsonData);
        // file_put_contents($path . '/' . $fileName,$jsonData,$fileType);
    }










    public function startOne($num = 1)
    {

        // 随机暂停时间
        $timeSleep = mt_rand(1,6);
        sleep($timeSleep);


        $url = $this->zhUrl;
        $urlList = parse_url($url);
        $arrQuery = $this->convertUrlQuery($urlList['query']);
        $arrQuery['FORM'] = $this->getRandStr();
        $urlParams = $this->getUrlQuery($arrQuery);
        $url = $urlList['scheme'] . '://' . $urlList['host'] . '' . $urlList['path'] . '?' . $urlParams;
        
        $headerList = [
            'Referer'=> 'https://cn.bing.com/?FORM=' . $arrQuery['FORM'],
        ];
        $this->GetHeaderKeyFunc($headerList);

        $aHeader = [
            CURLOPT_HTTPHEADER=>$this->headerKeyArr,
        ];
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $ret = $this->getToCurl($url,$aHeader);
        // var_dump('-$url-',$url);
        // return $ret;
        if(!$ret['success'] || empty($ret['data'])){
            sleep(6);
            $num ++;
            // var_dump('-$url-',$url);
            
            if($num >= 7){
                return $ret;
            }
            var_dump('-$num-',$num);
            var_dump('-$url-',$url);
            var_dump('-$startOne-',$ret);
            return $this->startOne($num);
        }
        return $ret;
        // $data = $ret['data'] ;
        // return $data['MediaContents'] ;
        // return $data['ClientSettings'] ;
        // return $data['HasVidEvtLog'] ;
        // return $data['MediaContents'] ;
        // return $data['LocStrings'] ;

    }

    public function startOneMake($retNum = 1)
    {


        $retData = [];
        $url = $this->zhUrl;
        $urlList = parse_url($url);
        $host = $urlList['scheme'] . '://' . $urlList['host'] . '';

        $ret = $this->startOne();
        // if(!$ret['success']){
        //     sleep(6);
        //     $ret = $this->startOne();
        // }
        if(!empty($ret['data'])){
            $data = $ret['data'] ;
            $mediaContents = $data['MediaContents'];
            // var_dump($ret);
    
            foreach($mediaContents as $k=>$v){
                if($k >= $retNum){
                    // 返回最新的几个
                    break;
                }
                $imageContent = $v['ImageContent'];
                $ssd = $v['Ssd'];
                $fullDateString = $v['FullDateString'];
                $currentDate = str_replace([' ','月'],['-',''],$fullDateString);



                // echo $currentDate . PHP_EOL;
                // 2022-9-16  2022/09/16
                $dateFile = $this->dateFromToYFormat($currentDate);
                // $dateFile = $this->dateFromToYFormat(date('Ynj'));
                // $showMsg = $currentDate . '  ' . $dateFile . '  ' . date('Ynj');
                // echo $showMsg . PHP_EOL;
                // continue;




                // $currentList = explode('-',$currentDate);

                $description = $imageContent['Description'];

                $headline = $imageContent['Headline'];
                $title = $imageContent['Title'];
                $quickFactList = $imageContent['QuickFact'];
                $imageList = $imageContent['Image'];
                $imageUrl = $imageList['Url'];
                $mainText = $quickFactList['MainText'];
                // var_dump($k,$title,$headline,$description,$imageUrl,$mainText);

                $urlList = parse_url($imageUrl);
                // var_dump($urlList);
                
                $arrQuery = $this->convertUrlQuery($urlList['query']);
                /*
                array(2) {
                    ["id"]=>
                    string(45) "OHR.KeralaIndia_ZH-CN0125201857_1920x1080.jpg"
                    ["rf"]=>
                    string(21) "LaDigue_1920x1080.jpg"
                  }
                */

                $rf = isset($arrQuery['rf']) ?$arrQuery['rf']:'';
                $rfId = isset($arrQuery['id']) ?$arrQuery['id']:'';
                $rfMake = '';
                if(!empty($rf)){
                    // _1920x1080
                    $rfMake = str_replace(['LaDigue','.jpg'],['',''],$rf);
                    $arrQuery['rf'] = str_replace($rfMake,'_UHD',$rf);


                    if(!empty($rfId)){
                        // _1920x1080
                        $arrQuery['id'] = str_replace($rfMake,'_UHD',$rfId);
                    }


                }
                // $rfId = isset($arrQuery['id']) ?$arrQuery['id']:'';
                // if(!empty($rfId)){
                //     // _1920x1080
                //     $rfId = str_replace($rfMake,'_UHD',$rfId);
                // }
                // var_dump($arrQuery);
                // $arrQuery['FORM'] = $this->getRandStr();
                $urlParams = $this->getUrlQuery($arrQuery);
                // $url = $urlList['scheme'] . '://' . $urlList['host'] . '' . $urlList['path'] . '?' . $urlParams;
                $imageHdMakeUrl = $host . $urlList['path'] . '?' . $urlParams;

                
                $orgImageUrlBool = stripos($imageUrl,'http') === false ? false:true;
                if($orgImageUrlBool){
                    $orgImageUrl = $imageUrl;
                }else{
                    $orgImageUrl = $host . $imageUrl;
                }

                // $filePath = './bingImg/' . implode('/',$currentList);
                $filePath = './bingImg/' . $dateFile;
                $this->mkdirDirname($filePath);
                $filePathRepa = realpath($filePath);

                // $filePathName = $filePathRepa . '/' .  $arrQuery['id'] ;
                $filePathName = $filePathRepa . '/' .  str_replace('.jpg','.jpeg',$arrQuery['id']);

                // $headerDownImg = [
                //     'Content-Type'=>'image/JPEG',
                // ];
                // $dataDownParams['header'] = array_merge($this->headerKeyArr,$headerDownImg);
                // $this->downCurl($imageHdMakeUrl,$filePathName,$dataDownParams);

                // 最原始 最简单
                if (file_put_contents($filePathName, file_get_contents($imageHdMakeUrl))) {
                    $retData[$k] = [
                        'imageUrl'=>$orgImageUrl,
                        'imageHdUrl'=>$imageHdMakeUrl,
                        'mainText'=>$mainText,
                        'title'=>$title,
                        'headline'=>$headline,
                        'description'=>$description,
                        'fullDateString'=>$fullDateString,
                        'ssd'=>$ssd,
                        'currentDate'=>$currentDate,
                        // 'currentList'=>$currentList,
                        'dateFile'=>$dateFile,
                        'filePathRepa'=>$filePathRepa,
                    ];
                }



                // echo PHP_EOL;
                // echo PHP_EOL;
                // echo PHP_EOL;
            }
    
        }
        return $retData;
    }
    public function mkdirDirname($filePath)
    {
        if (!is_dir($filePath)) {
            mkdir($filePath, 0755, true);
            chmod($filePath, 0755);
        }
    }


    // 获取随机数
    public function getRandStr($num = 4)
    {
        $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        // $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
        $rand_str = str_shuffle($str); // 打乱字符串
        $rands = substr($rand_str, 0, $num ); // 截取0到4字符
        return $rands;
    }


    public function convertUrlQuery($query)
    {
        
        $queryParts = explode('&', $query);
        $params = array();
        foreach ($queryParts as $param){
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }
        return $params;
    }
    /**
    * 将参数变为字符串
    */

    public function getUrlQuery($array_query){
        $tmp = array();
        foreach($array_query as $k=>$param){
            $tmp[] = $k.'='.$param;
        }
        $params = implode('&',$tmp);
        return $params;

    }
    
    public function getCookieData()
    {

        $cookieOne = $this->getRandNumStr();

        $cookieTwo = $this->getRandNumStr();
        $cookieThree = $this->getRandNumStr();
        $cookieFour = $this->getRandNumStr();
        $cookieFive = $this->getRandNumStr();
        $cookieSix = $this->getRandNumStr();
        $cookieSeven = $this->getRandNumStr();
        $cookieEight = $this->getRandNumStr();
        $cookieNine = $this->getRandNumStr();
        $cookieTen = $this->getRandNumStr();

        $cookieStrLowOne = $this->getRandStrtolowerstr();
        $cookieStrLowTwo = $this->getRandStrtolowerstr();
        $cookieStrLowThree = $this->getRandStrtolowerstr();
        $cookieStrLowFour = $this->getRandStrtolowerstr();
        $cookieStrLowFive = $this->getRandStrtolowerstr();
        $cookieStrLowSix = $this->getRandStrtolowerstr();
        $cookieStrLowSeven = $this->getRandStrtolowerstr();
        $cookieStrLowEight = $this->getRandStrtolowerstr();
        $cookieStrLowNine = $this->getRandStrtolowerstr();
        $cookieStrLowTen = $this->getRandStrtolowerstr();

        $cookieStrUpOne = $this->getRandStrtouppertr();
        $cookieStrUpTwo = $this->getRandStrtouppertr();
        $cookieStrUpThree = $this->getRandStrtouppertr();
        $cookieStrUpFour = $this->getRandStrtouppertr();
        $cookieStrUpFive = $this->getRandStrtouppertr();
        $cookieStrUpSix = $this->getRandStrtouppertr();
        $cookieStrUpSeven = $this->getRandStrtouppertr();
        $cookieStrUpEight = $this->getRandStrtouppertr();
        $cookieStrUpNine = $this->getRandStrtouppertr();
        $cookieStrUpTen = $this->getRandStrtouppertr();


        $data = 'msToken=wJxdU9KKxeoy' . $cookieOne . 'e' . $cookieTwo . 'r' . $cookieStrLowThree . 'm' . $cookieStrLowOne . '0' . $cookieStrLowFour . 'w' . $cookieStrLowTwo . 'M' . $cookieThree . '-o' . $cookieStrLowFive . '5' . $cookieStrUpOne . '_' . $cookieFour . 'w' . $cookieStrUpTwo . '_h' . $cookieStrLowFive . 'fo' . $cookieStrUpThree . 'RE' . $cookieFive . 'x' . $cookieStrLowSix . 'c' . $cookieSix . 'G' . $cookieStrUpFour . $cookieStrLowSeven . '4' . $cookieStrUpSix . 'l' . $cookieSeven . 'u' . $cookieStrUpFive . 'h' . $cookieStrLowEight . 'N' . $cookieStrUpEight . 'j' . $cookieStrUpSeven . 'mhm' . $cookieStrLowTen . 'Go' . $cookieEight . 'ZcFv' . $cookieNine . 'kRwM' . $cookieStrUpNine . 'pd' . $cookieTen . 'jl6' . $cookieStrUpTen . '-o-_aot' . $cookieStrLowNine . 'LTX2kOHB0py5E2';
        // $data = 'MUID=38CFC05D58B86BDC1B66D08E596A6A22; SRCHD=AF=NOFORM; SRCHUID=V=2&GUID=FD6D5557BE8F4C09B7B04576E437E248&dmnchg=1; PPLState=1; MUIDB=38CFC05D58B86BDC1B66D08E596A6A22; _UR=QS=0&TQS=0; ANON=A=03449C4BAE81D63957567A88FFFFFFFF&E=1b57&W=1; NAP=V=1.9&E=1afd&C=8RJeCMi4zCIMpMI4g-EDjnqx7ZS1_EWPAn36igrGgh6g96yFLn-lbw&W=1; _SS=SID=167F4164499C69D63A795373485B6854; KievRPSSecAuth=FABiBBRaTOJILtFsMkpLVWSG6AN6C/svRwNmAAAEgAAACCfsgeHrXPTJIATIwmdB6YDp/vnnKxEVLJuzXPZeID7Vk/hZzgUSkOysmOeCItstkXrTEPCMymT08tMWfrM70Km0GcCHEe+oADpsKefEH+wfQ/Tshf8KDrCfDS3yY2jRemPZNmw2BaRvDE4IHNTqCAaMhke/e4BqSpZUSx3H5YPenXQvGhtAtYwCpNN0yzLtKWV+BgsWbX4c1YwcRL14galpreIM1xEW5TvtyVNRk7CV9Ik4Y8PpPqBCj5TNsBk8K1wBk9gXmB9wqa8qpoDmevH7P/4pOZszvUbCDf3OGArTNqzSTyc5WAaSFyYeryLbBkeNuYocHQaVIv/TUHOvmxor+7QKEh3tvEuRReHbvXPZYJb9+CjPStYbmFsn9og/Uh+NCaZi0d6mljMrVyfwxvIirBqHwAKbm68SVFcLJUz5RCE5abtWWdzdcQHPVK/kTAilLKmMw7UT6utTIJXLAqCx36wiVD9xAqK58SprR/WU9wis7i8dEoKqTTkdnQOfCNRASBsC+RYJ2RltUpYSZMdUisuGDi/EWsgn8r+kSHr6wtK+7Jr/SBZblrqW1j0e6ZbgOax+eRpMQH9gzmhLiKTqivkeBz/bbblJTo77FcQm9pX7N62Ya0pIZi1CFSTKE1PM5nHlZYPGW74Fduqloa8+RKbc9PhZ1jrQ7FqwiLGj7somdbvxwJf2ayHHJfbhzDo5KOJenKXrAPxAqKPi29fvOQceRZdENr/gzNicJwuXEcij8iEnqA/Qy7tdBvIFxtKr+6EqyiMp7Pg8legdpt+vs/3M+qeLPWS/G8GEzeqPVgszNUkSKOMdszFCz8Bz+o7Q7Lg5kwpo3hgxoksBUDUmvQ+IsKJ3HSGELoyrCEOqzqwgs815oNGDQLsRvyjhGVsGB6Z67TtLIkelTNqK3fgGcNCMPXyRoLSHlfEg632IyWadXBNu7f+C5sBfPNmuszHZkNKyfdcbxtJA4YHkShDxLdVjqyRWxkE72ZW2I1ePca/cOUE+Mte+0vNnBKu+Wj0YDqODF4yJSYspw/ZeHmQTO7X4S5i/osyvxmgAvn2U2vk79COf+imBXVAaElPHv4sWc4eMfm/Qxz2WQM7fM/j2cAWHRRFar2FCl6i5N4AK1ucDO2KHUpXPwVPYjsgrVnLBG2MVN4IecdnlXNDquNp+DBMiG7b1lGNj0yyxgNTiviemeZ7h91CLpSrtOr/aaLMSRo50jZIGlN0rFV+NCoUOq7uI1bFoh+PBwm3981Sn3LmJNS2hyut0ieyLzfv29zQ79CFe0ZD2P+CYmRJegVvXpuCAX49nDymwroFIy6WjivHq8Yim/pVi4oQ9SCTX7t/yA3y19U8GvBHjMJHJaN/qAqNqtdb8zfCr1aMj9D55dFEMQq+Wy+nSbAFDBw+pqkDtyyjK+t+u8nMUAE0Rty4sBbxz/wfXttrpFqbnu8Ud; _U=1IICWYRlMekw4B2l7uGxyoVA3a9lCetHOnfjnvHCJxUSpoA_fEGSgknKU2J_kWbXfzfXrWxT9tMOJoytdf0Hj2A-z6GqJET7ouJIKJkOFGQOX4okXVZyLmogqGMtQe2nSyiWwyKvwBdI_lDDH973ghH9mSuV9bNp_dEpY0m5LGQ1ptKVTU_P7nhSNeap1eQArtdgp3J0YE6rM6tRWlM_u9Q; WLS=C=554277e8b576ad21&N=wilson; WLID=aFKZsEZoYhaojzVdeZK7js5DKEZ4aA5fEtiM38RFHN2N6lYbKWk2kmTPCyDtfP+eG+cNIYgxRy1Yermc4G8tPe7MRTayCZPOIs/aSWxvrgs=; MMCASM=ID=5E1560A45E6D49218E4D8F8A6865BB82; imgv=flts=20220906; _EDGE_S=SID=167F4164499C69D63A795373485B6854&mkt=en-us&ui=zh-cn; SUID=A; SNRHOP=I=&TS=; SRCHUSR=DOB=20220307&T=1663152076000&TPC=1663129787000&POEX=W; ipv6=hit=1663155678397&t=4; ENSEARCH=BENVER=0; _HPVN=CS=eyJQbiI6eyJDbiI6NCwiU3QiOjAsIlFzIjowLCJQcm9kIjoiUCJ9LCJTYyI6eyJDbiI6NCwiU3QiOjAsIlFzIjowLCJQcm9kIjoiSCJ9LCJReiI6eyJDbiI6NCwiU3QiOjAsIlFzIjowLCJQcm9kIjoiVCJ9LCJBcCI6dHJ1ZSwiTXV0ZSI6dHJ1ZSwiTGFkIjoiMjAyMi0wOS0xNFQwMDowMDowMFoiLCJJb3RkIjowLCJHd2IiOjAsIkRmdCI6bnVsbCwiTXZzIjowLCJGbHQiOjAsIkltcCI6MzF9; SRCHHPGUSR=SRCHLANG=zh-Hans&BRW=XW&BRH=S&CW=1639&CH=428&SW=1680&SH=1050&DPR=2&UTC=480&DM=0&WTS=63798057260&HV=1663152081&BZA=0&PV=10.14.6&PRVCW=1639&PRVCH=428';
        // $data = 'MUID=38CFC05D58B86BDC1B66D08E596A6A22; SRCHD=AF=NOFORM; SRCHUID=V=2&GUID=FD6D5557BE8F4C09B7B04576E437E248&dmnchg=1; PPLState=1; MUIDB=38CFC05D58B86BDC1B66D08E596A6A22; _UR=QS=0&TQS=0; ANON=A=03449C4BAE81D63957567A88FFFFFFFF&E=1b57&W=1; NAP=V=1.9&E=1afd&C=8RJeCMi4zCIMpMI4g-EDjnqx7ZS1_EWPAn36igrGgh6g96yFLn-lbw&W=1; _SS=SID=167F4164499C69D63A795373485B6854; KievRPSSecAuth=FABiBBRaTOJILtFsMkpLVWSG6AN6C/svRwNmAAAEgAAACCfsgeHrXPTJIATIwmdB6YDp/vnnKxEVLJuzXPZeID7Vk/hZzgUSkOysmOeCItstkXrTEPCMymT08tMWfrM70Km0GcCHEe+oADpsKefEH+wfQ/Tshf8KDrCfDS3yY2jRemPZNmw2BaRvDE4IHNTqCAaMhke/e4BqSpZUSx3H5YPenXQvGhtAtYwCpNN0yzLtKWV+BgsWbX4c1YwcRL14galpreIM1xEW5TvtyVNRk7CV9Ik4Y8PpPqBCj5TNsBk8K1wBk9gXmB9wqa8qpoDmevH7P/4pOZszvUbCDf3OGArTNqzSTyc5WAaSFyYeryLbBkeNuYocHQaVIv/TUHOvmxor+7QKEh3tvEuRReHbvXPZYJb9+CjPStYbmFsn9og/Uh+NCaZi0d6mljMrVyfwxvIirBqHwAKbm68SVFcLJUz5RCE5abtWWdzdcQHPVK/kTAilLKmMw7UT6utTIJXLAqCx36wiVD9xAqK58SprR/WU9wis7i8dEoKqTTkdnQOfCNRASBsC+RYJ2RltUpYSZMdUisuGDi/EWsgn8r+kSHr6wtK+7Jr/SBZblrqW1j0e6ZbgOax+eRpMQH9gzmhLiKTqivkeBz/bbblJTo77FcQm9pX7N62Ya0pIZi1CFSTKE1PM5nHlZYPGW74Fduqloa8+RKbc9PhZ1jrQ7FqwiLGj7somdbvxwJf2ayHHJfbhzDo5KOJenKXrAPxAqKPi29fvOQceRZdENr/gzNicJwuXEcij8iEnqA/Qy7tdBvIFxtKr+6EqyiMp7Pg8legdpt+vs/3M+qeLPWS/G8GEzeqPVgszNUkSKOMdszFCz8Bz+o7Q7Lg5kwpo3hgxoksBUDUmvQ+IsKJ3HSGELoyrCEOqzqwgs815oNGDQLsRvyjhGVsGB6Z67TtLIkelTNqK3fgGcNCMPXyRoLSHlfEg632IyWadXBNu7f+C5sBfPNmuszHZkNKyfdcbxtJA4YHkShDxLdVjqyRWxkE72ZW2I1ePca/cOUE+Mte+0vNnBKu+Wj0YDqODF4yJSYspw/ZeHmQTO7X4S5i/osyvxmgAvn2U2vk79COf+imBXVAaElPHv4sWc4eMfm/Qxz2WQM7fM/j2cAWHRRFar2FCl6i5N4AK1ucDO2KHUpXPwVPYjsgrVnLBG2MVN4IecdnlXNDquNp+DBMiG7b1lGNj0yyxgNTiviemeZ7h91CLpSrtOr/aaLMSRo50jZIGlN0rFV+NCoUOq7uI1bFoh+PBwm3981Sn3LmJNS2hyut0ieyLzfv29zQ79CFe0ZD2P+CYmRJegVvXpuCAX49nDymwroFIy6WjivHq8Yim/pVi4oQ9SCTX7t/yA3y19U8GvBHjMJHJaN/qAqNqtdb8zfCr1aMj9D55dFEMQq+Wy+nSbAFDBw+pqkDtyyjK+t+u8nMUAE0Rty4sBbxz/wfXttrpFqbnu8Ud; _U=1IICWYRlMekw4B2l7uGxyoVA3a9lCetHOnfjnvHCJxUSpoA_fEGSgknKU2J_kWbXfzfXrWxT9tMOJoytdf0Hj2A-z6GqJET7ouJIKJkOFGQOX4okXVZyLmogqGMtQe2nSyiWwyKvwBdI_lDDH973ghH9mSuV9bNp_dEpY0m5LGQ1ptKVTU_P7nhSNeap1eQArtdgp3J0YE6rM6tRWlM_u9Q; WLS=C=554277e8b576ad21&N=wilson; WLID=aFKZsEZoYhaojzVdeZK7js5DKEZ4aA5fEtiM38RFHN2N6lYbKWk2kmTPCyDtfP+eG+cNIYgxRy1Yermc4G8tPe7MRTayCZPOIs/aSWxvrgs=; MMCASM=ID=5E1560A45E6D49218E4D8F8A6865BB82; imgv=flts=20220906; _EDGE_S=SID=167F4164499C69D63A795373485B6854&mkt=en-us&ui=zh-cn; SUID=A; SNRHOP=I=&TS=; SRCHUSR=DOB=20220307&T=1663152076000&TPC=1663129787000&POEX=W; ipv6=hit=1663155678397&t=4; ENSEARCH=BENVER=0; SRCHHPGUSR=SRCHLANG=zh-Hans&BRW=XW&BRH=S&CW=1639&CH=208&SW=1680&SH=1050&DPR=2&UTC=480&DM=0&WTS=63798057260&HV=1663153916&BZA=0&PV=10.14.6&PRVCW=1639&PRVCH=208; _HPVN=CS=eyJQbiI6eyJDbiI6NCwiU3QiOjAsIlFzIjowLCJQcm9kIjoiUCJ9LCJTYyI6eyJDbiI6NCwiU3QiOjAsIlFzIjowLCJQcm9kIjoiSCJ9LCJReiI6eyJDbiI6NCwiU3QiOjAsIlFzIjowLCJQcm9kIjoiVCJ9LCJBcCI6dHJ1ZSwiTXV0ZSI6dHJ1ZSwiTGFkIjoiMjAyMi0wOS0xNFQwMDowMDowMFoiLCJJb3RkIjowLCJHd2IiOjAsIkRmdCI6bnVsbCwiTXZzIjowLCJGbHQiOjAsIkltcCI6MzV9';
        $data = 'MUID=38CFC05D58B86BDC1B66D08E596A6A22; SRCHD=AF=NOFORM; SRCHUID=V=2&GUID=FD6D5557BE8F4C09B7B04576E437E248&dmnchg=1; PPLState=1; MUIDB=38CFC05D58B86BDC1B66D08E596A6A22; _UR=QS=0&TQS=0; ANON=A=03449C4BAE81D63957567A88FFFFFFFF&E=1b57&W=1; NAP=V=1.9&E=1afd&C=8RJeCMi4zCIMpMI4g-EDjnqx7ZS1_EWPAn36igrGgh6g96yFLn-lbw&W=1; _SS=SID=167F4164499C69D63A795373485B6854; KievRPSSecAuth=FABiBBRaTOJILtFsMkpLVWSG6AN6C/svRwNmAAAEgAAACCfsgeHrXPTJIATIwmdB6YDp/vnnKxEVLJuzXPZeID7Vk/hZzgUSkOysmOeCItstkXrTEPCMymT08tMWfrM70Km0GcCHEe+oADpsKefEH+wfQ/Tshf8KDrCfDS3yY2jRemPZNmw2BaRvDE4IHNTqCAaMhke/e4BqSpZUSx3H5YPenXQvGhtAtYwCpNN0yzLtKWV+BgsWbX4c1YwcRL14galpreIM1xEW5TvtyVNRk7CV9Ik4Y8PpPqBCj5TNsBk8K1wBk9gXmB9wqa8qpoDmevH7P/4pOZszvUbCDf3OGArTNqzSTyc5WAaSFyYeryLbBkeNuYocHQaVIv/TUHOvmxor+7QKEh3tvEuRReHbvXPZYJb9+CjPStYbmFsn9og/Uh+NCaZi0d6mljMrVyfwxvIirBqHwAKbm68SVFcLJUz5RCE5abtWWdzdcQHPVK/kTAilLKmMw7UT6utTIJXLAqCx36wiVD9xAqK58SprR/WU9wis7i8dEoKqTTkdnQOfCNRASBsC+RYJ2RltUpYSZMdUisuGDi/EWsgn8r+kSHr6wtK+7Jr/SBZblrqW1j0e6ZbgOax+eRpMQH9gzmhLiKTqivkeBz/bbblJTo77FcQm9pX7N62Ya0pIZi1CFSTKE1PM5nHlZYPGW74Fduqloa8+RKbc9PhZ1jrQ7FqwiLGj7somdbvxwJf2ayHHJfbhzDo5KOJenKXrAPxAqKPi29fvOQceRZdENr/gzNicJwuXEcij8iEnqA/Qy7tdBvIFxtKr+6EqyiMp7Pg8legdpt+vs/3M+qeLPWS/G8GEzeqPVgszNUkSKOMdszFCz8Bz+o7Q7Lg5kwpo3hgxoksBUDUmvQ+IsKJ3HSGELoyrCEOqzqwgs815oNGDQLsRvyjhGVsGB6Z67TtLIkelTNqK3fgGcNCMPXyRoLSHlfEg632IyWadXBNu7f+C5sBfPNmuszHZkNKyfdcbxtJA4YHkShDxLdVjqyRWxkE72ZW2I1ePca/cOUE+Mte+0vNnBKu+Wj0YDqODF4yJSYspw/ZeHmQTO7X4S5i/osyvxmgAvn2U2vk79COf+imBXVAaElPHv4sWc4eMfm/Qxz2WQM7fM/j2cAWHRRFar2FCl6i5N4AK1ucDO2KHUpXPwVPYjsgrVnLBG2MVN4IecdnlXNDquNp+DBMiG7b1lGNj0yyxgNTiviemeZ7h91CLpSrtOr/aaLMSRo50jZIGlN0rFV+NCoUOq7uI1bFoh+PBwm3981Sn3LmJNS2hyut0ieyLzfv29zQ79CFe0ZD2P+CYmRJegVvXpuCAX49nDymwroFIy6WjivHq8Yim/pVi4oQ9SCTX7t/yA3y19U8GvBHjMJHJaN/qAqNqtdb8zfCr1aMj9D55dFEMQq+Wy+nSbAFDBw+pqkDtyyjK+t+u8nMUAE0Rty4sBbxz/wfXttrpFqbnu8Ud; _U=1IICWYRlMekw4B2l7uGxyoVA3a9lCetHOnfjnvHCJxUSpoA_fEGSgknKU2J_kWbXfzfXrWxT9tMOJoytdf0Hj2A-z6GqJET7ouJIKJkOFGQOX4okXVZyLmogqGMtQe2nSyiWwyKvwBdI_lDDH973ghH9mSuV9bNp_dEpY0m5LGQ1ptKVTU_P7nhSNeap1eQArtdgp3J0YE6rM6tRWlM_u9Q; WLS=C=554277e8b576ad21&N=wilson; WLID=aFKZsEZoYhaojzVdeZK7js5DKEZ4aA5fEtiM38RFHN2N6lYbKWk2kmTPCyDtfP+eG+cNIYgxRy1Yermc4G8tPe7MRTayCZPOIs/aSWxvrgs=; MMCASM=ID=5E1560A45E6D49218E4D8F8A6865BB82; imgv=flts=20220906; _EDGE_S=SID=167F4164499C69D63A795373485B6854&mkt=en-us&ui=zh-cn; SUID=A; SNRHOP=I=&TS=; SRCHUSR=DOB=20220307&T=1663152076000&TPC=1663129787000&POEX=W; ipv6=hit=1663155678397&t=4; ENSEARCH=BENVER=0; _HPVN=CS=eyJQbiI6eyJDbiI6NCwiU3QiOjAsIlFzIjowLCJQcm9kIjoiUCJ9LCJTYyI6eyJDbiI6NCwiU3QiOjAsIlFzIjowLCJQcm9kIjoiSCJ9LCJReiI6eyJDbiI6NCwiU3QiOjAsIlFzIjowLCJQcm9kIjoiVCJ9LCJBcCI6dHJ1ZSwiTXV0ZSI6dHJ1ZSwiTGFkIjoiMjAyMi0wOS0xNFQwMDowMDowMFoiLCJJb3RkIjowLCJHd2IiOjAsIkRmdCI6bnVsbCwiTXZzIjowLCJGbHQiOjAsIkltcCI6MzF9; SRCHHPGUSR=SRCHLANG=zh-Hans&BRW=XW&BRH=S&CW=1639&CH=428&SW=1680&SH=1050&DPR=2&UTC=480&DM=0&WTS=63798057260&HV=1663152081&BZA=0&PV=10.14.6&PRVCW=1639&PRVCH=428';
        return $data;


    }
    // 获取随机数
    private function getRandNumStr()
    {
        $str = '1234567890';
        $rand_str = str_shuffle($str); // 打乱字符串
        $rands = substr($rand_str, 0, 1); // 截取0到20字符
        return $rands;
    }
    // 获取随机数
    private function getRandStrtolowerstr()
    {
        $str = 'abcdefghijklmnopqrstuvwxyz';
        $rand_str = str_shuffle($str); // 打乱字符串
        $rands = substr($rand_str, 0, 1); // 截取0到1字符
        return $rands;
    }
    // 获取随机数
    private function getRandStrtouppertr()
    {
        $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $rand_str = str_shuffle($str); // 打乱字符串
        $rands = substr($rand_str, 0, 1); // 截取0到1字符
        return $rands;
    }

    public function GetHeaderKeyFunc($makeHeaderArr = [])
    {
        $uaObj = new UA();
        $headerArr = [
            'Accept'=>'*/*',
            'Accept-Encoding'=>'gzip, deflate',
            'Accept-Language'=>'zh-CN,zh;q=0.9',
            'Cookie'=> $this->getCookieData(),
            // 'Host'=>'www.chinamoney.com.cn',
            // 'Origin'=>'http://www.chinamoney.com.cn',
            'Referer'=>'https://cn.bing.com/?FORM=BEHPTB',
            'User-Agent'=>$uaObj->GetRandUseragent(),
            // 'X-Requested-With'=>'XMLHttpRequest',
        ];
        foreach($makeHeaderArr as $k=>$v){
            $headerArr[$k] = $v;
        }
        $this->headerKeyArr = $headerArr;
    }


    /**
     * 发送post请求
     * @param $url
     * @param $fields
     * @param array $aHeader
     * @return bool|string
     */
    public function postToCurl($url, $fields, $aHeader = array())
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_TIMEOUT, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0); // 过滤HTTP头
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);// 显示输出结果
        curl_setopt($curl, CURLOPT_POST, true); // post传输请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);// post传输数据
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (count($aHeader) >= 1) {
            foreach ($aHeader as $key => $val) {
                curl_setopt($curl, $key, $val);
            }
        }
        $responseText = curl_exec($curl);
        $this->curl_getinfo = curl_getinfo($curl,CURLINFO_HTTP_CODE);



        //传递数据记录错误信息
		if (curl_errno($curl)) {

			$curlError = curl_errno($curl) . ' ' . curl_error($curl);
			curl_close($curl);

			return array('success'=>false,'data'=>'error','msg'=>$curlError);
		}
		// 关闭cURL资源，并且释放系统资源
		curl_close($curl);
		return array('success'=>true,'data'=>json_decode($responseText,true),'msg'=>'');

    }


    /**
     * 发送get请求
     * @param $url
     * @param $fields
     * @param array $aHeader
     * @return bool|string
     */
    public function getToCurl($url, $aHeader = array())
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_TIMEOUT, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0); // 过滤HTTP头
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);// 显示输出结果
        curl_setopt($curl, CURLOPT_POST, false); // post传输请求
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (count($aHeader) >= 1) {
            foreach ($aHeader as $key => $val) {
                curl_setopt($curl, $key, $val);
            }
        }
        $responseText = curl_exec($curl);
        $this->curl_getinfo = curl_getinfo($curl,CURLINFO_HTTP_CODE);



        //传递数据记录错误信息
		if (curl_errno($curl)) {

			$curlError = curl_errno($curl) . ' ' . curl_error($curl);
			curl_close($curl);

			return array('success'=>false,'data'=>'error','msg'=>$curlError);
		}
		// 关闭cURL资源，并且释放系统资源
		curl_close($curl);
		return array('success'=>true,'data'=>json_decode($responseText,true),'msg'=>'');



    }

    public function downCurl($url,$filePath,$data=[])
    {
        // post 多线程
        // http://www.nowamagic.net/librarys/veda/detail/124
        //
        // ssl false
        // https://www.cnblogs.com/photo520/p/11548291.html
        //
        // curl
        // https://www.jb51.net/article/162391.htm
        // https://www.php.net/manual/zh/function.curl-setopt.php
        //
        //
        // 上传文件
        // https://www.cnblogs.com/duanbiaowu/p/5086653.html

        ob_start();

        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //关闭对等证书
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        //设置是否返回信息 //要求结果为字符串且输出到屏幕上  // 将 curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 0);
        //返回头部信息
        curl_setopt($curl, CURLOPT_HEADER, true);
        //需要response body 启用时将不对HTML中的BODY部分进行输出。
        curl_setopt($curl, CURLOPT_NOBODY, FALSE);
        // 启用时关闭curl传输的进度条，此项的默认设置为启用。
        //Note:
        //PHP自动地设置这个选项为TRUE，这个选项仅仅应当在以调试为目的时被改变。
        // curl_setopt($curl, CURLOPT_NOPROGRESS, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        // post
        curl_setopt($curl, CURLOPT_POST, 0);
        if(!empty($data['params'])) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data['params']);
        }
        //设置HTTP头
        if(!empty($data['header'])) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $data['header']);
        }

        //打开文件描述符
        $fp = fopen ($filePath, 'w+');
        // 写入文件
        curl_setopt($curl, CURLOPT_FILE, $fp);
        // 给到 $head 变量  https://blog.csdn.net/luolaifa000/article/details/93499144
        // curl_setopt($curl, CURLOPT_STDERR, $fp);


        //这个选项是意思是跳转，如果你访问的页面跳转到另一个页面，也会模拟访问。
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($curl,CURLOPT_TIMEOUT,50);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1000);

        //执行命令
        curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        $head = ob_get_contents();
        ob_end_clean();

        // var_dump('--$head--',$head);

        //关闭文件描述符
        fclose($fp);
    }



}



$obj = new GetImage();
// $data = $obj->make();
// var_dump($data);
# 使用新的地址进行获取数据  防抓的做的太好了 老是抓不成功
$data = $obj->startOneMake();
var_dump($data);

# 使用老的地址进行获取数据
// $data = $obj->startTwoOldUrlMake();
// var_dump($data);




/**
 * 
 * 获取必应图片
 * https://github.com/grubersjoe/bing-daily-photo/blob/main/src/BingPhoto.php
 * https://github.com/mike126126/bing
 * https://github.com/fanmingming/bing
 * 
 * https://github.com/ITJoker233/BingPicApi/blob/master/spider.py
 * https://github.com/sczhengyabin/Image-Downloader/blob/master/image_downloader_gui.py
 * 
 * https://github.com/myseil/BingWallpaper
 * 
 * https://asvow.com/bing-wallpaper/
 * 
 * 必应历史图片地址
 * https://bing.ioliu.cn
 * 
 * 
 * 我是如何白嫖 Github 服务器自动抓取每日必应壁纸的？
 * https://cloud.tencent.com/developer/article/1796625
 * 
 * 如何使用 Github Actions 自动抓取每日必应壁纸？java
 * https://www.wdbyte.com/2021/03/bing-wallpaper-github-action/
 * 
 * GitHub Actions 使用
 * https://docs.github.com/cn/actions/learn-github-actions/usage-limits-billing-and-administration
 * 
 */