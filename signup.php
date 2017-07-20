<?php

class SignUp
{
  const SECRET_KEY = '6LfTgykUAAAAAJac5o5KmOQUNGz0v7DM3rhj1qch';

  var $error;
  var $_post;

  function validationCapcha(){
      $captcha = $this->_post['g-recaptcha-response'];
      if (!$captcha) {
          $this->error = 'Capcha not found';
          return false;
      } else {
          $secretKey = self::SECRET_KEY;
          $ip = $_SERVER['REMOTE_ADDR'];
          $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha . "&remoteip=" . $ip);
          $responseKeys = json_decode($response, true);
          if (intval($responseKeys["success"]) !== 1) {
              $this->error = "You are spammer ! Get the @$%K out";
              return false;
          } else {
              $this->error = "";
              return true;
          }
      }
      return true;
  }

  function validationName()
  {
      return true;
  }

  function validation(){
      $result = $this->validationCapcha();
      if (!$result){
          return false;
      }

      $result = $this->validationName();
      if (!$result){
          return false;
      }

      return true;
  }

  function setPost($post)
  {
      $this->_post = $post;
  }

}
