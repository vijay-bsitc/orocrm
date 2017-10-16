<?php 
namespace Andre\Thelittlefoxesclub\ContactBundle\Controller;

trait CommandLineConfig 
{
    public static $USERNAME = "shanky";
    public static $API_KEY = '1450d751a7f24b06f0d02bf82488ba30b1745cd1';
    public static $API_URL = 'http://orocrm2.example.com/app_dev.php';
    public static $PASSWORD = 'Shanky123!';

    public static $CHILDREN = array("CRON_TIMESTAMP"=>"5 0 * * *",
                                    "CRON_ACTIVE"=>false,
                                    "API_URL"=>'http://sun286/littlefoxesclub/index.php/bsitcoro/index/getallchildren',
                                    ""
                                    );
    

}