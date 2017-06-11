<?php

require_once APPPATH . '/libraries/JWT.php';
require_once APPPATH . '/helpers/LoginConfigHelper.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;

class Users_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function Login($id, $pw) {
		$query = $this->db->select('GroupID, Name')
			->where('ID', $id)
			->where('Password', $pw)
			->get('pc_member');

		if($query->num_rows() == 1) {
			$token['id'] = $id;
			$name = "";
			foreach ($query->result() as $row)
			{
				$token['group_id'] = $row->GroupID;
				$name = $row->Name;
			}

			$token['iat'] = time();
			$token['exp'] = time() + LoginConfigHelper::SESSION_VALID_TIME();
			$output['id_token'] = JWT::encode($token, "hyeonsik");
			$output['name'] = $name;
			return $output;
		} else {
			return false;
		}
	}

	public function Signin($group_id, $id, $pw) {
		$query = $this->db->query("INSERT INTO pc_member (GroupID, ID, Password) VALUES ('" . $group_id ."', '" . $id ."', '" . $pw ."')");
		return $query;
	}

	public function IsExistAccount($id) {
		$query = $this->db->select('count(*) as cnt')
				->where('ID', $id)
				->get('pc_member');

		if($query->row()->cnt == 1)
		{
			return true;
		} else {
			return false;
		}
	}

	public function UserInfoUpdate($param) {
		if(array_key_exists('HP', $param))
			$this->db->set('HP', $param['HP']);

		if(array_key_exists('Address1', $param))
			$this->db->set('Address1', $param['Address1']);

		if(array_key_exists('Address2', $param))
			$this->db->set('Address2', $param['Address2']);

		if(array_key_exists('Mail', $param))
			$this->db->set('Mail', $param['Mail']);

		if(array_key_exists('Password', $param))
			$this->db->set('Password', $param['Password']);

		$this->db->where('ID', $param['ID']);

		return $this->db->update('pc_member');
	}

	public function isValidLogin($token_id)
	{
		///
		try{
			$decoded = JWT::decode($token_id, "hyeonsik", array('HS256'));
			if($decoded != null) {
				if($decoded->exp <= time() + LoginConfigHelper::REFRESH_SIGN_ATLEAST_TIME()) {
					$decoded->iat = time();
					$decoded->exp = time() + LoginConfigHelper::REFRESH_SIGN_ATLEAST_TIME();
					return JWT::encode($decoded, "hyeonsik");
				}
			} else {
				return "expired";
			}
		} catch (ExpiredException $e) {
			return "expired";
		}catch (DomainException $e) {
			return "invalid";
		}
	}

	public function getIDfromToken($token_id) {
		$token = JWT::decode($token_id,"hyeonsik", array('HS256'));
		return $token->id;
	}

	public function getGroupIDfromToken($token_id) {
		$token = JWT::decode($token_id,"hyeonsik", array('HS256'));
		return $token->group_id;
	}

	public function CloseAccount($id, $pw) {

	}
}
