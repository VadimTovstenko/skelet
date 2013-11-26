<?
class Social 
{
    private $twitter;
    
    private function init_twitter()
    {
        $settings = array(
            'oauth_access_token' => TWITTER_OAUTH_ACCESS_TOKEN,
            'oauth_access_token_secret' => TWITTER_OAUTH_ACCESS_TOKEN_SECRET,
            'consumer_key' => TWITTER_CONSUMER_KEY,
            'consumer_secret' => TWITTER_CONSUMER_SECRET
        );
        $this->twitter = new TwitterAPIExchange($settings);
    }
    
    
    /**
     * Получение всех фотографий по хеш-тегу
     * twitter
     * */
    public function get_tw_images_by_tag($tag,$count = 500)
    {
        $this->init_twitter();
        
        $url = 'https://api.twitter.com/1.1/search/tweets.json';    
        $requestMethod = 'GET';
        $getfield = "?q=#$tag+filter:images&count=$count";
        
        $data = $this->twitter
                     ->setGetfield($getfield)
                     ->buildOauth($url, $requestMethod)
                     ->performRequest();
                     
        $data  = json_decode($data,true);
        if($data)
            return $data;
        return false;
    }
    
    
    /**
     * Получение своих фотографий по ID
     * twitter
     * */
    public function get_tw_images_by_id($id,$token=null)
    {
        $count = 500;
        
        $this->init_twitter();
        
        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';    
        $requestMethod = 'GET';
        $getfield = "?user_id=$id&count=$count";
        
        $data = $this->twitter
                     ->setGetfield($getfield)
                     ->buildOauth($url, $requestMethod)
                     ->performRequest();
                     
        $data  = json_decode($data,true);
        
        $images = array();
        
        if($data)
            foreach($data as $item)
                if(isset($item['entities']['media']) && is_hash_tag($item['entities']['hashtags'],TAG))
                    foreach($item['entities']['media'] as $img)
                        $images[$img['id']] = $img['media_url'];
            
            return $images;
        return false;
    }

    
    
    /**
     * Получение фотографий пользователя по ID
     * twitter
     * */
    public function get_in_images_by_id($id, $token)
    {
        if($id)
        {
            $url = "https://api.instagram.com/v1/users/$id/media/recent?access_token=$token";
        
            $data = file_get_contents($url); 
            $data = json_decode($data,true);
            
            if($data)
            {
                $images = array();
                foreach($data['data'] as $img)
                    if(in_array(TAG, $img['tags']))
                        $images[$img['id']] = $img['images']['standard_resolution']['url'];
            
                return $images;
            }
            else return false;
        }
        else return false;       
    }
    
    /**
     * Получение фотографий пользователя по ID
     * vkontakte
     * */
    public function get_vk_images_by_id($id, $token)
    {
        if($id)
        {
            $url = "https://api.vk.com/method/photos.getAll?owner_id=".$id."&count=100&access_token=".$token;
        
            $data = file_get_contents($url); 
            $data = json_decode($data,true);

            if(isset($data['response']))
            {
                $images = array();
                foreach($data['response'] as $img)
                    if($img['text'] == "#".TAG)
                        $images[$img['pid']] = $img['src_big'];
            
                return $images;
            }
            else return false;
        }
        else return false;       
    }
    
    /**
     * Получение фотографий пользователей 
     * facebook
     * */
    public function get_fb_images_by_id($id,$token)
    {
        $url = "https://graph.facebook.com/".$id."/albums?access_token=".$token;
        
        $data   = file_get_contents($url); 
        $albums = json_decode($data,true);
        
        $app = new App;
            
        if($albums['data'])
        {
            $images = array();
            foreach($albums['data'] as $album)
            {
                $url = "https://graph.facebook.com/".$album['id']."/photos?limit=500&access_token=".$token;
                $data   = file_get_contents($url); 
                $photos = json_decode($data,true);
            
                foreach($photos['data'] as $photo)
                    if(!empty($photo['name']) && strpos($photo['name'],'#'.TAG) !== false)
                        $images[$photo['id']] = $photo['source'];
            }
            return $images;
        }
        else return false;     
    }
    
    
    /**
     * Получение фотографий  пользователя 
     * facebook
     * */
    public function get_fb_images_user($id,$token)
    {
        $app = new App;
        $albums = $app->facebook->api('/me/albums');
        
        if($albums['data'])
        {
            $images = array();
            foreach($albums['data'] as $album)
            {
                $photos = $app->facebook->api("/".$album['id']."/photos"); 
                foreach($photos['data'] as $photo)
                    if(!empty($photo['name']) && strpos($photo['name'],'#'.TAG) !== false)
                        $images[$photo['id']] = $photo['source'];
            }
            return $images;
        }
        else return false;     
    }
}
?>