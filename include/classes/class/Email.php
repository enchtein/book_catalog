<?php
## отправка сообщения админу
class Email {
	function sent ($mass) {
		$mail_to = 'enchtein7@gmail.com';
		$subject = 'Заказ книги';
        $message = $mass;
		$check = mail($mail_to, $subject, $message);
		if ($check!='') {
			$answer = "<h3 style='font-size: 15px; color: #009105;'>Email was sent!</h3>";
		} else {
			$answer = "<h3 style='font-size: 15px;'>Email was NOT sent!</h3>";
		}
		return $answer;
	}
}
?>