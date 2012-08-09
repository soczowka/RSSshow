<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="pl" />
</head>
<body>

<?
isset($_GET['szukaj']) && $_GET['szukaj'] != '' 
    ? $szukaj = $_GET['szukaj'] 
    : die('Nie podano wymaganego parametru "szukaj"');

$url = 'http://xlab.pl/feed';

if(!@fopen($url,'r'))
{
    die('Nie udalo się pobrać pliku RSS');
}
else
{
    $xml = new SimpleXMLElement($url, null, true);
    $szukaj = '/'.$szukaj.'/';
   
    setlocale(LC_ALL, 'pl_PL', 'pl', 'Polish_Poland.28592');
    foreach($xml->channel->item as $v)
    {        
        if (preg_match($szukaj, $v->description))
        {
            // %e nie działa na windows 
            $data = iconv('ISO-8859-2', 'UTF-8', strftime('%d %B %Y %H:%M', strtotime($v->pubDate)));
            
            echo '<div>
                    <p><b>'.$v->title.'</b><br />'.$data.'</p>
                    <p>'.$v->description.'</p>
                  </div>';            
        }        
    }
}
?>
</body>