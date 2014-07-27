<?php


session_start();


$con = mysql_connect("localhost","root","");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }


mysql_select_db("isearch", $con);

$site = $_POST['txtName'];
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
			echo "page in loop:".$page."<br>";
			addtoIndex($page);
			try
			{
				$markup = file_get_contents($page);
			}
			catch (Exception $e) {
				echo 'Caught exception: ',  $e->getMessage(), "\n";
				continue;
			}
			preg_match_all("/<a.*? href=\"(.*?)\".*?>(.*?)<\/a>/i",$markup,$matches);
			
			foreach($matches[1] as $item)
			{
				//print "item:".$item."<br>";
				$fpart = explode("#", $item);
				$add = $fpart[0];
				$add = trim($add);
				
				//echo "add after trimmed:".$add."<br>";
			
				if($add != "")
				{
					$pos = strpos($add,"http:");
					//print "position:".$pos."<br><br>";
					if($pos === false)
					{
						
						$add = $site."/".$add;
						echo "http not present.. so:".$add."<br>";
					
					}

					$newpages[] = $add;
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
	
function isindexed($add)
{
	return false;
}
	
/*class Crawler 
{
 
  protected $markup = '';
 
  public function __construct($uri) 
  {
    $this->markup =file_get_contents($uri); 
  
  }
 
   
  
 
  protected function get_links() 
  {
    if (!empty($this->markup))
	{
      preg_match_all('/<a([^>]+)\>(.*?)\<\/a\>/i', $this->markup, $links); 
      return !empty($links[1]) ? $links[1] : FALSE;
    }
  }
  
}

$crawl = new Crawler($site);
$links = $crawl->get_links();

echo $links;*/


?>












<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $_SESSION['hdr'] ?>/title>
<LINK REL="SHORTCUT ICON" HREF="logo.ico" />
<link type="text/css" rel="stylesheet" href="oats_p3.css" /> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>

<body>
<div id="all">
		
		<div id="header">
			<h1 class="no_br"><?php 
			echo $_SESSION['hdr']."  <span id='ver'>Beta</span>"; 
			echo "<br><span id='sub_hdr'>Search</span>";?></h1>
			
			<!--<h1 class="caption"> Questionnaire</h1>	-->
		</div>
		
		
		
		<div id="content">
		
			<h1 class="caption">Site Crawling </h1>
			
			<table>
			
				<tr>
					<th>
						<?php echo "site :".$site; ?>
					</th>
					<th>
						Created By
					</th>
					<th>
						Starts On
					</th>
					<th>
						Ends On
					</th>
				</tr>
				
				
				
				<?php 
					
					$respondent=$_SESSION['uname'];
					$sect_id = $_SESSION['sect_id'];
					$resp_id = $_SESSION['stud_id'];
					
					
					while($row=mysql_fetch_array($retid)) 
					{
					//$_SESSION['qnr_id']=$row['sno'];
					
						$grp_str = $row['trg_sect_ids'];					
						
						$grp_lst = explode(",",$grp_str);
						
						$flag = false;
						foreach ($grp_lst as $grp)
						{
							if($grp == $sect_id)
							 {
							 	$flag = true;
								break;
							}
						}
						
						if($flag)
						{
						
							$table_report="tb_qnr".$row['sno']."_report";
	
							$result=mysql_query("SELECT * FROM $table_report WHERE resp_id='$resp_id'");
							$count=mysql_num_rows($result);
	
						
								
									if($count==0) 
									{
										echo "
										<tr>
								
											<td>";
										
										
										
										echo "<a href=\"ans_ent.php?id=" . $row["sno"] . "\" target=\"_self\" >"
										
										.$row['name']
										."</a>";
										
									
									
										echo"</td>
								
										<td>".
											$row['created_by']
										."</td>
										
										<td>".
											$row['start_on']
										."</td>
										
										<td>".
											$row['end_on']
										."</td>
									
									</tr>";
							}
						}
					}
				?>           

			</table>
		</div>

	</div>	
	
</body>
</html>
