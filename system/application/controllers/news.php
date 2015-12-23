<?php

class News extends Controller {
	

	
	function __construct()
	{
		parent::Controller();
		$this->locale = $this->session->userdata('locale');
		if($this->locale==''){
			$this->locale='en';
			$this->session->set_userdata('locale','en');
		}	
		$this->footer_query=$this->db->query("SELECT * FROM manage_footer WHERE id ='1'");
		if($this->locale=='ru'){
			$this->footer_news_query=$this->db->query("SELECT
			news.image,
			news.posting_date,
			news_translations.title,
			news.page_name,
			news_translations.content
			FROM
			news
			INNER JOIN news_translations ON news.id = news_translations.news_id
			WHERE
			news.isactive = 1 AND
			news_translations.tr_key = 'ru'
			ORDER BY
			news.posting_date DESC
			LIMIT 0, 2");
			$this->hearder_query=$this->db->query("SELECT
			tblpages.id,
			tblpages.pagename,
			tblpages.icon_class,
			tblpages_tranlations.title
			FROM
			tblpages
			INNER JOIN tblpages_tranlations ON tblpages.id = tblpages_tranlations.page_id
			WHERE
			tblpages.parent = '0' AND
			tblpages.isActive = '1' AND
			tblpages_tranlations.tr_key = 'ru' AND
			(tblpages.position = 'handf' OR
			tblpages.position = 'header') 
			order by seqno asc");
			$this->footer_links_query=$this->db->query("SELECT tblpages.id,
			tblpages.pagename, tblpages_tranlations.title FROM tblpages INNER JOIN tblpages_tranlations ON tblpages.id = tblpages_tranlations.page_id WHERE tblpages.isActive='1' and tblpages_tranlations.tr_key = 'ru' AND (tblpages.position='handf' OR tblpages.position = 'footer') order by seqno asc");
		}else if($this->locale=='go'){
			$this->footer_news_query=$this->db->query("SELECT
			news.image,
			news.posting_date,
			news.page_name,
			news_translations.title,
			news_translations.content
			FROM
			news
			INNER JOIN news_translations ON news.id = news_translations.news_id
			WHERE
			news.isactive = 1 AND
			news_translations.tr_key = 'go'
			ORDER BY
			news.posting_date DESC
			LIMIT 0, 2");
			$this->hearder_query=$this->db->query("SELECT
			tblpages.id,
			tblpages.pagename,
			tblpages.icon_class,
			tblpages_tranlations.title
			FROM
			tblpages
			INNER JOIN tblpages_tranlations ON tblpages.id = tblpages_tranlations.page_id
			WHERE
			tblpages.parent = '0' AND
			tblpages.isActive = '1' AND
			tblpages_tranlations.tr_key = 'go' AND
			(tblpages.position = 'handf' OR
			tblpages.position = 'header') 
			order by seqno asc");
			$this->footer_links_query=$this->db->query("SELECT tblpages.id,
			tblpages.pagename, tblpages_tranlations.title FROM tblpages INNER JOIN tblpages_tranlations ON tblpages.id = tblpages_tranlations.page_id WHERE tblpages.isActive='1' and tblpages_tranlations.tr_key = 'go' AND (tblpages.position='handf' OR tblpages.position = 'footer') order by seqno asc");
		}else{
			$this->footer_news_query=$this->db->query("SELECT
			news.title,
			news.content,
			news.image,
			news.page_name,
			news.posting_date
			FROM
			news
			WHERE
			news.isactive = 1
			ORDER BY
			news.posting_date DESC
			LIMIT 0, 2");
			$this->hearder_query=$this->db->query("SELECT id, title, pagename, icon_class FROM tblpages WHERE parent = '0' and isActive='1' and (position='handf' OR position = 'header') order by seqno asc");
			$this->footer_links_query=$this->db->query("SELECT id, title, pagename FROM tblpages WHERE isActive='1' and (position='handf' OR position = 'footer') order by seqno asc");
		}
	}
	
	function index($row=1)
	{
		$data['curpage'] = $row;

		$data['range'] = 5;
		
		$data['trows']=$this->db->count_all("news");
		
		$perpage = 10;
		
		$data['tpages'] = ceil($this->db->count_all("news") / $perpage);
		$offset = ($row - 1) * $perpage;
		
		if($this->locale=='ru'){
			$page_query=$this->db->query("SELECT
				tblpages_tranlations.title,
				tblpages_tranlations.content,
				tblpages_tranlations.meta_decrip,
				tblpages_tranlations.meta_keywords,
				tblpages_tranlations.meta_title
				FROM
				tblpages
				INNER JOIN tblpages_tranlations ON tblpages.id = tblpages_tranlations.page_id
				WHERE
				tblpages.pagename = 'news' AND
				tblpages_tranlations.tr_key = 'ru'
			");			
			$data['news_query'] = $this->db->query("SELECT
				news.page_name,
				news.posting_date,
				news.image,
				news.id,
				news_translations.title,
				news_translations.content
				FROM
				news
				INNER JOIN news_translations ON news.id = news_translations.news_id
				WHERE
				news.isactive = '1' AND
				news_translations.tr_key = 'ru'
				ORDER BY
				news.posting_date DESC LIMIT ".$offset.", ".$perpage);
		}else if($this->locale=='go'){
			$page_query=$this->db->query("SELECT
				tblpages_tranlations.title,
				tblpages_tranlations.content,
				tblpages_tranlations.meta_decrip,
				tblpages_tranlations.meta_keywords,
				tblpages_tranlations.meta_title
				FROM
				tblpages
				INNER JOIN tblpages_tranlations ON tblpages.id = tblpages_tranlations.page_id
				WHERE
				tblpages.pagename = 'news' AND
				tblpages_tranlations.tr_key = 'go'
			");	
			$data['news_query'] = $this->db->query("SELECT
				news.page_name,
				news.posting_date,
				news.image,
				news.id,
				news_translations.title,
				news_translations.content
				FROM
				news
				INNER JOIN news_translations ON news.id = news_translations.news_id
				WHERE
				news.isactive = '1' AND
				news_translations.tr_key = 'go'
				ORDER BY
				news.posting_date DESC LIMIT ".$offset.", ".$perpage);
		}else{
			$page_query=$this->db->query("SELECT
			tblpages.id,
			tblpages.title,
			tblpages.content,
			tblpages.meta_decrip,
			tblpages.meta_keywords,
			tblpages.meta_title
			FROM
			tblpages
			WHERE
			tblpages.pagename = 'news'
			");	
			$data['news_query'] = $this->db->query("SELECT
			news.id,
			news.title,
			news.content,
			news.page_name,
			news.posting_date,
			news.image
			FROM
			news
			WHERE
			news.isactive = '1'
			ORDER BY
			news.posting_date DESC LIMIT ".$offset.", ".$perpage);
		}
		$row = $page_query->row(); 
		$data['meta_tilte']=stripslashes($row->meta_title);
		$data['meta_keywords']=stripslashes($row->meta_keywords);
		$data['meta_decription']=stripslashes($row->meta_decrip);	
		$data['pagecontent'] = stripslashes($row->content);
		$data['pageheading'] =  stripslashes($row->title);
		$data['locale']=$this->locale;
		$data['footer_query']=$this->footer_query;
		$data['footer_news_query']=$this->footer_news_query;
		$data['header_query']=$this->hearder_query;
		$data['footer_links_query'] = $this->footer_links_query;	
		$data['main_content'] = 'news';	
		$data['controler_name']='news';
		$this->load->view('includes/template', $data);			
	}
	
	function page($row=1)
	{
		$data['curpage'] = $row;

		$data['range'] = 5;
		
		$data['trows']=$this->db->count_all("news");
		
		$perpage = 10;
		
		$data['tpages'] = ceil($this->db->count_all("news") / $perpage);
		$offset = ($row - 1) * $perpage;
		
		if($this->locale=='ru'){
			$page_query=$this->db->query("SELECT
				tblpages_tranlations.title,
				tblpages_tranlations.content,
				tblpages_tranlations.meta_decrip,
				tblpages_tranlations.meta_keywords,
				tblpages_tranlations.meta_title
				FROM
				tblpages
				INNER JOIN tblpages_tranlations ON tblpages.id = tblpages_tranlations.page_id
				WHERE
				tblpages.pagename = 'news' AND
				tblpages_tranlations.tr_key = 'ru'
			");			
			$data['news_query'] = $this->db->query("SELECT
				news.page_name,
				news.posting_date,
				news.image,
				news.id,
				news_translations.title,
				news_translations.content
				FROM
				news
				INNER JOIN news_translations ON news.id = news_translations.news_id
				WHERE
				news.isactive = '1' AND
				news_translations.tr_key = 'ru'
				ORDER BY
				news.posting_date DESC LIMIT ".$offset.", ".$perpage);
		}else if($this->locale=='go'){
			$page_query=$this->db->query("SELECT
				tblpages_tranlations.title,
				tblpages_tranlations.content,
				tblpages_tranlations.meta_decrip,
				tblpages_tranlations.meta_keywords,
				tblpages_tranlations.meta_title
				FROM
				tblpages
				INNER JOIN tblpages_tranlations ON tblpages.id = tblpages_tranlations.page_id
				WHERE
				tblpages.pagename = 'news' AND
				tblpages_tranlations.tr_key = 'go'
			");	
			$data['news_query'] = $this->db->query("SELECT
				news.page_name,
				news.posting_date,
				news.image,
				news.id,
				news_translations.title,
				news_translations.content
				FROM
				news
				INNER JOIN news_translations ON news.id = news_translations.news_id
				WHERE
				news.isactive = '1' AND
				news_translations.tr_key = 'go'
				ORDER BY
				news.posting_date DESC LIMIT ".$offset.", ".$perpage);
		}else{
			$page_query=$this->db->query("SELECT
			tblpages.id,
			tblpages.title,
			tblpages.content,
			tblpages.meta_decrip,
			tblpages.meta_keywords,
			tblpages.meta_title
			FROM
			tblpages
			WHERE
			tblpages.pagename = 'news'
			");	
			$data['news_query'] = $this->db->query("SELECT
			news.id,
			news.title,
			news.content,
			news.page_name,
			news.posting_date,
			news.image
			FROM
			news
			WHERE
			news.isactive = '1'
			ORDER BY
			news.posting_date DESC LIMIT ".$offset.", ".$perpage);
		}
		$row = $page_query->row(); 
		$data['meta_tilte']=stripslashes($row->meta_title);
		$data['meta_keywords']=stripslashes($row->meta_keywords);
		$data['meta_decription']=stripslashes($row->meta_decrip);	
		$data['pagecontent'] = stripslashes($row->content);
		$data['pageheading'] =  stripslashes($row->title);
		$data['locale']=$this->locale;
		$data['footer_query']=$this->footer_query;
		$data['footer_news_query']=$this->footer_news_query;
		$data['header_query']=$this->hearder_query;
		$data['footer_links_query'] = $this->footer_links_query;	
		$data['main_content'] = 'news';	
		$data['controler_name']='news';
		$this->load->view('includes/template', $data);			
	}
	
	function details($pagename){
		if($this->locale=='ru'){
			$news_query = $this->db->query("SELECT
				news.image,
				news_translations.title,
				news_translations.content,
				news_translations.meta_title,
				news_translations.meta_keywords,
				news_translations.meta_decrip
				FROM
				news
				INNER JOIN news_translations ON news.id = news_translations.news_id
				WHERE
				news.page_name = '$pagename' AND
				news_translations.tr_key = 'ru'");
		}else if($this->locale=='go'){
			$news_query = $this->db->query("SELECT
				news.image,
				news_translations.title,
				news_translations.content,
				news_translations.meta_title,
				news_translations.meta_keywords,
				news_translations.meta_decrip
				FROM
				news
				INNER JOIN news_translations ON news.id = news_translations.news_id
				WHERE
				news.page_name = '$pagename' AND
				news_translations.tr_key = 'go'");
		}else{
			$news_query = $this->db->query("SELECT
			news.title,
			news.content,
			news.image,
			news.meta_title,
			news.meta_keywords,
			news.meta_decrip
			FROM
			news
			WHERE
			news.page_name = '$pagename'");
		}
		$row = $news_query->row();
		$data['meta_tilte']=stripslashes($row->meta_title);
		$data['meta_keywords']=stripslashes($row->meta_keywords);
		$data['meta_decription']=stripslashes($row->meta_decrip);	
		$data['pagecontent'] = stripslashes($row->content);
		$data['pageheading'] =  stripslashes($row->title);
		$data['image'] =  stripslashes($row->image);
		$data['locale']=$this->locale;
		$data['footer_query']=$this->footer_query;
		$data['footer_news_query']=$this->footer_news_query;
		$data['header_query']=$this->hearder_query;
		$data['footer_links_query'] = $this->footer_links_query;	
		$data['main_content'] = 'news_details';	
		$this->load->view('includes/template', $data);
	}
	
	
}