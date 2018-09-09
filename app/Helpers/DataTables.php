<?php
/**
 * Created by: chungvh
 * Date: 05/06/2018
 * Time: 17:29
 */

namespace App\Helpers;


class DataTables {
	/**
	 * lấy link tới file dịch của datatable
	 * danh sách: https://datatables.net/plug-ins/i18n/
	 * có thể thay đổi thành file local để tiện sưa đổi
	 * @return string
	 */
	public static function getTranslateUrl () {
		$lang = \Session::get('locale');
		switch ($lang) {
			case 'vi':
				return '//cdn.datatables.net/plug-ins/1.10.16/i18n/Vietnamese.json';
			case 'en':
				return '//cdn.datatables.net/plug-ins/1.10.16/i18n/English.json';
			case 'zh':
				return '//cdn.datatables.net/plug-ins/1.10.16/i18n/Chinese.json';
			default:
				return '//cdn.datatables.net/plug-ins/1.10.16/i18n/Vietnamese.json';
		}
	}
}