<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LinksDataController extends Controller
{

    public function index(Request $request)
    {
		$site_url = 'https://rurera.com/';
		$site_page_url = 'https://rurera.com';
        $page_content = file_get_contents($site_url);
		$links_array = $this->getAnchorHrefs($page_content, $site_url);
		
		$counter = 0;
		$pages_data = array();
		if( !empty( $links_array ) ){
			foreach( $links_array as $page_link){
				if($counter > 1){
					continue;
				}
				$page_link = $site_page_url.$page_link;
				$page_content = file_get_contents($page_link);
				$pages_data[$page_link]	= $this->getImagesData($page_content);
				
				$counter++;
				
			}
		}
        $data = [
            'pageTitle'       => 'Pages Data',
            'pageDescription' => 'Pages Data',
            'pageRobot'       => 'NOODP, nofollow, noindex',
            'pages_data'          => $pages_data,
        ];
        return view('web.default.pages.links_data', $data);
    }
	
	public function getAnchorHrefs($contentData, $site_url)
	{
		// Initialize a new DOMDocument instance
		$dom = new \DOMDocument();
		
		// Suppress errors due to malformed HTML
		libxml_use_internal_errors(true);
		
		// Load the HTML content into the DOMDocument
		$dom->loadHTML($contentData);
		
		// Clear any libxml errors
		libxml_clear_errors();
		
		// Initialize a new DOMXPath instance
		$xpath = new \DOMXPath($dom);
		
		// Query all anchor tags with href attributes
		$anchorTags = $xpath->query("//a[@href]");
		
		// Prepare an array to hold the hrefs
		$hrefs = [];
		
		// Loop through each found anchor tag and extract the href attribute
		foreach ($anchorTags as $tag) {
			if( $tag->getAttribute('href') == $site_url || $tag->getAttribute('href') == '#'){
				continue;
			}
			$hrefs[] = $tag->getAttribute('href');
		}
		
		return $hrefs;
	}
	
	public function getImagesData($contentData)
	{
		// Initialize a new DOMDocument instance
		$dom = new \DOMDocument();
		
		// Suppress errors due to malformed HTML
		libxml_use_internal_errors(true);
		
		// Load the HTML content into the DOMDocument
		$dom->loadHTML($contentData);
		
		// Clear any libxml errors
		libxml_clear_errors();
		
		// Initialize a new DOMXPath instance
		$xpath = new \DOMXPath($dom);
		
		// Query all anchor tags with href attributes
		$anchorTags = $xpath->query("//img[@src]");
		
		// Prepare an array to hold the hrefs
		$images_array = [];
		
		// Loop through each found anchor tag and extract the href attribute
		foreach ($anchorTags as $tag) {
			$images_array[] = array(
				'src' => $tag->getAttribute('src'),
				'alt' => $tag->getAttribute('alt'),
				'title' => $tag->getAttribute('title'),
				'height' => $tag->getAttribute('height'),
				'width' => $tag->getAttribute('width'),
			);
		}
		
		return $images_array;
	}



}
