<? if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_translation($id){
	$ci =& get_instance(); 
	$ci->load->database();
	$query=$ci->db->query("SELECT
		misc_translations.en,
		misc_translations.ru,
		misc_translations.go
		FROM
		misc_translations
		WHERE
		misc_translations.id = '$id'");	
	$row = $query->row(); 
	
	if($ci->session->userdata('locale')=='ru'){
		return $row->ru;
	}else if($ci->session->userdata('locale')=='go'){
		return $row->go;
	}else{
		return $row->en;
	}
	return 'sdad';
}
?>