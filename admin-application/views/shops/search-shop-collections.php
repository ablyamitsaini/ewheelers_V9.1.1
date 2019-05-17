<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
        'select_all'=>Labels::getLabel('LBL_Select_all', $adminLangId),
        'listserial'=>Labels::getLabel('LBL_Sr._no.', $adminLangId),
        'scollection_identifier'=>Labels::getLabel('LBL_Collection_Name', $adminLangId),
        'scollection_active'=>Labels::getLabel('LBL_Status', $adminLangId),
        'action' => Labels::getLabel('LBL_Action', $adminLangId),
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
                $activeInactiveArr = applicationConstants::getActiveInactiveArr($adminLangId);
                $td->appendElement('plaintext', array(), $activeInactiveArr[$row[$key]], true);
                break;
            case 'action':
                $ul = $td->appendElement("ul", array("class"=>"actions actions--centered"));
                $li = $ul->appendElement("li", array('class'=>'droplink'));
                $li->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'button small green','title'=>Labels::getLabel('LBL_Edit', $adminLangId)), '<i class="ion-android-more-horizontal icon"></i>', true);
                $innerDiv=$li->appendElement('div', array('class'=>'dropwrap'));
                $innerUl=$innerDiv->appendElement('ul', array('class'=>'linksvertical'));

                $innerLi=$innerUl->appendElement('li');
                $innerLi->appendElement('a', array('href'=>'javascript:void(0)','class'=>'button small green','title'=>Labels::getLabel('LBL_Edit', $adminLangId),"onclick"=>"getShopCollectionGeneralForm(".$shopId.",".$row['scollection_id'].")"), Labels::getLabel('LBL_Edit', $adminLangId), true);

                $innerLi=$innerUl->appendElement('li');
                $innerLi->appendElement('a', array('href'=>'javascript:void(0)','class'=>'button small green','title'=>Labels::getLabel('LBL_Delete', $adminLangId),"onclick"=>"deleteShopCollection(".$shopId.",".$row['scollection_id'].")"), Labels::getLabel('LBL_Delete', $adminLangId), true);
                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
}
if (count($arr_listing) == 0) {?>
<div class="sectionhead nopadding">
    <h4><?php echo Labels::getLabel('LBL_No_Collection_found', $adminLangId); ?></h4>
    <a href="javascript:void(0);" class="btn-default btn-sm" onclick="getShopCollectionGeneralForm(<?php echo $shopId; ?>, 0)"><?php echo Labels::getLabel('LBL_Add_Collection', $adminLangId); ?></a>
</div>
<?php } else { ?>
    <div class="sectionhead nopadding">
        <h4><?php echo Labels::getLabel('LBL_Shop_Collections', $adminLangId); ?></h4>
        <a href="javascript:void(0);" class="btn-default btn-sm" onclick="getShopCollectionGeneralForm(<?php echo $shopId; ?>, 0)"><?php echo Labels::getLabel('LBL_Add_Collection', $adminLangId); ?></a>
    </div>
    <form id="frmCollectionsListing" name="frmCollectionsListing" method="post" onsubmit="formAction(this); return(false);" class="form" action="<?php echo CommonHelper::generateUrl('Seller', 'bulkOptionsDelete'); ?>">
        <?php echo $tbl->getHtml(); ?>
    </form>
<?php } ?>
