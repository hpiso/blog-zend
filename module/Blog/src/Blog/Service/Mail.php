<?php
/**
 * Created by PhpStorm.
 * User: hpiso
 * Date: 04/02/16
 * Time: 20:07
 */

namespace Blog\Service;

use Zend\Mail\Message;
use Zend\Mail\Transport;

class Mail
{
    const EMAIL_ADMIN = 'blog-admin@mail.com';

    public function sendMail($from, $name, $message)
    {
        $mail = new Message();
        $mail->setBody($message);
        $mail->setFrom($from, $name);
        $mail->setTo(self::EMAIL_ADMIN, 'Their name');
        $mail->setSubject('Test Subject');

        //Todo config le smtp
//        $transport = new Transport\Sendmail();
//        $transport->send($mail);
    }

}