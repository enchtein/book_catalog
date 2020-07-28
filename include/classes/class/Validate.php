<?php
## Класс для проверки полей на заполненность / совпадение
class Validate
{
    public $post;
    public $session;
    
    public function __construct($post, $session) {
        $this->post = $post;
        $this->session = $session;
    }
    
    public function myEmpty() {
        if (empty($this->post)) {
            $msg = "<h3 style='font-size: 15px;'>Вы не ввели обязательный параметр</h3>";
            $this->msg = $msg;
            return $msg;
        }
    }
    
   // public function myCompare($msg, $post, $session) {
    public function myCompare() {
        if (empty($this->msg)) {
            if ($this->post == $this->session) {
                $this->msg = "<h3 style='font-size: 15px; color: #003ba8;'>Данные не изменились</h3>";
                return $this->msg;
            } else {
                $this->msg = "<h3 style='font-size: 15px; color: #009105;'>Данные обновлены</h3>";
                return $this->msg;
            }
        }
    }
}
?>