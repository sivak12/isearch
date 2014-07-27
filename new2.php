<?php
class Crawler {
 
  protected $markup = '';
 
  public function __construct($uri) {
    $this->markup = $this->getMarkup($uri); 
  }
 
  public function getMarkup($uri) {
    return file_get_contents($uri);  
  }

  public function get($type) {
    $method = "_get_{$type}";
    if (method_exists($this, $method)){
      return call_user_method($method, $this);
    }
  }
 
  protected function _get_images() {
    if (!empty($this->markup)){
      preg_match_all('/<img([^>]+)\/>/i', $this->markup, $images);        
      return !empty($images[1]) ? $images[1] : FALSE;
    }
  }
 
  protected function _get_links() {
    if (!empty($this->markup)){
      preg_match_all('/<a.*? href=\"(.*?)\".*?>(.*?)<\/a>/i', $this->markup, $links); 
      return !empty($links[1]) ? $links[1] : FALSE;
    }
  }
}

$site = "http://www.nitrr.ac.in";

set_time_limit(0);

$crawl = new Crawler($site);



$images = $crawl->get('images');
$links = $crawl->get('links');
$lnklst = array();
foreach ($links as $item)
{
		$fpart = explode("#",$item);
		$item = $fpart[0];
		$item = trim($item);
		if($item != "")
		{
			//echo "yes";
			$pos = strpos($item,"http:");
			
			if($pos === false)
				$item = $site."/".$item;
			if(! (in_array($item, $lnklst)) )
				$lnklst[] = $item;
		}

}
foreach ($lnklst as $ent)
{
	echo $ent."<br>";
	if($cont=file_get_contents($ent))
		echo "success<br><br>";
	else
		echo "fail<br><br>";
}

?>