<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    /*get all files without any condition*/
    function retrieveFiles($service,$parentfolderid) {
	//pr($parentfolderid);
       $result = array();
       $pageToken = NULL;
       do {
	   try {
	       $parameters = array();
	       if ($pageToken) {
		   $parameters['pageToken'] = $pageToken;
	       }
	       //$parameters['q'] = " '$parentfolderid' in parents and  trashed = false and mimeType != 'application/vnd.google-apps.folder'";
	       $parameters['q'] = " '$parentfolderid' in parents and  trashed = false";
	       //0B2DcuAduOKQ6d0pJUm13NF9GODg
	       //$parameters['q'] = "trashed = false";
   
	       $files = $service->files->listFiles($parameters);
		//pr($parameters)  ;
   
	       $result = array_merge($result, $files->getItems());
	       $pageToken = $files->getNextPageToken();
	   } catch (Exception $e) {
	       print "An error occurred: " . $e->getMessage();
	       $pageToken = NULL;
	   }
       } while ($pageToken);
       return $result;
    }
    


/*Retreive all root folder*/
    function retrieveAllFiles($service) {
        $result = array();
        $pageToken = NULL;
        do {
            try {
                $parameters = array();
                if ($pageToken) {
                    $parameters['pageToken'] = $pageToken;
                }
                $parameters['q'] = "trashed = false and mimeType = 'application/vnd.google-apps.folder'";
    
                $files = $service->files->listFiles($parameters);
    
    
                $result = array_merge($result, $files->getItems());
                $pageToken = $files->getNextPageToken();
            } catch (Exception $e) {
                print "An error occurred: " . $e->getMessage();
                $pageToken = NULL;
            }
        } while ($pageToken);
        return $result;
    }
    
/*Retreive all files asper folder*/
    function printFilesInFolder($service, $folderId) {
	$pageToken = NULL;
	$result = array();
	do {
	  try {
	    $parameters = array();
	    if ($pageToken) {
	      $parameters['pageToken'] = $pageToken;
	    }
            $parameters['q'] = "trashed = false";
	    //$parameters['q'] = " '$folderId' in parents and  trashed = false";
	    $children = $service->children->listChildren($folderId, $parameters);
      
	    foreach ($children->getItems() as $child) {
	      //print 'File Id: ' . $child->getId();
	      $result[] =  $child;
	    }
	    
	    $pageToken = $children->getNextPageToken();
	  } catch (Exception $e) {
	    print "An error occurred: " . $e->getMessage();
	    $pageToken = NULL;
	  }
	} while ($pageToken);
	return $result;
      }


	function getAllFilesInFolder($service, $folderId) {
	$pageToken = NULL;
	$result = array();
	do {
	  try {
	    $parameters = array();
	    if ($pageToken) {
	      $parameters['pageToken'] = $pageToken;
	    }
            
		//$parameters['q'] = "trashed = false";
	    $parameters['q'] = " '$folderId' in parents and  trashed = false";
	    /*$children = $service->children->listChildren($folderId, $parameters);
      
	    foreach ($children->getItems() as $child) {
	      //print 'File Id: ' . $child->getId();
	      $result[] =  $child;
	    }
	    
	    $pageToken = $children->getNextPageToken();*/

		$files = $service->files->listFiles($parameters);

      		$result = array_merge($result, $files->getItems());
      		$pageToken = $files->getNextPageToken();

		

	  } catch (Exception $e) {
	    print "An error occurred: " . $e->getMessage();
	    $pageToken = NULL;
	  }
	} while ($pageToken);
	return $result;
      }


	function getSearchFilesInFolder($service, $folderId) {
		$pageToken = NULL;
		$result = array();
		do {
		  try {
		    $parameters = array();
		    if ($pageToken) {
		      $parameters['pageToken'] = $pageToken;
		    }
		    //$parameters['q'] = "trashed = false";
		    $parameters['q'] = " '$folderId' in parents and  trashed = false and mimeType != 'application/vnd.google-apps.folder'";
		   
		  /* 
		   $children = $service->children->listChildren($folderId, $parameters);
	      
		    foreach ($children->getItems() as $child) {
		      //print 'File Id: ' . $child->getId();
		      $result[] =  $child;
		    }
		    
		    $pageToken = $children->getNextPageToken(); */

			$files = $service->files->listFiles($parameters);

      		$result = array_merge($result, $files->getItems());
      		$pageToken = $files->getNextPageToken();


		  } catch (Exception $e) {
		    print "An error occurred: " . $e->getMessage();
		    $pageToken = NULL;
		  }
		} while ($pageToken);
		return $result;
	      }
      


	function printFilesInFolder_search($service, $folderId) {
		$pageToken = NULL;
		$result = array();
		do {
		  try {
		    $parameters = array();
		    if ($pageToken) {
		      $parameters['pageToken'] = $pageToken;
		    }
		    //$parameters['q'] = "trashed = false";
		    $parameters['q'] = " '$folderId' in parents and  trashed = false and mimeType != 'application/vnd.google-apps.folder'";
		    $children = $service->children->listChildren($folderId, $parameters);
	      
		    foreach ($children->getItems() as $child) {
		      //print 'File Id: ' . $child->getId();
		      $result[] =  $child;
		    }
		    
		    $pageToken = $children->getNextPageToken();
		  } catch (Exception $e) {
		    //print "An error occurred: " . $e->getMessage();
		    $pageToken = NULL;
		  }
		} while ($pageToken);
		return $result;
	      }
      


