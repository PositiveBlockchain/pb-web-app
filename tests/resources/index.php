<?
/*api keyvaal*/
$key ="youareawesome";
$max = 1;
$status = 'publish';
$max = $_GET["max"];
$mode = $_GET["mode"];
$status = $_GET["status"];
$ii = 0;
if($_GET["key"]!=$key) die("nope");


define( 'PATH_TO_WORDPRESS', '../' );

$export_fields = array(
	'post_title',
	'post_date',
  'post_content',
  'ID',
  'post_author'

);

$export_query = array(
	'posts_per_page' => -1,
	'post_status' => $status,
	'post_type' => 'listing',
);


require PATH_TO_WORDPRESS . 'wp-load.php';

// Posts query
$posts = new WP_Query( $export_query );
$posts = $posts->posts;


foreach (array_slice( $posts, 0, $max) as $post ) {

	// Get post permalink
	switch ( $post->post_type ) {

		case 'revision':
		case 'nav_menu_item':
			break;
		case 'page':
			$permalink = get_page_link( $post->ID );
			break;
		case 'post':
			$permalink = get_permalink( $post->ID );
			break;
		case 'attachment':
			$permalink = get_attachment_link( $post->ID );
			break;
		default:
			$permalink = get_post_permalink( $post->ID );
			break;

	}

	// Build export array
	$post_export['permalink'] = $permalink;
	foreach ( $export_fields as $export_field ) {
		$post_export[$export_field] = strip_tags($post->$export_field);

              if ($export_field=="ID")
                {
                $sql = "SELECT *  FROM `o860n_WP377038`.`wp_377038_postmeta` WHERE (CONVERT(`post_id` USING utf8) LIKE '%".$post_export['ID']."%' AND `meta_key` = 'lp_listingpro_options_fields')";
                global $wpdb;
                 $result = $wpdb->get_results($sql);
                $result = @unserialize($result[0]->{'meta_value'});

                //$post_export[options] = $result;

                foreach((array)$result as $schluessel => $wert)
                    { // echo $schluessel;
                          $post_export[$schluessel] = $wert;
                    }
                }


	}


$post_export_array[$ii] = $post_export;
$ii = $ii +1;
}

  if ($mode=="json")
  {
		header('Content-Type: application/json');

		print_r(json_encode($post_export_array, JSON_PRETTY_PRINT, JSON_UNESCAPED_UNICODE ));
}


  if ($mode=="array") {
//    echo "<pre>";
  	print_r ($post_export_array);
}

	if ($mode=="csv")
		{
		$output_filename = 'export_' . strftime( '%Y-%m-%d' )  . '.csv';
		$output_handle = @fopen( 'php://output', 'w' );

		header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
		header( 'Content-Description: File Transfer' );
		header( 'Content-type: text/csv' );
		header( 'Content-Disposition: attachment; filename=' . $output_filename );
		header( 'Expires: 0' );
		header( 'Pragma: public' );
		fputcsv( $output_handle, $post_export_array );
		fclose( $output_handle );
		}


if ($mode=="xml")
{

            //function defination to convert array to xml
            function array_to_xml($array, &$xml_user_info) {

                foreach($array as $key => $value) {
                    if(is_array($value)) {
                        if(!is_numeric($key)){
                            $subnode = $xml_user_info->addChild("$key");
                            array_to_xml($value, $subnode);
                        }else{
                            $subnode = $xml_user_info->addChild("item$key");
                            array_to_xml($value, $subnode);
                        }
                    }else {
                        $xml_user_info->addChild("$key",htmlspecialchars("$value"));
                    }
                }
            }

            //creating object of SimpleXMLElement
            $xml_user_info = new SimpleXMLElement("<?xml version=\"1.0\"?><project_info></project_info>");

            //function call to convert array to xml
            array_to_xml($post_export_array,$xml_user_info);


            //saving generated xml file
            $xml_file = $xml_user_info->asXML('export.xml');

            //success and error message based on xml creation
            if($xml_file){
                echo 'XML file have been generated successfully: <a href="https://positiveblockchain.io/api/export.xml">export.xml</a>';
            }else{
                echo 'XML file generation error.';
            }
}

exit;
?>
