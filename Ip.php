<?php 

public function isInLocation($user) 
{
    $ip=getIp();
    $ipLocation=getIpLocation();

    if($ip==$user->get('ip_address') && $ipLocation==$user->get('ip_location')){
        return true;
    }else if($ip!=$user->get('ip_address') && $ipLocation==$user->get('ip_location')){
        if($user->changeIp($ip)<5){
            return true;
        }else{
            return false;
        }

    }else{
        return false;
    }
        
    
}

public function getIp()
{
    # code...
}
public function getIpLocation()
{
    # code...
}

?>