<?php


session_start();


$site = "http://www.nitrr.ac.in";
crawl($site);

function crawl($site)
{
	
	$pages = array();
	$pages[] = $site; 
	
	while($pages)
	{
		$newpages = array();
		
		foreach( $pages as $page)
		{
			addtoIndex($page);
			
			if( ! ($markup = file_get_contents($page)) )
			{
				echo "<br>page fail to open";
				continue;
			}
			
			preg_match_all('/<a.*? href=\"(.*?)\".*?>(.*?)<\/a>/i', $markup,$matches); 
	
			foreach($matches[1] as $item)
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
					if(! (in_array($item, $newpages)) )
						$newpages[] = $item;
				}

			}
			
		}	
		$pages = $newpages;
	}	
}


function addtoindex($page)
{
	echo "indexing:".$page."<br>";
}


?>
