<?php

namespace AuthLib\auth;

class Auth {
  

    function authenticate($candidate){
       
        $user;

        if(is_a($users,'Users')){
            $user=$users->findUser($candidate);
        }else if(is_a($users,'User')){
            $user=$users;
        }else{
            echo "Exception";
            exit;
        }

        if($user->match($candidate)){
            #If isAuth
            setUserTokenForLogin($user);
        }

       
        
        return $user;
    }

    public function authURL($service)
    {
        $httpClient = new \SocialConnect\Common\Http\Client\Curl();
        $providerName = '';
        $redirectUri="";
        switch ($service) {
            case 'fb':
            $providerName = 'facebook';
                $configureProviders = [
                    'redirectUri' => $redirectUri.'/fb',
                    'provider' => [
                        'facebook' => [
                            'applicationId' => '',
                            'applicationSecret' => '',
                            'scope' => [
                                'email'
                            ],
                            'fields' => [
                                'email'
                            ]
                        ],
                    ]
                ];
    
                break;
                case 'g':
                $providerName = 'google';
                $configureProviders = [
                    'redirectUri' => $redirectUri.'/cb',
                    'provider' => [
                        'google' => [
                            'applicationId' => '',
                            'applicationSecret' => '',
                            'scope' => [
                                'email'
                            ],
                            'fields' => [
                                'email'
                            ]
                        ],
                    ]
                ];
    
                break;
            
            default:
               header("/auth");
            break;
        }
    
    
        $service = new \SocialConnect\Auth\Service(
            $httpClient,
            new \SocialConnect\Provider\Session\Session(),
            $configureProviders
        );
    
    
        $provider = $service->getProvider($providerName);
        header('Location: ' . $provider->makeAuthUrl());  
    
    }
    public function socialAuth($users,$data)
    {
        //PROBABLY SHOULD BE A CONTROLLER
        $candidate=new Candidate([
            "email"=>$email,
            "social_token"=>$social_token,
            "social_service"=>$service
        ]);
        
        
        $user=$users->findCandidate($candidate);

        //SHOULD SEND A REQUEST TO SOCIAL SERVICE FOR SECURITY

        setUserTokenForLogin($user);

    }

    


    public function isAuth($token)
    {
        $users=$this->getSource()->getUsers();
        
        $user=$users->findByToken($token);

        if($this->recoveryId($token)==$user->get('user_id')){
            return true;
        }else{
            return false;
        }
    }

    private function setUserTokenForLogin($user)
{
    if($user->get('token')!=""){
        $user->set("token",generateToken($user->get("user_id")));
        $user->set("ip_address",getIp());
        $user->set("ip_location",getIpLocation());
        $user->set("isLoged",true);)
        
        
    }else{
        if(access($user)){
            header("Location: index");
        }
    }
}

 


    public function access($user) 
    {
        #LIST AUTH DEVICE BY EMAIL NOTIFICATION
        if($this->isAuth($user->get('token')) && $this->havePermission($user)){
            if($this->isInLocation($user)){
                $user->set('token',generateToken($user->get('user_id')));

                return true;
            }else{
            $user->resetAuth();
            header("Location: loginPage");
            }
            
        }else{
            header("Location: loginPage");
        }   
    }

     
    public function havePermission()
    {
        return true;
    }
    public function generateToken($id)
    {
        $token=$id+$key;
        return base64_encode($token);
    } 
    public function recoveryId($token)
    {   
       $id = decodeToken($token)
       return $id;
    }
     public function decodeToken($token)
    {
        return base64_decode($token);
    }
    

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
}

