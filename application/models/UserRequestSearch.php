<?php
class UserRequestSearch extends SearchBase {
	
	function __construct( ) {
		parent::__construct( UserRequest::DB_TBL, 'ureq');
	}
	
	public function joinUser(){
		$this->joinTable( User::DB_TBL, 'LEFT OUTER JOIN', 'ureq.ureq_user_id = u.user_id', 'u' );
		$this->joinTable( User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'u.user_id = uc.credential_user_id', 'uc' );
	}
	
}
?>