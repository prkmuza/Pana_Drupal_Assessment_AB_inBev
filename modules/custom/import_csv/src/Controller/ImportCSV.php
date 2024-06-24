<?php

namespace Drupal\import_csv\Controller; 

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\Response;

class ImportCSV extends ControllerBase {
	
	public function view() {


        return [
			'#theme' => 'import-csv'
		];


	}

	public function process() {

		$current_path_core_dir=dirname(__FILE__)."/" ;

            if(file_exists( $current_path_core_dir )){
                $t=time();	
		        $targetImportFileName=$t.basename($_FILES["SelectFile"]["name"]);
		        $targetImportFileName = str_replace(' ', '', $targetImportFileName);
		        $targetImportFileName = str_replace('/', '', $targetImportFileName);
		        $targetImportFileName = str_replace('?', '', $targetImportFileName);
		        $targetImportFileName = str_replace('&', '', $targetImportFileName);
		        $targetImportFileName = str_replace('\'', '', $targetImportFileName);
		        $targetImport_file = $current_path_core_dir . $targetImportFileName;   
		        move_uploaded_file($_FILES["SelectFile"]["tmp_name"], $targetImport_file);

				// Count the number of lines (rows) in the array
				$filelines = file($current_path_core_dir . $targetImportFileName);
				$filenum_lines = count($filelines);
				$filenum_lines = $filenum_lines-1;
				

              echo '<b>Draft Mode('.$filenum_lines.' products found)</b>: Are you sure you want to import these CSV results?</br>

              	<div >
              	 <div style="color: #000; padding: 10px; border: solid 1px #000; cursor: pointer;float:left;margin-right:5px;" class="pure-material-button-contained" onclick="SaveProcess();">
	                 Yes
	             </div>
              	 <div style="color: #000; padding: 10px; border: solid 1px #000; cursor: pointer;float:left;" class="pure-material-button-contained" onclick="DeleteDraft();">
	                 No
	             </div>
	             <div style="clear:both;"></div>
              	</div>

              	</br>

              	<div style="border-top:solid 1px #000;border-bottom:solid 1px #000;">
              	 <div style="color: #000; padding: 10px; border-right: solid 1px #000; float:left;width:110px;"  >
	                 product_id
	             </div>
              	 <div style="color: #000; padding: 10px; border-right: solid 1px #000;float:left;width:160px;"  >
	                 title
	             </div>
              	 <div style="color: #000; padding: 10px; border-right: solid 1px #000; float:left;width:190px;"  >
	                 description
	             </div>
              	 <div style="color: #000; padding: 10px; cursor: pointer;float:left;width:110px;"  >
	                 price
	             </div>
	             <div style="clear:both;"></div>
              	</div>

              ';

              $LineCounter=0;
              $Inputstring ='';
              $file = fopen($current_path_core_dir . $targetImportFileName,"r");
				while (($data = fgetcsv($file)) !== FALSE)
				{

	              if(empty( $data[0] )){  $data[0]='0';}
	              if(empty( $data[1] )){  $data[1]='_noTitleAdded';}
	              if(empty( $data[2] )){  $data[2]='_noDescriptionAdded';}
	              if(empty( $data[3] )){  $data[3]='0';}

					if($LineCounter>0){
						echo '
						  	<div>
						  	 <div style="color: #000; padding: 10px; border-right: solid 1px #000; float:left;width:110px;"  >
						         '.$data[0].'
						     </div>
						  	 <div style="color: #000; padding: 10px; border-right: solid 1px #000;float:left;width:160px;"  >
						         '.$data[1].'
						     </div>
						  	 <div style="color: #000; padding: 10px; border-right: solid 1px #000; float:left;width:190px;"  >
						         '.$data[2].'
						     </div>
						  	 <div style="color: #000; padding: 10px; cursor: pointer;float:left;width:110px;"  >
						         '.$data[3].'
						     </div>
						     <div style="clear:both;"></div>
						  	</div>
						';
                      $InputstringSub = $data[0].','.$data[1].','.$data[2].','.$data[3].'__x__';
                      $Inputstring = $Inputstring.$InputstringSub;
					}

				    $LineCounter++;
				}

				echo'
                  <form  action=""  id="UploadDraftFormSub" name="UploadDraftFormSub" method="POST" enctype="multipart/form-data"> 
                    <input type="hidden" id="UploadDraftContentSub" name="UploadDraftContentSub" value="'.$Inputstring.'" >
                    <input type="hidden" id="csvFilePathSub" name="csvFilePathSub" value="'.$targetImport_file.'" >
                  </form>
				';



            }

		exit();

	}

