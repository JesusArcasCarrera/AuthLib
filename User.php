<?php
class User {
    
    private $user_id;
    private $email;
    private $password;
    private $ip_address;
    private $ip_location;
    private $ip_address_list;
    private $ip_location_list;
    private $token;
    private $social_service;
    private $social_token;
    private $isLoged;
    private $changesCount;

    function __construct($data){
            $this->user_id = $data["user_id"];
            $this->email = $data["email"];
            $this->password = $data["password"];
            $this->ip_address = $data["ip_address"];
            $this->ip_location = $data["ip_location"];
            $this->token = $data["token"];
            $this->social_service = $data["social_service"];
            $this->social_token = $data["social_token"];
        
            // foreach ($data as $key => $value) {
            //     $this->$key = $value;
            // }
    }

    public function match($candidate){
        $is=false;
        if($this->email==$candidate->get('email') && $this->password==$candidate->get('password')){
            $is=true;
        }
        return $is;
    }

   public function set($property,$value){
        $this->$property=$value;
   } 
   public function get($property){
        return $this->$property;
    } 
    public function changeIp($ip)
    {
        $this->set('ip_address',$ip);
        $this->set('changesCount',$this->get('changesCount')+1);
        return $this->get('changesCount');
        
    }
    public function resetAuth() 
    {
        $this->set("isLoged",false);
        $this->set("token","");
        //TODO SAVE DATA LIKE DATE
        $user->set("ip_address_list",$this->array_push(get("ip_address_list"),$this->get("ip_address")));
        $user->set("ip_location_list",,$this->array_push(get("ip_location_list"),$this->get("ip_location"))):
        $user->set("ip_address",""));
        $user->set("ip_location",""):

    }
}   


?>