<div class="white--bg padding20">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
            <div class="product-description">
                <div class="product-description-inner">
                    <div class="products__title"><h4><?php echo  Labels::getLabel('LBL_Test_Drive_Request_Info', $siteLangId);?></h4></div>
                    <div class="gap"></div>
                    <div class="cards pt-2 pl-4 pr-4 pb-4">
                        <table class="table table-cols">
                            <tbody>
                                <tr >
                                    <th width="30%"><?php echo Labels::getLabel('LBL_Product_Name', $siteLangId); ?>:</th>
                                    <td><?php echo $requestData['product_name']; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo Labels::getLabel('LBL_Dealer_Name', $siteLangId); ?>:</th>
                                    <td><?php echo $requestData['sellername']; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo Labels::getLabel('LBL_Location', $siteLangId); ?>:</th>
                                    <td><?php echo $requestData['ptdr_location']; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo Labels::getLabel('LBL_Contact', $siteLangId); ?>:</th>
                                    <td><?php echo $requestData['ptdr_contact']; ?></td>
                                </tr>
                                
                                <tr>
                                    <th><?php echo Labels::getLabel('LBL_Requested_On', $siteLangId); ?>:</th>
                                    <td><?php echo FatDate::format($requestData['ptdr_date'],true); ?></td>
                                </tr>
								<tr>
                                    <th><?php echo Labels::getLabel('LBL_Date_Time', $siteLangId); ?>:</th>
                                    <td><?php echo FatDate::format($requestData['ptdr_request_added_on'],true); ?></td>
                                </tr>
								<?php if($requestData['ptdr_feedback'] != ''){ ?>
								<tr>
                                    <th><?php echo Labels::getLabel('LBL_Customer_Feedback', $siteLangId); ?>:</th>
									<td><?php echo $requestData['ptdr_feedback']; 
									?></td>
                                    
                                </tr>
								<?php }?>
								<tr>
                                    <th><?php echo Labels::getLabel('LBL_Request_Status', $siteLangId); ?>:</th>
                                    <td><?php  $testDriveStatusArr = TestDrive::getStatusArr($siteLangId);
											echo $testDriveStatusArr[$requestData['ptdr_status']];?></td>
                                </tr>
								
								<tr>
                                    <th><?php echo Labels::getLabel('LBL_Dealer_Message', $siteLangId); ?>:</th>
									<td><?php echo $requestData['ptdr_comments'];?></td> 
                                </tr>
	
                               
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
