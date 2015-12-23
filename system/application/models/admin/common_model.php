<?
/*Common Model By Aisha Zafar on 28th january 2010*/

class common_model extends Model
{
	function common_model()
	{
		parent::Model();
	}
	

	function show_all_records($table,$orderby)
	{
		$this->db->order_by($orderby);
		$result = $this->db->get($table);
		
		$res = $result->result();
		
		return $res;
	}
	
	function show_records_where($table,$where,$id,$order,$ordertype)
	{	
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where,$id);
		$this->db->order_by($order,$ordertype);
		$result = $this->db->get();
		$res = $result->result();
		return $res;		
	}
	
	function show_records_where22($table,$where,$order,$ordertype)
	{	
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by($order,$ordertype);
		$result = $this->db->get();
		$res = $result->result();
		return $res;		
	}
	

/*	fetchPropertySubTypes to fetch all or selected area By Aisha Zafar on 28th january 2010*/
function fetchPropertySubTypes($property_type)
	{
		$subtypes = "";
		if($property_type!="")
		{
			if($property_type=="houseflat")
			{
				$this->db->where('property_type',"house");		
				$this->db->or_where('property_type',"flat");		
			}	
			else
				$this->db->where('property_type',$property_type);		
		}
		$getsubtypes = $this->db->get("property_sub_type");
		$subtypes = $getsubtypes->result();
		return $subtypes;
	}

		/* ----------  Delete Record 29/01/2010 By Aisha Zafar -------*/
		function deleteRecord($tableName,$condition)
		{			
				
				if($this->db->delete($tableName, $condition))
				return true;
			 
		}
		/* ---------- End of Delete Record ----------------*/
		
			

	function delete_r($table,$field,$id)
	{
		$this->db->where($field, $id);
		$this->db->delete($table);
	}
	
	function insert_record($table,$data)

	{

		$this->db->insert($table, $data); 

		return mysql_insert_id();	

	}
		

}
?>