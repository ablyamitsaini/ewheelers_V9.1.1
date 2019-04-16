<?php
class UploadBulkImagesController extends AdminBaseController
{
    private $canUpload;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();
        $this->objPrivilege->canUploadBulkImages();
        $this->langId = $this->adminLangId;
    }

    public function index()
    {
        $uploadFrm = $this->getUploadForm();
        $this->set("frm", $uploadFrm);
        $this->_template->render();
    }

    private function getUploadForm()
    {
        $frm = new Form('uploadBulkImages', array('id'=>'uploadBulkImages'));

        $fldImg = $frm->addFileUpload(Labels::getLabel('LBL_File_to_be_uploaded:', $this->langId), 'bulk_images', array('id' => 'bulk_images', 'accept' => '.zip' ));
        $fldImg->requirement->setRequired(true);
        $fldImg->setFieldTagAttribute('onChange', '$("#uploadFileName").html(this.value)');
        $fldImg->htmlBeforeField='<div class="filefield"><span class="filename" id="uploadFileName"></span>';
        $fldImg->htmlAfterField='<label class="filelabel">'.Labels::getLabel('LBL_Browse_File', $this->langId).'</label></div>';

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Submit', $this->langId));
        return $frm;
    }

    public function upload()
    {
        $frm = $this->getUploadForm();
        $post = $frm->getFormDataFromArray( $_FILES );

        if( false === $post ){
            Message::addErrorMessage(Labels::getLabel('LBL_Invalid_Data', $this->langId));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $fileName = $_FILES['bulk_images']['name'];
        $tmp_name = $_FILES['bulk_images']['tmp_name'];

        $fileExt = pathinfo( $fileName, PATHINFO_EXTENSION );
        $fileExt = strtolower( $fileExt );
        if( 'zip' != $fileExt ) {
            Message::addErrorMessage(Labels::getLabel('MSG_INVALID_FILE', $this->langId));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $fileHandlerObj = new AttachedFile();

        $savedFile = $fileHandlerObj->saveAttachment( $tmp_name, AttachedFile::FILETYPE_BULK_IMAGES, 0, 0, $fileName );

        if( false === $savedFile ) {
            Message::addErrorMessage( $fileHandlerObj->getError() );
            FatUtility::dieJsonError( Message::getHtml() );
        }


        $path = CONF_UPLOADS_PATH . AttachedFile::FILETYPE_BULK_IMAGES_PATH;

        if( false === $fileHandlerObj->extractZip( $path . $savedFile ) ){
            Message::addErrorMessage(Labels::getLabel('MSG_COULD_NOT_SAVE_FILE', $this->langId));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $filePath = AttachedFile::FILETYPE_BULK_IMAGES_PATH . $savedFile;

        $msg = '<br>'.str_replace('{path}', '<br><b>'.$filePath.'</b>', Labels::getLabel('MSG_Your_uploaded_files_path_will_be:_{path}', $this->langId) );
        $msg = Labels::getLabel('MSG_Uploaded_Successfully.', $this->langId) .' '.$msg;

        FatUtility::dieJsonSuccess($msg);
    }
}
