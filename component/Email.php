<?
class Email
{
    /**
     *  отправка email
     * */ 
    public static function send($email, $subject, $message, $from)
    {
        $headers  = "MIME-Version: 1.0 \r\n";
        $headers .= "Content-type: text/html; charset=windows-1251 \r\n";
        $headers .= "From: liptonicetea.com.ua <".$from."> \r\n";
        $headers .= "Reply-To:".$from." \r\n";
        
        ini_set('sendmail_from',$from); 
        
        if(mail($email,"=?windows-1251?b?".base64_encode($subject)."?=",$message,$headers, $from))  
            return true;
        else 
            return false; 
    }   

}