<?php

namespace model;

use core\Model;

class User extends Model {
	const ADMIN = 1;
	const TEACHER = 2;
	const PUPIL = 3;

	protected $table = 'user';

	public function get($id) {
		return $this->app->db->query('
			SELECT
				user.*,
				school.title school
			FROM ' . $this->table . '
			INNER JOIN
				school ON school.id = user.school_id
			WHERE
				user.id = ' . (int) $id . '
		')->row();
	}

	public function getTeachers($school_id) {
		return $this->app->db->query('
			SELECT
				user.*,
				CONCAT(user.surname, \' \', user.name, \' \', user.patronymic) full_name,
				subject.title subject_title
			FROM ' . $this->table . '
			INNER JOIN
				subject ON subject.id = user.subject_id
			WHERE
				school_id = ' . (int) $school_id . ' AND
				group_id = ' . self::TEACHER . '
		')->result();
	}

	public function getByAccessToken($accessToken) {
		if ($accessToken === null) return null;

		return $this->app->db->query('
			SELECT *
			FROM ' . $this->table . '
			WHERE access_token = \'' . $accessToken . '\'
		')->row();
	}

	public function getByLoginData($login, $password) {
		return $this->app->db->query('
			SELECT *
			FROM ' . $this->table . '
			WHERE login = \'' . $login . '\' AND
			password = \'' . md5($password) . '\'
		')->row();
	}

	public function setAccessToken($id) {
		$accessToken = $this->generateAccessToken();

		$this->app->db->update('user', array('access_token' => $accessToken), array('id' => (int) $id));

		return $accessToken;
	}

	private function generateAccessToken() {
		return md5(time(true));
	}
}
