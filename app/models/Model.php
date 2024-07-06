<?php

namespace App\Models;

use app\utility\Database;
use PDOException;

class Model
{
	private $className;
	private $properties = [];
	protected $fields = [];
	protected $db;
	protected $table;

	public function __set($name, $value)
	{
		$this->properties[$name] = $value;
	}

	public function __get($name)
	{
		return $this->properties[$name] ?? null;
	}

	public function __construct()
	{
		$this->db = Database::instance()->getDbh();
		$this->className = basename(get_called_class());
		if (empty($this->table)) {
			$this->table = strtolower($this->className) . (substr($this->className, -1, 1) != 's' ? 's' : '');
		}
	}

	public function find($id): Model
	{
		$stmt = $this->db->prepare("
			SELECT * 
			FROM " . $this->table . "
			WHERE id = :id
		");
		$stmt->execute([
			'id' => $id
		]);
		$this->properties = $stmt->fetch();
		return $this;
	}

	public function get($where = [], $separator = 'AND', $order = 'id', $direction = 'ASC', $offset = 0, $limit = null)
	{
		$sqlWhere = implode(" " . $separator . " ", array_map(function ($n) {
			return $n . " = :" . $n;
		}, array_keys($where)));
		$stmt = $this->db->prepare("SELECT * FROM " . $this->table .
			(!empty($sqlWhere) ? " WHERE " . $sqlWhere : "") .
			" ORDER BY " . $order . " " . $direction .
			(!empty($limit) ? " OFFSET " . $offset . " LIMIT " . $limit : "")
		);
		$stmt->execute($where);
		return $stmt->fetchAll();
	}

	public function getOne($where = [], $separator = 'AND', $order = 'id', $direction = 'ASC', $offset = 0, $limit = null)
	{
		$res = $this->get($where, $separator, $order, $direction, $offset, $limit);
		return $res[0] ?? null;
	}

	public function update(): Model
	{
		$stmt = $this->db->prepare("
			UPDATE " . $this->table . " 
				SET " . implode(", ", array_map(function ($n) {
				return $n . " = :" . $n;
			}, $this->fields)) . "
			WHERE id = :id
		");

		$stmt->execute(array_filter($this->properties, function ($v) {
			return in_array($v, array_merge(['id'], $this->fields));
		}, ARRAY_FILTER_USE_KEY));
		return $this;
	}

	public function insert(): Model
	{
		try {
			$stmt = $this->db->prepare("
				INSERT INTO " . $this->table . " (" . implode(", ", $this->fields) . ") 
					VALUES 
					(" . implode(", ",
					array_map(function ($v) {
						return ":" . $v;
					}, $this->fields)) . ")");

			$stmt->execute(array_filter($this->properties, function ($v) {
				return $v != 'id';
			}));
			$this->id = $this->db->lastInsertId();
			$this->find($this->id);
		} catch (PDOException $e) {
			dd($e->getMessage());
		}

		return $this;
	}

	public function delete($id = null)
	{
		$stmt = $this->db->prepare("
			DELETE 
			FROM " . $this->table . " 
			WHERE `id` = :id
		");
		$stmt->execute([
			'id' => ($id ?? $this->id)
		]);
		$this->properties = [];
		return $this;
	}

	public function query($sql, $params = [], $get = false)
	{
		$sql = str_replace(':table', $this->table, $sql);
		$stmt = $this->db->prepare($sql);
		$stmt->execute($params);
		if ($get) {
			return $stmt->fetchAll();
		} else {
			return $this->db;
		}
	}

	public function toArray($removeProperty = []): array
	{
		if (empty($this->properties)) return [];
		return array_filter($this->properties, function ($k) use ($removeProperty) {
			return !in_array($k, $removeProperty);
		}, ARRAY_FILTER_USE_KEY);
	}
}