<?php

namespace model;

use core\Model;

class User extends Model {
	protected $table = 'user';

	public function getByAccessToken($accessToken) {
		if ($accessToken === null) return null;

		return $this->app->db->query('
			SELECT *
			FROM ' . $this->table . '
			WHERE access_token = ' . $accessToken . '
		')->row();
	}

	public function getByLoginData($login, $password) {
		return $this->app->db->query('
			SELECT *
			FROM ' . $this->table . '
			WHERE login = ' . $login . ' AND
			password = ' . $password . '
		')->row();
	}

	public function setAccessToken($id) {
		$accessToken = $this->generateAccessToken();

		$this->app->db->update('user', array('access_token' => $accessToken), array('id' => (int) $id));

		return $accessToken;
	}

	private function generateAccessToken() {
		return md5(strtime(true));
	}
}
