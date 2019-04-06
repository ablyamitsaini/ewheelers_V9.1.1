<?php
class SelProdReviewHelpful extends MyAppModel
{
    const DB_TBL = 'tbl_seller_product_reviews_helpful';
    const DB_TBL_PREFIX = 'sprh_';
    
    const REVIEW_IS_HELPFUL = 1;
    const REVIEW_IS_NOT_HELPFUL = 0;
    
    public function __construct($id = 0) 
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
    }
    
}
