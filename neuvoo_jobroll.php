<?php 

    /* 
    Plugin Name: Neuvoo Jobroll
    Plugin URI: http://www.neuvoo.ca
    Description: Plugin for displaying job offers
    Author: Neuvoo
    Version: 1.3
    Author URI: http://www.neuvoo.ca
    */
    
    function neuvoojobroll_getjobs() {  

        $numberofjobs = get_option('neuvoojobroll_numberofjobssidebar');
        $defaultkeywords = get_option('neuvoojobroll_defaultkeywords');  
        $defaultlocation = get_option('neuvoojobroll_defaultlocation');
        
        echo "<h3 class='widget-title'>Jobroll</h3>";
        
        $arg['revenue'] = get_option('neuvoojobroll_revenue_option');  
        $arg['what'] = urlencode($defaultkeywords);
        $arg['where'] = urlencode($defaultlocation);
        $arg['numjobs'] = urlencode($numberofjobs);
        $arg['resulttype'] = 'widget';
        $arg['partnerid'] = urlencode($partnerid);
        
        $url = 'http://www.neuvoo.ca/api-search/jobroll/call-jobroll.php?'.http_build_query($arg);
        echo file_get_contents($url);
  
    }
    
    function neuvoo_jobroll_admin() {  
        include('neuvoo_jobroll_admin.php');  
    }
    
    function neuvoo_admin_actions() {  
        add_options_page("Neuvoo Jobroll", "Neuvoo Jobroll", 1, "NeuvooJobroll", "neuvoo_jobroll_admin");  
    }
    
    function neuvoo_jobroll_func( $atts ){
        
        $numberofjobs = get_option('neuvoojobroll_numberofjobspage');
        $keywords = get_option('neuvoojobroll_defaultkeywords');  
        $location = get_option('neuvoojobroll_defaultlocation');  
        $looknfeel = get_option('neuvoojobroll_looknfeel');  
        $revenue = get_option('neuvoojobroll_revenue_option');  
        $partnerid = get_option('neuvoojobroll_partnerid');  
        $language = get_option('neuvoojobroll_language');  
        $defaultsort = get_option('neuvoojobroll_defaultsort');  
        
        $keywords = (isset($_GET['what']) && ($_GET['what']!='')) ? urldecode($_GET['what']) : $keywords;
        $location = (isset($_GET['where']) && ($_GET['where']!='')) ? urldecode($_GET['where']) : $location;
        
        if ($_GET['sort']=='date') $sort = 'selected';
        
        $arg['what'] = urlencode($keywords);
        $arg['where'] = urlencode($location);
        $arg['numjobs'] = urlencode($numberofjobs);
        $arg['resulttype'] = 'page';
        $arg['jobroll_page'] = urlencode($_GET['jobroll_page']);
        $arg['revenue'] = urlencode($revenue);
        $arg['partnerid'] = urlencode($partnerid);
        $arg['looknfeel'] = urlencode($looknfeel);
        $arg['sort'] = urlencode($_GET['sort']);
        $arg['defaultsort'] = $defaultsort;
        $arg['language'] = $language;
        
        $url = 'http://www.neuvoo.ca/api-search/jobroll/call-jobroll.php?'.http_build_query($arg);
        $jobroll_results = file_get_contents($url);
        
        return $jobroll_results;
        //return $url;
        
    }
    
    add_shortcode( 'neuvoo_jobroll', 'neuvoo_jobroll_func' );
    add_action('admin_menu', 'neuvoo_admin_actions');
    
    ?>
