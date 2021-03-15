<?php


namespace verifyApplicants;


use wpdb;

class verifyApplicants {
	
	/**
	 * @var wpdb
	 */
	private static $query;
	private static $capacities = 'IncluyemeDiscap';
	private $user;
	private $prefix;
	private $resume;
	private $capacitiesMetaID = "IncluyemeDiscapMetaId";
	
	function __construct() {
		global $wpdb;
		self::$query      = $wpdb;
	
		$this->prefix     = $wpdb->prefix;
		self::$capacities = get_option( self::$capacities ) ? get_option( self::$capacities ) : 'tipo_discapacidad';
		
	}
	public function setUserID($userID){
		$this->user       = $userID;
		$this->getResumeId();
		$this->checkMetaId();
	}
	private function getResumeId() {
		$this->resume = self::$query->get_results( "SELECT * from {$this->prefix}wpjb_resume where user_id = {$this->user}" );
		if ( count( $this->resume ) <= 0 ) {
			wp_redirect( home_url(), 301 );
			exit;
		} else {
			$this->resume = $this->resume[0]->id;
		}
	}
	
	private function checkMetaId() {
		$this->capacitiesMetaID = self::$query->get_results( "SELECT * from  {$this->prefix}wpjb_meta where meta_type = 3 and name = '" . self::$capacities . "'" );
		if ( count( $this->capacitiesMetaID ) > 0 ) {
			$this->capacitiesMetaID = $this->capacitiesMetaID[0]->id;
		} else {
			$this->capacitiesMetaID = "capacitiesMetaID";
		}
	}
	
	public function checkUsersCapacities() {
		$user = [];
		if ( $this->checkTables() === true ) {
			$user = self::$query->get_results( "SELECT * from {$this->prefix}incluyeme_users_dicapselect where resume_id = {$this->resume}" );
			
		} else if ( $this->resume !== 0 ) {
			$user = self::$query->get_results( "SELECT * from {$this->prefix}wpjb_meta_value
													where object_id = {$this->resume}
													  AND value <> 'Ninguna'
													  AND value IS NOT null
													  AND meta_id = {$this->capacitiesMetaID}" );
		}
		return count( $user ) > 0;
	}
	
	private function checkTables() {
		$row = self::$query->get_results( "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '{$this->prefix}incluyeme_users_dicapselect' AND column_name = 'resume_id'" );
		
		if ( empty( $row ) ) {
			return false;
		}
		
		return true;
	}
	
}
