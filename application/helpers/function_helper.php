<?php
//Dynamically add Javascript files to header page
if(!function_exists('add_js')){
    function add_js($file='')
    {
        $str = '';
        $ci = &get_instance();
        $header_js  = $ci->config->item('header_js');
        if(empty($file)){
            return;
        }
        if(is_array($file)){
            if(!is_array($file) && count($file) <= 0){
                return;
            }
            foreach($file AS $item){
                $header_js[] = $item;
            }
            $ci->config->set_item('header_js',$header_js);

        }else{
            $str = $file;
            $header_js[] = $str;
            //echo $file;
            $ci->config->set_item('header_js',$header_js);
        }
    }
}
//Dynamically add CSS files to header page
if(!function_exists('add_css')){
    function add_css($file='')
    {
        $str = '';
        $ci = &get_instance();
        $header_css = $ci->config->item('header_css');
        if(empty($file)){
            return;
        }
        if(is_array($file)){
            if(!is_array($file) && count($file) <= 0){
                return;
            }
            foreach($file AS $item){
                $header_css[] = $item;
            }
            $ci->config->set_item('header_css',$header_css);
        }else{
            $str = $file;
            $header_css[] = $str;
            $ci->config->set_item('header_css',$header_css);
        }
    }
}
//Putting our CSS and JS files together
if(!function_exists('put_headers')){
    function put_headers($type='')
    {
        $str = '';
        $ci = &get_instance();
        $header_css = $ci->config->item('header_css');
        $header_js  = $ci->config->item('header_js');
        foreach($header_css AS $item){
            $str .= '<link rel="stylesheet" href="'.base_url().'public/css/'.$item.'" type="text/css" />'."\n";
        }
        foreach($header_js AS $item){
            $str .= '<script type="text/javascript" src="'.base_url().'public/js/'.$item.'"></script>'."\n";
        }
        return $str;
    }
}    



if(!function_exists('add_footer_js')){
    function add_footer_js($file='')
    {
        $str = '';
        $ci = &get_instance();
        $footer_js  = $ci->config->item('footer_js');
        if(empty($file)){
            return;
        }
        if(is_array($file)){
            if(!is_array($file) && count($file) <= 0){
                return;
            }
            foreach($file AS $item){
                $footer_js[] = $item;
            }
            $ci->config->set_item('footer_js',$footer_js);

        }else{
            $str = $file;
            $footer_js[] = $str;
            //echo $file;
            $ci->config->set_item('footer_js',$footer_js);
        }
    }
}



if(!function_exists('put_footer_js')){
    function put_footer_js()
    {
        $v = time();
        $str = '';
        $ci = &get_instance();
        
        $js  = $ci->config->item('footer_js');
        
        foreach($js AS $item){
            $str .= '<script type="text/javascript" src="'.base_url().'public/js/'.$item.'?v='.$v.'"></script>'."\n";
        }
        return $str;
    }
}    