	public function saveprocess() {

     $t=time();

		$UploadDraftContent = $_POST['UploadDraftContent'];
		$LinesArray =explode("__x__",$UploadDraftContent);

		foreach($LinesArray as $CsvLine){

			if(!(empty($CsvLine))){

			   $CsvLineItems =explode(",",$CsvLine);	

			//generate uuid
			  $datauuid = random_bytes(16);
			  $datauuid[6] = chr(ord($datauuid[6]) & 0x0f | 0x40); // set version to 0100
			  $datauuid[8] = chr(ord($datauuid[8]) & 0x3f | 0x80); // set bits 6-7 to 10
			  $datauuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($datauuid), 4));

              //create Node
	    	  $Nodedata = [ 'type' => 'drupal_product','uuid' => $datauuid, 'langcode' => 'en', ];
		      $Nodequery = \Drupal::database()->insert('node')
		          ->fields(['type', 'uuid', 'langcode'])
		          ->values($Nodedata)
		          ->execute();
		      $Nodeid = \Drupal::database()->lastInsertId('node', 'nid');
		      $Node_update_query = \Drupal::database()->update('node')
		       ->fields(['vid' => $Nodeid])->condition('nid', $Nodeid)->execute();

              if(empty( $CsvLineItems[1] )){  $CsvLineItems[1]='_noTitleAdded';}
              //create node_field_data
	    	  $node_field_data = [ 
	    	   'nid' => $Nodeid,
	    	   'vid' => $Nodeid,
	    	   'type' => 'drupal_product',
	    	   'langcode' => 'en',
	    	   'status' => 1,
	    	   'uid' => 1,
	    	   'title' => $CsvLineItems[1],
	    	   'created' => $t,
	    	   'changed' => $t,
	    	   'promote' => 1,
	    	   'sticky' => 0,
	    	   'default_langcode' => 1,
	    	   'revision_translation_affected' => 1,
	    	  ];
		      $node_field_data_query = \Drupal::database()->insert('node_field_data')
		          ->fields(['nid','vid','type','langcode','status','uid','title','created','changed','promote','sticky','default_langcode','revision_translation_affected'])
		          ->values($node_field_data)
		          ->execute();

              //create node_field_revision
	    	  $node_field_revision = [ 
	    	   'nid' => $Nodeid,
	    	   'vid' => $Nodeid,
	    	   'langcode' => 'en',
	    	   'status' => 1,
	    	   'uid' => 1,
	    	   'title' => $CsvLineItems[1],
	    	   'created' => $t,
	    	   'changed' => $t,
	    	   'promote' => 1,
	    	   'sticky' => 0,
	    	   'default_langcode' => 1,
	    	   'revision_translation_affected' => 1,
	    	  ];
		      $node_field_revision_query = \Drupal::database()->insert('node_field_revision')
		          ->fields(['nid','vid','langcode','status','uid','title','created','changed','promote','sticky','default_langcode','revision_translation_affected'])
		          ->values($node_field_revision)
		          ->execute();
              

              //create node_revision
	    	  $node_revision_data = [ 
	    	    'nid' => $Nodeid,
	    	    'vid' => $Nodeid,
	    	    'langcode' => 'en',
	    	  	'revision_uid' => 1,
	    	    'revision_timestamp' => $t, 
	    	    'revision_default' => 1, 
	    	 ];
		      $node_revision_query = \Drupal::database()->insert('node_revision')
		          ->fields(['nid','vid','langcode','revision_uid','revision_timestamp','revision_default'])
		          ->values($node_revision_data)
		          ->execute();

              //create node_revision__field_title
	    	  $node_revision__field_title_data = [ 
	    	    'bundle' => 'drupal_product',
	    	    'deleted' => 0,
	    	    'entity_id' => $Nodeid,
	    	  	'revision_id' => $Nodeid,
	    	    'langcode' => 'en',
	    	    'delta' => 1, 
	    	    'field_title_value' => $CsvLineItems[1], 
	    	 ];
		      $node_revision__field_title_query = \Drupal::database()->insert('node_revision__field_title')
		          ->fields(['bundle','deleted','entity_id','revision_id','langcode','delta','field_title_value'])
		          ->values($node_revision__field_title_data)
		          ->execute();

              //create node__field_title
	    	  $node__field_title_data = [ 
	    	    'bundle' => 'drupal_product',
	    	    'deleted' => 0,
	    	    'entity_id' => $Nodeid,
	    	  	'revision_id' => $Nodeid,
	    	    'langcode' => 'en',
	    	    'delta' => 1, 
	    	    'field_title_value' => $CsvLineItems[1], 
	    	 ];
		      $node__field_title_query = \Drupal::database()->insert('node__field_title')
		          ->fields(['bundle','deleted','entity_id','revision_id','langcode','delta','field_title_value'])
		          ->values($node__field_title_data)
		          ->execute();

              if(empty( $CsvLineItems[0] )){  $CsvLineItems[0]=0;}
              //create node_revision__field_product_id
	    	  $node_revision__field_product_id_data = [ 
	    	    'bundle' => 'drupal_product',
	    	    'deleted' => 0,
	    	    'entity_id' => $Nodeid,
	    	  	'revision_id' => $Nodeid,
	    	    'langcode' => 'en',
	    	    'delta' => 1, 
	    	    'field_product_id_value' => $CsvLineItems[0], 
	    	 ];
		      $node_revision__field_product_id_query = \Drupal::database()->insert('node_revision__field_product_id')
		          ->fields(['bundle','deleted','entity_id','revision_id','langcode','delta','field_product_id_value'])
		          ->values($node_revision__field_product_id_data)
		          ->execute();

              //create node__field_product_id
	    	  $node__field_product_id_data = [ 
	    	    'bundle' => 'drupal_product',
	    	    'deleted' => 0,
	    	    'entity_id' => $Nodeid,
	    	  	'revision_id' => $Nodeid,
	    	    'langcode' => 'en',
	    	    'delta' => 1, 
	    	    'field_product_id_value' => $CsvLineItems[0], 
	    	 ];
		      $node__field_product_id_query = \Drupal::database()->insert('node__field_product_id')
		          ->fields(['bundle','deleted','entity_id','revision_id','langcode','delta','field_product_id_value'])
		          ->values($node__field_product_id_data)
		          ->execute();

              if(empty( $CsvLineItems[3] )){  $CsvLineItems[3]='0';}
              //create node_revision__field_price
	    	  $node_revision__field_price_data = [ 
	    	    'bundle' => 'drupal_product',
	    	    'deleted' => 0,
	    	    'entity_id' => $Nodeid,
	    	  	'revision_id' => $Nodeid,
	    	    'langcode' => 'en',
	    	    'delta' => 1, 
	    	    'field_price_value' => $CsvLineItems[3], 
	    	 ];
		      $node_revision__field_price_query = \Drupal::database()->insert('node_revision__field_price')
		          ->fields(['bundle','deleted','entity_id','revision_id','langcode','delta','field_price_value'])
		          ->values($node_revision__field_price_data)
		          ->execute();

              //create node__field_price
	    	  $node__field_price_data = [ 
	    	    'bundle' => 'drupal_product',
	    	    'deleted' => 0,
	    	    'entity_id' => $Nodeid,
	    	  	'revision_id' => $Nodeid,
	    	    'langcode' => 'en',
	    	    'delta' => 1, 
	    	    'field_price_value' => $CsvLineItems[3], 
	    	 ];
		      $node__field_price_query = \Drupal::database()->insert('node__field_price')
		          ->fields(['bundle','deleted','entity_id','revision_id','langcode','delta','field_price_value'])
		          ->values($node__field_price_data)
		          ->execute();

              if(empty( $CsvLineItems[2] )){  $CsvLineItems[2]='_NoDescriptionAdded';}
              //create node_revision__field_description
	    	  $node_revision__field_description_data = [ 
	    	    'bundle' => 'drupal_product',
	    	    'deleted' => 0,
	    	    'entity_id' => $Nodeid,
	    	  	'revision_id' => $Nodeid,
	    	    'langcode' => 'en',
	    	    'delta' => 1, 
	    	    'field_description_value' => $CsvLineItems[2], 
	    	 ];
		      $node_revision__field_description_query = \Drupal::database()->insert('node_revision__field_description')
		          ->fields(['bundle','deleted','entity_id','revision_id','langcode','delta','field_description_value'])
		          ->values($node_revision__field_description_data)
		          ->execute();

              //create node__field_description
	    	  $node__field_description_data = [ 
	    	    'bundle' => 'drupal_product',
	    	    'deleted' => 0,
	    	    'entity_id' => $Nodeid,
	    	  	'revision_id' => $Nodeid,
	    	    'langcode' => 'en',
	    	    'delta' => 1, 
	    	    'field_description_value' => $CsvLineItems[2], 
	    	 ];
		      $node__field_description_query = \Drupal::database()->insert('node__field_description')
		          ->fields(['bundle','deleted','entity_id','revision_id','langcode','delta','field_description_value'])
		          ->values($node__field_description_data)
		          ->execute();

              //create history
	    	  $history_data = [ 
	    	    'uid' => 1,
	    	    'nid' => $Nodeid,
	    	    'timestamp' => $t, 
	    	 ];
		      $history_query = \Drupal::database()->insert('history')
		          ->fields(['uid','nid','timestamp'])
		          ->values($history_data)
		          ->execute();


			}

		}

	echo '&#x2705; Import Process complete.';
	unlink($_POST['csvFilePath']); //delete csv path


     exit();

	}

	
	public function deletedraft() {

		echo '&#x2705; Draft Delete Process complete.';
		unlink($_POST['DeleteDraftcsvFilePath']);

		exit();

	}
	
}