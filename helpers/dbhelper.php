<?php
class format
{
    public function formatDate($date)
    {
        return date('d/m/Y, H:i', strtotime($date));;
    }
    // chua doan text ngan, giup website chuan seo
    public function textShorten($text, $limit = 400)
    {
        $text = $text . " ";
        $text = substr($text, 0, $limit);
        $text = substr($text, 0, strrpos($text, ' '));
        $text = $text . '';
        return $text;
    }
    //kiem tra form co trong hay ko
    //kiểm tra xem các biến có hợp lệ hay không
    public function validation($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    //kiem tra ten cua server
    public function title()
    {
        $path = $_SERVER['SCRIPT_FILENAME'];
        $title = basename($path, '.php');
        if ($title == 'index') {
            $title = 'home';
        } elseif ($title == 'contact') {
            $title = 'contact';
        }
        return $title = ucfirst($title);
    }
    //định dạng tiền
    public function format_currency($n = 0)
    {
        $n = (string)$n;
        $n = strrev($n);
        $res = '';
        for ($i = 0; $i < strlen($n); $i++) {
            if ($i % 3 == 0 && $i != 0) {
                $res .= '.';
            }
            $res .= $n[$i];
        }
        $res = strrev($res);
        return $res;
    }
}
