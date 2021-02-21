<?php
namespace App\Traits;

trait GeneralTrait
{
    public function sendResponse($code, $msg = null, $data = null) {
        if($code != null and trim($code) != "")
        {
            switch ($code)
            {
                case 200:
                    $msg = ($msg != null)? $msg:"Request Successful";
                    break;
                case 400:
                    $msg = ($msg != null)? $msg:"Bad Request";
                    break;
                case 500:
                    $msg = ($msg != null)? $msg:"Request Failed";
                    break;
                default:
                    $msg = "Unknown Request";
            }
            $data = ($data != null)? $data:[];
            $resp = ["code" => $code, "message" => $msg, "data" => $data];
            return $resp;
        }
    }


    public function _get_video_attributes($video, $ffmpeg) {

        $command = $ffmpeg . ' -i ' . $video . ' -vstats 2>&1';
        $output = shell_exec($command);

//        $regex_sizes = "/Video: ([^,]*), ([^,]*), ([0-9]{1,4})x([0-9]{1,4})/"; // or : $regex_sizes = "/Video: ([^\r\n]*), ([^,]*), ([0-9]{1,4})x([0-9]{1,4})/"; (code from @1owk3y)
//        if (preg_match($regex_sizes, $output, $regs)) {
//            $codec = $regs [1] ? $regs [1] : null;
//            $width = $regs [3] ? $regs [3] : null;
//            $height = $regs [4] ? $regs [4] : null;
//        }

        $regex_duration = "/Duration: ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2}).([0-9]{1,2})/";
        if (preg_match($regex_duration, $output, $regs)) {
            $hours = $regs [1] ? $regs [1] : null;
            $mins = $regs [2] ? $regs [2] : null;
            $secs = $regs [3] ? $regs [3] : null;
            $ms = $regs [4] ? $regs [4] : null;
        }

        return array(//'codec' => $codec,
//            'width' => $width,
//            'height' => $height,
            'hours' => $hours,
            'mins' => $mins,
            'secs' => $secs,
            'ms' => $ms
        );
    }

    public function _human_filesize($bytes, $decimals = 2) {
        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
    }
}