/*Retreive all files only asper folder*/
    function printAllFilesInFolder($service, $folderId) {
	$pageToken = NULL;
	$result = array();
	do {
	  try {
	    $parameters = array();
	    if ($pageToken) {
	      $parameters['pageToken'] = $pageToken;
	    }
            $parameters['q'] = "trashed = false and mimeType != 'application/vnd.google-apps.folder'";
	    $children = $service->children->listChildren($folderId, $parameters);
      
	    foreach ($children->getItems() as $child) {
	      //print 'File Id: ' . $child->getId();
	      $result[] =  $child;
	    }
	    
	    $pageToken = $children->getNextPageToken();
	  } catch (Exception $e) {
	    print "An error occurred: " . $e->getMessage();
	    $pageToken = NULL;
	  }
	} while ($pageToken);
	return $result;
      }
      
      
     /**
    * Print a file's metadata.
    *
    * @param Google_DriveService $service Drive API service instance.
    * @param string $fileId ID of the file to print metadata for.
    */
    function printFile($service, $fileId) {
        $result = array();
      try {
        $file = $service->files->get($fileId);
        //downloadFile(null,$file);
        $result=$file;
        /*print "Title: " . $file->getTitle();
        print "Description: " . $file->getDescription();
        print "MIME type: " . $file->getMimeType();
        */
        //$result['bijendra'][]=downloadFile(null,$file);
      } catch (Exception $e) {
        print "An error occurred: " . $e->getMessage();
      }
      return $result;
    }
 
   
   
   
   function GetDownloadLinkFile($service, $downloadUrl) {
     //$downloadUrl = $file->getDownloadUrl();
     //pre($downloadUrl);
     if ($downloadUrl) {
       $request = new Google_HttpRequest($downloadUrl, 'GET', null, null);
       $httpRequest = Google_Client::$io->authenticatedRequest($request);
       //pre($httpRequest);
       if ($httpRequest->getResponseHttpCode()) {
         return $httpRequest->getResponseBody();
       } else {
         // An error occurred.
	 //return 'error';
         return null;
       }
     } else {
       // The file doesn't have any content stored on Drive.
       return null;
     }
   }
   
   
   
   
   /*Create a folder in Root*/
    function createPublicFolder($service, $folderName) {
        $file = new Google_DriveFile();
        $file->setTitle($folderName);
        $file->setMimeType('application/vnd.google-apps.folder');
        $createdFile = $service->files->insert($file, array(
            'mimeType' => 'application/vnd.google-apps.folder',
        ));
        $permission = new Google_Permission();
        $permission->setValue('');
        $permission->setType('anyone');
        $permission->setRole('reader');
        
        try {
            $returnVal = $service->permissions->insert($createdFile->getId(), $permission);
            //pr($returnVal);
        }
        catch (Exception $e) {
          print "An error occurred: " . $e->getMessage();
          exit;
        }
        return $returnVal;
    }
    
    
    function insertFileIntoFolder($service, $folderId, $fileId) {
        $newParent = new Google_ParentReference();
        $newParent->setId($folderId);
        try {
          return $service->parents->insert($fileId, $newParent);
        } catch (Exception $e) {
          print "An error occurred: " . $e->getMessage();
        }
        return NULL;
    }
    
    
    
    /**
     * Insert new file.
     *
     * @param Google_DriveService $service Drive API service instance.
     * @param string $title Title of the file to insert, including the extension.
     * @param string $description Description of the file to insert.
     * @param string $parentId Parent folder's ID.
     * @param string $mimeType MIME type of the file to insert.
     * @param string $filename Filename of the file to insert.
     * @return Google_DriveFile The file that was inserted. NULL is returned if an API error occurred.
     */
    function insertFile($service, $title, $description, $parentId, $mimeType, $filename) {
      $file = new Google_DriveFile();
      $file->setTitle($title);
      $file->setDescription($description);
      $file->setMimeType($mimeType);
    
      // Set the parent folder.
      if ($parentId != null) {
        $parent = new Google_ParentReference();
        $parent->setId($parentId);
        $file->setParents(array($parent));
      }
    
      try {
        if($mimeType !='application/vnd.google-apps.folder'){
                $data = file_get_contents($filename);
                $createdFile = $service->files->insert($file, array(
                  'data' => $data,
                  'mimeType' => $mimeType,
                ));
            
        }
        else{
             $createdFile = $service->files->insert($file, array(
                'mimeType' => $mimeType,
            ));
        }
        // Uncomment the following line to print the File ID
        // print 'File ID: %s' % $createdFile->getId();
       
        return $createdFile;
      } catch (Exception $e) {
       
        print "An error occurred: " . $e->getMessage();
      }
    }
    
    
    
        /**
     * Update an existing file's metadata and content.
     *
     * @param Google_DriveService $service Drive API service instance.
     * @param string $fileId ID of the file to update.
     * @param string $newTitle New title for the file.
     * @param string $newDescription New description for the file.
     * @param string $newMimeType New MIME type for the file.
     * @param string $newFilename Filename of the new content to upload.
     * @param bool $newRevision Whether or not to create a new revision for this file.
     * @return Google_DriveFile The updated file. NULL is returned if an API error occurred.
     */
    function updateFile($service, $fileId, $newTitle, $newDescription, $newMimeType, $newFileName, $newRevision) {
      try {
        // First retrieve the file from the API.
        $file = $service->files->get($fileId);
    
        // File's new metadata.
        $file->setTitle($newTitle);
        $file->setDescription($newDescription);
        $file->setMimeType($newMimeType);
    
        // File's new content.
        $data = file_get_contents($newFileName);
    
        $additionalParams = array(
            'newRevision' => $newRevision,
            'data' => $data,
            'mimeType' => $newMimeType
        );
    
        // Send the request to the API.
        $updatedFile = $service->files->update($fileId, $file, $additionalParams);
        return $updatedFile;
      } catch (Exception $e) {
        print "An error occurred: " . $e->getMessage();
      }
    }
    
    
    /**
    * Remove a Childfile from a folder.
    *
    * @param Google_DriveService $service Drive API service instance.
    * @param String $folderId ID of the folder to remove the file from.
    * @param String $fileId ID of the file to remove from the folder.
    */
    /*function removeFileFromFolder($service, $folderId, $fileId) {
      try {
        $service->children->delete($folderId, $fileId);
      } catch (Exception $e) {
        print "An error occurred: " . $e->getMessage();
      }
    }
    */
    
    /**
    * Remove a Parent file or folder.
    *
    * @param Google_DriveService $service Drive API service instance.
    * @param String $folderId ID of the folder to remove the file from.
    * @param String $fileId ID of the file to remove from the folder.
    */
   function removeFileFromFolder($service, $folderId, $fileId) {
     try {
       $service->parents->delete($fileId, $folderId);
     } catch (Exception $e) {
       print "An error occurred: " . $e->getMessage();
     }
   }
    
    /**
    * Permanently delete a file, skipping the trash.
    *
    * @param Google_DriveService $service Drive API service instance.
    * @param String $fileId ID of the file to delete.
    */
    function deleteFile($service, $fileId) {
      try {
        $service->files->delete($fileId);
      } catch (Exception $e) {
        print "An error occurred: " . $e->getMessage();
      }
    }
    
    
    
     function retrieveOnlyFiles($service,$searchArray) {
        $result = array();
        $pageToken = NULL;
        do {
            try {
                $parameters = array();
                if ($pageToken) {
                    $parameters['pageToken'] = $pageToken;
                }
                $parameters['q'] = "fullText contains '".$searchArray."' and trashed = false and mimeType != 'application/vnd.google-apps.folder'";
                //pr($parameters);
                $files = $service->files->listFiles($parameters);
    
    
                $result = array_merge($result, $files->getItems());
                $pageToken = $files->getNextPageToken();
            } catch (Exception $e) {
                print "An error occurred: " . $e->getMessage();
                $pageToken = NULL;
            }
        } while ($pageToken);
        return $result;
    }
    
    
    function walk_dir($service,$folderId,$folderName){
	$CI =& get_instance(); // Get the global CI object
        $CI->load->library('zip');
	$fileList = retrieveAllFilesFordownload($service,$folderId);

	if(!empty($fileList)){
		foreach($fileList as $file){
			
			if($file->mimeType != "application/vnd.google-apps.folder"){
				$name = $folderName.'/'.$file->title;
				$data = downloadFile($service,$file);
				$CI->zip->add_data($name, $data);
			}
			else{
			    	
			    walk_dir($service,$file->id,$folderName.'/'.$file->title);	
			}

			

		}
	}
    }
    
    
    function download_files($service,$fileArry){
	$CI =& get_instance(); // Get the global CI object
        $CI->load->library('zip');
	
	if(is_array($fileArry)){
	    $fileList = $fileArry;    
	}
	else{
	    $fileList = array($fileArry);
	}
	
	
	if(!empty($fileList)){
		foreach($fileList as $file){
			if($file->mimeType != "application/vnd.google-apps.folder"){
				$name = 'Documents/'.$file->title;
				$data = downloadFile($service,$file);
				$CI->zip->add_data($name, $data);
			}

		}
	}
    }
    function download_google_files($service,$filesArray){
	$CI =& get_instance();
	$CI->load->library('zip');
	if(!empty($filesArray)){
	    //pr($filesArray);
	    if($filesArray->mimeType != "application/vnd.google-apps.folder"){
				$name = 'Documents/'.$filesArray->title;
				$data = downloadFile($service,$filesArray);
				//pr($data);
				return $CI->zip->add_data($name, $data);
			}
	    
	}
    }
    
    
     /**
    * Download a file's content.
    *
    * @param Google_DriveService $service Drive API service instance.
    * @param File $file Drive File instance.
    * @return String The file's content if successful, null otherwise.
    */
   function downloadFile($service, $file) {
     
     $downloadUrl = $file->getDownloadUrl();
     
     if ($downloadUrl) {
       $request = new Google_HttpRequest($downloadUrl, 'GET', null, null);
       $httpRequest = Google_Client::$io->authenticatedRequest($request);
       
       if ($httpRequest->getResponseHttpCode() == 200) {
	//pr($httpRequest);
         return $httpRequest->getResponseBody();
       } else {
         // An error occurred.
	 //return 'error';
         return null;
       }
     } else {
	///return 'dsdf';
       // The file doesn't have any content stored on Drive.
       return null;
     }
   }
   
   
    
    function retrieveAllFilesFordownload($service,$folderId = "") {
    $result = array();
    $pageToken = NULL;
        do {
            try {
                $parameters = array();
                if ($pageToken) {
                    $parameters['pageToken'] = $pageToken;
                }
               // $parameters['q'] = "trashed = false and mimeType != 'application/vnd.google-apps.folder'";
                
                if(!empty($folderId)){
                        $parameters['q'] = "'" .$folderId."' in parents and trashed = false";
                }
                else{
                    $parameters['q'] = " trashed = false";
                }      	
                
                $files = $service->files->listFiles($parameters);
    
    
                $result = array_merge($result, $files->getItems());
                $pageToken = $files->getNextPageToken();
            } catch (Exception $e) {
                print "An error occurred: " . $e->getMessage();
                $pageToken = NULL;
            }
        } while ($pageToken);
        return $result;
    }
    
    
    
    
    /**
    * Copy an existing file.
    *
    * @param Google_DriveService $service Drive API service instance.
    * @param String $originFileId ID of the origin file to copy.
    * @param String $copyTitle Title of the copy.
    * @return DriveFile The copied file. NULL is returned if an API error occurred.
    */
    function copyFile($service, $originFileId, $copyTitle, $parentId) {
      $copiedFile = new Google_DriveFile();
      
	$parent = new Google_ParentReference();
	$parent->setId($parentId);
	$copiedFile->setParents(array($parent));
      
      $copiedFile->setTitle($copyTitle);
      try {
        return $service->files->copy($originFileId, $copiedFile);
      } catch (Exception $e) {
        print "An error occurred: " . $e->getMessage();
      }
      return NULL;
    }
    
    function moveFile($service, $fileId, $parentId) {
        try {
          $file = new Google_DriveFile();
          $file->setParent($parentId);
      
          $updatedFile = $service->files->patch($fileId, $file, array(
            'fields' => 'parents'
          ));
      
          return $updatedFile;
        } catch (Exception $e) {
          print "An error occurred: " . $e->getMessage();
        }
}
    
    function searchAllfileFolder($service,$searchArray,$type) {
	//pre($searchArray);
        $result = array();
        $pageToken = NULL;
        do {
            try {
                $parameters = array();
                if ($pageToken) {
                    $parameters['pageToken'] = $pageToken;
                }
		if($type=='basic'){
		    //$parameters['q'] =  "'".$searchArray."' in owners and trashed = false";    
		    //working $parameters['q'] = "title contains '".$searchArray['text']."' and '".$searchArray['parentfolderid']."' in parents  and trashed = false ";
		     $parameters['q'] = "fullText contains '".$searchArray['text']."' and trashed = false ";
		}else{
		    //pre($searchArray);
		    if($searchArray['fullText']!=null)
		    {
			$fullsearch = "  and  fullText contains '".$searchArray['fullText']."' and mimeType != 'application/vnd.google-apps.folder'"; 
		    }else{
			$fullsearch="";
		    }
		    if($searchArray['parents']!=null)
		    {
			$parents = "and '".$searchArray['parents']."' in parents ";    
		    }else { $parents="";} 
		    if($searchArray['title']!=null)
		    {
			$title = " and fullText contains '".$searchArray['title']."' ";
		    }else { $title=""; }
		    if($searchArray['mimeType']!=null)
		    {
			if($searchArray['mimeType'] =="word")
			{
				/*Word file only*/
			}elseif($searchArray['mimeType'] =="excel")
			{
					/*Excel file only*/
			}elseif($searchArray['mimeType']=='powerpoint'){
							/*powerpoint file only*/
			}else {
			    $mimetype = "and mimeType = '".$searchArray['mimeType']."' ";        
			}
			
		    }else { $mimetype="";} 
		    
		    if($searchArray['text']!=null)
		    {
			$searchstr=" fullText contains '".$searchArray['text']."' ";
		    }
		    
		    /*Search query*/
		    if($searchArray['mimeType']!="mimeType"){
			//$parameters['q'] = "fullText contains '".$searchArray['text']."' and trashed = false and mimeType != 'application/vnd.google-apps.folder'";    
			 $parameters['q'] = $searchstr.$fullsearch.$parents.$title.$mimetype. " and trashed = false ";   
		    }
		    else {
			if($searchstr || $fullsearch || $parents || $title){
			    $parameters['q'] = $searchstr.$fullsearch.$parents.$title. " and trashed = false ";
			    }else{
			    $parameters['q'] = "trashed = false ";
			}
			
			
		    }
		    //pre($searchArray);
		    
		    /*else if($searchby=="mimeType"){
			
			$parameters['q'] = "mimeType = '".$searchArray['text']."' and trashed = false and mimeType == 'application/vnd.google-apps.folder'";    
		    }else if($searchby=="parents"){
			$parameters['q'] = "fullText contains '".$searchArray."'and '".$searchfolderid."' in parents  and trashed = false";    
		    }*/
		    
		}
                
              

		$docarray = array('application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/msword','application/vnd.oasis.opendocument.text');

		$excelArray=array('application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.oasis.opendocument.spreadsheet');
		$powerpointArray=array('application/vnd.ms-powerpoint','application/vnd.openxmlformats-officedocument.presentationml.presentation','application/vnd.oasis.opendocument.presentation');
		if($searchArray['mimeType'] == "word"){
		    foreach($docarray as $val)
			{
			  $wordPara['q'] = $parameters['q'] ." and mimeType = '".$val."'";   
			  $word_files = $service->files->listFiles($wordPara);
			  if(empty($files)){
				$files = $word_files;
			  }
			  else{
				$files->items = array_merge($files->items,$word_files->items); 
			  }			
			  
			}
			
			//pre($parameters);
			
		}else if($searchArray['mimeType'] == "excel"){
			foreach($excelArray as $val)
			{
			  $wordPara['q'] = $parameters['q'] ." and mimeType = '".$val."'";   
			  $word_files = $service->files->listFiles($wordPara);
			  if(empty($files)){
				$files = $word_files;
			  }
			  else{
				$files->items = array_merge($files->items,$word_files->items); 
			  }			
			  
			}
			
			//pre($parameters);
		}elseif($searchArray['mimeType'] == "powerpoint"){
			foreach($powerpointArray as $val)
			{
			  $wordPara['q'] = $parameters['q'] ." and mimeType = '".$val."'";   
			  $word_files = $service->files->listFiles($wordPara);
			  if(empty($files)){
				$files = $word_files;
			  }
			  else{
				$files->items = array_merge($files->items,$word_files->items); 
			  }			
			  
			}
		}else{
		    $files = $service->files->listFiles($parameters);   

		}
                
                $result = array_merge($result, $files->getItems());
                $pageToken = $files->getNextPageToken();
            } catch (Exception $e) {
                print "An error occurred: " . $e->getMessage();
                $pageToken = NULL;
            }
        } while ($pageToken);

        return $result;
    }
    
    
    /**
    * Move a file to the trash.
    *
    * @param Google_DriveService $service Drive API service instance.
    * @param String $fileId ID of the file to trash.
    * @return Google_DriveFile The updated file. NULL is returned if an API error occurred.
    */
    function trashFile($service, $fileId) {
      try {
	return $service->files->trash($fileId);
      } catch (Exception $e) {
	print "An error occurred: " . $e->getMessage();
      }
      return NULL;
    }
    
    
    
     /*get all files without any condition*/
    function test_retrieveFiles($service,$folderid) {
	//pr($parentfolderid);
       $result = array();
       $pageToken = NULL;
       do {
	   try {
	       $parameters = array();
	       if ($pageToken) {
		   $parameters['pageToken'] = $pageToken;
	       }
	       //$parameters['q'] = " trashed = false and mimeType != 'application/vnd.google-apps.folder'";
	       $parameters['q'] = " '$folderid' in parents and  trashed = false and mimeType != 'application/vnd.google-apps.folder'";
	       //$parameters['q'] = " '0B2DcuAduOKQ6cjZLcHl3SjFUOEU' in parents and  trashed = false and mimeType != 'application/vnd.google-apps.folder'";
	       //0B2DcuAduOKQ6d0pJUm13NF9GODg
	       //$parameters['q'] = "trashed = false";
   
	       $files = $service->files->listFiles($parameters);
		//pr($parameters)  ;
   
	       $result = array_merge($result, $files->getItems());
	       
	       $pageToken = $files->getNextPageToken();
	   } catch (Exception $e) {
	       //print "An error occurred: " . $e->getMessage();
	       $pageToken = NULL;
	   }
       } while ($pageToken);
       return $result;
    }
    
    
    
    
    /**
	* Print a file's parents.
	*
	* @param Google_DriveService $service Drive API service instance.
	* @param String $fileId ID of the file to print parents for.
	*/
    function printParents($service, $fileId) {
      try {
	$parents = $service->parents->listParents($fileId);
    
	foreach ($parents->getItems() as $parent) {
	  print 'File Id: ' . $parent->getId();
	}
      } catch (Exception $e) {
	print "An error occurred: " . $e->getMessage();
      }
    }



/*For temprary use only*/
    function getAllfile_temp($service) {
        $result = array();
        $pageToken = NULL;
        do {
            try {
                $parameters = array();
                if ($pageToken) {
                    $parameters['pageToken'] = $pageToken;
                }
                $parameters['q'] = "trashed = false and mimeType = 'application/vnd.google-apps.folder'";
    
                $files = $service->files->listFiles($parameters);
    
    
                $result = array_merge($result, $files->getItems());
                $pageToken = $files->getNextPageToken();
            } catch (Exception $e) {
                print "An error occurred: " . $e->getMessage();
                $pageToken = NULL;
            }
        } while ($pageToken);
        return $result;
    }
?>
