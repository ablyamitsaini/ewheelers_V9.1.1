<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$arr_flds = array(
        'select_all'=>Labels::getLabel('LBL_Select_all', $siteLangId),
        'listserial'=>Labels::getLabel('LBL_Sr._no.', $siteLangId),
        'scollection_identifier'=>Labels::getLabel('LBL_Collection_Name', $siteLangId),
        'scollection_active'=>Labels::getLabel('LBL_Status', $siteLangId),
        'action' => Labels::getLabel('LBL_Action', $siteLangId),
    );
$tbl = new HtmlElement(
    'table',
    array('width'=>'100%', 'class'=>'table table--orders','id'=>'options')
);

$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $key => $val) {
    if ('select_all' == $key) {
        $th->appendElement('th')->appendElement('plaintext', array(), '<label class="checkbox"><input type="checkbox" onclick="selectAll( $(this) )" class="selectAll-js"><i class="input-helper"></i>'.$val.'</label>', true);
    } else {
        $th->appendElement('th', array(), $val);
    }
}
$sr_no = 0;
foreach ($arr_listing as $sn => $row) {
    $sr_no ++;
    $tr = $tbl->appendElement('tr');
    $tr->setAttribute("id", $row['scollection_id']);

    foreach ($arr_flds as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', array(), '<label class="checkbox"><input class="selectItem--js" type="checkbox" name="scollection_id[]" value='.$row['scollection_id'].'><i class="input-helper"></i></label>', true);
                break;
            case 'listserial':
                $td->appendElement('plaintext', array(), $sr_no);
                break;
            case 'scollection_identifier':
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;

            case 'scollection_active':
                /* $td->appendElement( 'plaintext', array(), $activeInactiveArr[$row[$key]],true ); */
                $active = "";
                if (applicationConstants::ACTIVE == $row['scollection_active']) {
                    $active = 'checked';
                }

                $str = '<label class="toggle-switch" for="switch'.$row['scollection_id'].'"><input '.$active.' type="checkbox" value="'.$row['scollection_id'].'" id="switch'.$row['scollection_id'].'" onclick="toggleShopCollectionStatus(event,this)"/><div class="slider round"></div></label>';

                $td->appendElement('plaintext', array(), $str, true);
                break;

            case 'action':
                $ul = $td->appendElement("ul", array("class"=>"actions"));
                    $li = $ul->appendElement("li");
                    $li->appendElement(
                        'a',
                        array(
                        'href'=>'javascript:void(0)',
                        'class'=>'button small green', 'title'=>Labels::getLabel('LBL_Edit', $siteLangId),
                        "onclick"=>"getShopCollectionGeneralForm(".$row['scollection_id'].")"),
                        '<i class="fa fa-edit"></i>',
                        true
                    );

                    $li = $ul->appendElement("li");
                    $li->appendElement(
                        'a',
                        array(
                        'href'=>"javascript:void(0)", 'class'=>'button small green',
                        'title'=>Labels::getLabel('LBL_Delete', $siteLangId),"onclick"=>"deleteShopCollection(".$row['scollection_id'].")"),
                        '<i class="fa fa-trash"></i>',
                        true
                    );

                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
}
if (count($arr_listing) == 0) {
    $message = Labels::getLabel('LBL_No_Collection_found', $siteLangId);
    $linkArr = array(
    0=>array(
    'href'=>'javascript:void(0);',
    'label'=>Labels::getLabel('LBL_Add_Collection', $siteLangId),
    'onClick'=>"getShopCollectionGeneralForm(0)",
    )
    );
    $this->includeTemplate('_partial/no-record-found.php', array('siteLangId'=>$siteLangId,'linkArr'=>$linkArr,'message'=>$message));
} else { ?>
    <form id="frmCollectionsListing" name="frmCollectionsListing" method="post" onsubmit="formAction(this); return(false);" class="form" action="<?php echo CommonHelper::generateUrl('Seller', 'bulkOptionsDelete'); ?>">
        <?php echo $tbl->getHtml(); ?>
    </form>
<?php } ?>
