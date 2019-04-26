<?php
class Noctuce_CRM_AdminElement
{
    private $table_name;

    private $_version;

    function __construct()
    {
        $table_name = $wpdb->prefix . "noctuce_crm_admin_element";
    }

    public static function validateTable()
    {
        $charset_collate = $wpdb->get_charset_collate();

        if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            $sql = "
            CREATE TABLE " . $table_name . " (
                id      INT PRIMARY KEY AUTO_INCREMENT,
                name    VARCHAR(256) NOT NULL,
                value   VARCHAR(256)
            ) " . $charset_collate . ";";
        
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
    
            $welcome_name = 'Mr. WordPress';
            $welcome_text = 'Congratulations, you just completed the installation!';
    
            $table_name = $wpdb->prefix . 'liveshoutbox';
    
            $wpdb->insert( 
                $table_name, 
                array( 
                    'time' => current_time( 'mysql' ), 
                    'name' => $welcome_name, 
                    'text' => $welcome_text, 
                ) 
            );
        }
    }

    function createTable()
    {        
    }
}