<?php
class UploadBulkImages extends FatModel{

	public $bulkRoot;

	public function __construct( $langId = 0 ) {
		parent::__construct();
		$this->db = FatApp::getDb();

		$this->langId = $langId;
		if(1 > $langId){
			$this->langId = CommonHelper::getLangId();
		}

		$this->bulkRoot = CONF_UPLOADS_PATH . AttachedFile::FILETYPE_BULK_IMAGES_PATH;
	}

	public function deleteBulkUploadSubDirs( $hoursBefore = '48', $dirPath = '' )
    {
        if( empty( $dirPath ) ){
            $dirPath = $this->bulkRoot;
        }else if( $dirPath == $this->bulkRoot ){
            die( Labels::getLabel( 'LBL_Bulk_Images_Directory_Clean', $this->langId ) );
        }

        if( is_dir( $dirPath ) ){
            $directories = array_diff( scandir( $dirPath ), array( '..', '.' ) );
            if( 0 < count($directories) ){
                foreach ( $directories as $dir ) {
                    $dirPath = $dirPath . $dir;
                    if( !is_file( $dirPath ) ){
                        $dirPath .= '/';
                    }
                    return $this->deleteBulkUploadSubDirs( $hoursBefore, $dirPath );
                }
            }else{
                if( false !== strpos($dirPath, $this->bulkRoot) && rmdir( $dirPath ) ){
                    $afile_physical_path = rtrim( str_replace( $this->bulkRoot, '', $dirPath ), '/' );
                    $this->db->deleteRecords ( AttachedFile::DB_TBL, array (
							'smt' => 'afile_type = ? AND afile_physical_path = ?',
							'vals' => array ( AttachedFile::FILETYPE_BULK_IMAGES, $afile_physical_path )
					) );

                    $removedDir = array_reverse( array_filter( explode( '/', $dirPath ) ) );
                    $dirPath = str_replace( $removedDir[0].'/' , '', $dirPath);
                    return $this->deleteBulkUploadSubDirs( $hoursBefore, $dirPath );
                }
            }
        }

        if( is_file( $dirPath ) ){
            $modifiedOn = filemtime( $dirPath );
            if( $modifiedOn <= strtotime('-'.$hoursBefore.' hour') ){
				if( false !== strpos($dirPath, $this->bulkRoot) && unlink( $dirPath ) ){
                    $dirPath = str_replace( basename( $dirPath ) , '', $dirPath );
                    return $this->deleteBulkUploadSubDirs( $hoursBefore, $dirPath );
                }
			}
        }
        die( Labels::getLabel( 'LBL_Done!', $this->langId ) );
    }
}
