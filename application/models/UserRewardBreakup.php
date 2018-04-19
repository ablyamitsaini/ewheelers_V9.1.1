<?php
class UserRewardBreakup extends MyAppModel{
	const DB_TBL = 'tbl_user_reward_point_breakup';
	const DB_TBL_PREFIX = 'urpbreakup_';
	
	public function __construct( $id = 0 ) {
		parent::__construct ( static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id );		
		$this->db = FatApp::getDb();
	}
	
	public static function getSearchObject(){
		$srch =  new SearchBase(static::DB_TBL,'urpb');
		return $srch;	
	}
	
	public static function rewardPointBalance($userId = 0){
		$userId = FatUtility::int($userId);
		if(1 > $userId){
			return 0;
		}
		$srch = new UserRewardSearch();
		$srch->joinUserRewardBreakup();
		$srch->addCondition('urp.urp_user_id','=',$userId);
		$srch->addCondition('urpb.urpbreakup_used','=',0);
		$cond = $srch->addCondition('urpb.urpbreakup_expiry','>=',date('Y-m-d'),'AND');
		$cond->attachCondition('urpb.urpbreakup_expiry','=','0000-00-00','OR');
		$srch->addMultipleFields(array('sum(urpbreakup_points) as balance'));
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		/* die($srch->getQuery()); */
		$rs = $srch->getResultSet();
		$row = FatApp::getDb()->fetch($rs);
		if($row == false){ return 0;}
		return FatUtility::int($row['balance']);
	}
}	