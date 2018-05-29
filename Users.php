<?php 


class Users {
    
    private $users
  
      function __construct($data){
          $this->users=$data;
      }
  
      public function findUser($email){
          $i=0;
          $user = null;
          $find = false;
          do{
              if($email==$users[$i]['email']){
                 $user=new User($i);
                 $find=true;
              }
              $i++;
          }while(!find || $i<count($this->users));
          return $user;
      }
  
      public function findCandidate($candidate){
        $i=0;
        $user = null;
        $find = false;
        $email = $candidate->get('email');
        do{
            if($email==$users[$i]['email']){
               $user=new User($users[$i]);
               $find=true;
            }
            $i++;
        }while(!$find || $i<count($this->users));
        return $user;
    }

      public function findByToken($token){
  
      }
      public function resetAuth()
      {
          # code...
      }
  
     public function set($property,$value){
          $this->$property=$value;
     } 
     public function get($property){
          return $this->$property;
      } 
  
  }   
  
  
  
?>