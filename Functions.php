<?php

class Functions {

	public static function escape($input)
	{
		return htmlspecialchars(strip_tags($input));
	}

	public static function bindAll($values, $stmt, $exceptions = [])
	{
		foreach ($values as $key => $value) {
			$paramName = is_numeric($key) ? $key + 1 : ':' . $key;

			$type = isset($exceptions[$key]) ? $exceptions[$key] : gettype($value);

			switch ($type) {
				case 'boolean':
					$typeConst = PDO::PARAM_BOOL;
					break;
				case 'NULL':
					$typeConst = PDO::PARAM_NULL;
					break;
				case 'integer':
					$typeConst = PDO::PARAM_INT;
					break;
				case 'double':
				case 'string':
					$typeConst = PDO::PARAM_STR;
					break;
			}

			$stmt->bindValue($paramName, $value, $typeConst);
		}
	}

	public static function renderTable($content, $headers = [], $exceptions = [])
	{
		$html = '';

		if (!empty($headers)) {
			$html .= '<tr class="table-headers">';
			foreach ($headers as $key => $header) {
				$html .= "<th class=\"table-header $key\">" . self::escape($header) . '</th>';
			}
			$html .= '</tr>';
		}

		foreach ($content as $row) {
			$html .= '<tr>';
			foreach ($row as $key => $column) {
				if (in_array($key, $exceptions, true)) continue;
				$html .= "<td class=\"$key\">" . self::escape($column) . '</td>';
			}
			$html .= '</tr>';
		}

		return $html;
	}
}