<section class="section">
<div class="sectionhead">
   
    <h4><?php echo Labels::getLabel('LBL_Test_Drive_Request_Detail',$adminLangId); ?></h4>
</div>
<div class="sectionbody space">
<div class="row">	
<div class="col-sm-12">
	<div class="tabs_nav_container responsive flat">
		<div class="tabs_panel_wrap">
			<div class="tabs_panel testDrive-table">
				<table style="width: 100%;max-width: 100%;">
                            <tbody>
                                <tr>
                                    <th><?php echo Labels::getLabel('LBL_Product_Name', $adminLangId); ?>:</th>
                                    <td><?php echo $arr_listing['product_name']; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo Labels::getLabel('LBL_Buyer_Name', $adminLangId); ?>:</th>
                                    <td><?php echo $arr_listing['buyername']; ?></td>
                                </tr>
								<tr>
                                    <th><?php echo Labels::getLabel('LBL_Seller_Name', $adminLangId); ?>:</th>
                                    <td><?php echo $arr_listing['sellername']; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo Labels::getLabel('LBL_Location', $adminLangId); ?>:</th>
                                    <td><?php echo $arr_listing['ptdr_location']; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo Labels::getLabel('LBL_Contact', $adminLangId); ?>:</th>
                                    <td><?php echo $arr_listing['ptdr_contact']; ?></td>
                                </tr>
                                
                                <tr>
                                    <th><?php echo Labels::getLabel('LBL_Requested_On', $adminLangId); ?>:</th>
                                    <td><?php echo FatDate::format($arr_listing['ptdr_date'],true); ?></td>
                                </tr>
								<tr>
                                    <th><?php echo Labels::getLabel('LBL_Date_Time', $adminLangId); ?>:</th>
                                    <td><?php echo FatDate::format($arr_listing['ptdr_request_added_on'],true); ?></td>
                                </tr>
								<tr>
                                    <th><?php echo Labels::getLabel('LBL_Request_Status', $adminLangId); ?>:</th>
                                    <td><?php  $testDriveStatusArr = TestDrive::getStatusArr($adminLangId);
											echo $testDriveStatusArr[$arr_listing['ptdr_status']];?></td>
                                </tr>
								<?php if($arr_listing['ptdr_feedback'] != ''){ ?>
								<tr>
                                    <th><?php echo Labels::getLabel('LBL_Customer_Feedback', $adminLangId); ?>:</th>
									<td><?php echo $arr_listing['ptdr_feedback']; 
									?></td>
                                    
                                </tr>
								<?php }?>
								<tr>
                                    <th><?php echo Labels::getLabel('LBL_Seller_Comments', $adminLangId); ?>:</th>
									<td><?php echo $arr_listing['ptdr_comments'];?> 
                                </tr>
                            </tbody>
                        </table>
			</div>
		</div>
	</div>
</div>
</div></div></section>