<?php

/*
 * Passle Core: main processor of this plugin
 */

class PassleCore
{
	private $passle_net_base_url;
	
	private $passle_net_staging_cdn_url;
	
	private $passle_net_live_cdn_url;
	
	private $passle_net_xml_feed_url_base;
	
	private $passle_net_xfdd_object_for_this_request;
	
	private $passle_net_passle_shortcode_xsl_file_url;
	
	public function __construct()
	{
		// initialization
		
		$this->passle_net_base_url										= 'https://www.passle.net/';
		
		$this->passle_net_staging_cdn_url								= 'https://di8layzxkraa8.cloudfront.net/';
		
		$this->passle_net_live_cdn_url									= 'https://dyuy9u4fgsah7.cloudfront.net/';
		
		$this->passle_net_xml_feed_url_base								= $this->passle_net_base_url . 'pluginfeed/';
		
		$this->passle_net_passle_shortcode_xsl_file_url					= $this->passle_net_staging_cdn_url . 'Wordpress/XSLT/PassleFeed.xsl';
		
		$this->passle_net_xfdd_object_for_this_request					= null;
		
		// add shortcodes
		
		add_shortcode( 'passle', array( $this, 'passle_shortcode' ) );
	}
	
	/*
	 * [passle] shortcode processor
	 */
	
	public function passle_shortcode( $atts, $content, $tag )
	{
		// example of this shortcode - [passle key="2cxn" number_of_posts="4"]
		
		// validation
		
		$passle_key = '';
		
		$number_of_posts = 0;
		
		if
		(
			!isset( $atts['key'] )
			||
			strlen( $atts['key'] ) == 0
		)
		{
			return '';
		}
		else
		{
			$passle_key = trim( $atts['key'] );
		}
		
		if
		(
			!isset( $atts['number_of_posts'] )
			||
			strlen( $atts['number_of_posts'] ) == 0
			||
			( ( int ) $atts['number_of_posts'] ) <= 0
		)
		{
			$number_of_posts = PASSLE_EMBEDDED_POSTS_PLUGIN_PASSLE_SHORTCODE_DEFAULT_NUMBER_OF_POSTS;
		}
		else
		{
			$number_of_posts = trim( $atts['number_of_posts'] );
		}
		
		// read XML feed into string
		
		$xml_feed_dom_document = $this->get_passle_net_xfdd_object_for_this_request( array( 'passle_key' => $passle_key, 'number_of_posts' => $number_of_posts ) );
		
		if
		(
			$xml_feed_dom_document != null
		)
		{
			// format all "published" dates through whole XML document
			
			$published_elements	= $xml_feed_dom_document->getElementsByTagName( 'published' );
			
			foreach( $published_elements as $published_element )
			{
				$formattedpublished_element = $xml_feed_dom_document->createElement( 'formattedpublished' );
				
				$formattedpublished_element->nodeValue = strftime( '%d %B %Y', strtotime( $published_element->nodeValue ) );
				
				$published_element->parentNode->appendChild( $formattedpublished_element );
			}
			
			// generate URLs for single posts
				
			$entry_elements = $xml_feed_dom_document->getElementsByTagName( 'entry' );
				
			foreach( $entry_elements as $entry_element )
			{
				$feed_entry_title				= '';
			
				$feed_entry_id					= '';
			
				foreach( $entry_element->childNodes as $child_node )
				{
					if( $child_node->nodeName == 'title' )
					{
						$feed_entry_title		= $child_node->nodeValue;
					}
					elseif( $child_node->nodeName == 'id' )
					{
						$feed_entry_id			= $child_node->nodeValue;
					}
				}
			
				$singleposturl = $xml_feed_dom_document->createElement( 'singleposturl' );
			
				$singleposturl->nodeValue = get_bloginfo( 'url' ) . '/' . PASSLE_EMBEDDED_POSTS_PLUGIN_SINGLE_POST_URL_BASE . '/' . $feed_entry_id . '/' . sanitize_title( $feed_entry_title );
			
				$entry_element->appendChild( $singleposturl );
			}
			
			// save all results into string
			
			$xml_for_passle = $xml_feed_dom_document->saveXML();
			
			// read XSL file into string
			
			$passle_shortcode_xsl_dom_document = new DOMDocument();
			
			$passle_shortcode_xsl_dom_document->loadXML( $this->get_raw_xml( $this->passle_net_passle_shortcode_xsl_file_url ) );
			
			$xsl_for_passle = $passle_shortcode_xsl_dom_document->saveXML();
			
			// convert XML to HTML using XSLT technology
			
			$xslt_processor = new XSLTProcessor();
			
			$xslt_processor->importStylesheet( new SimpleXMLElement( $xsl_for_passle ) );
			
			$html_for_passle = $xslt_processor->transformToXml( new SimpleXMLElement( $xml_for_passle ) );
			
			// load CSS file for this shortcode
			
			wp_enqueue_style( 'passle-embedded-posts-plugin-passle-shortcode-published-passle', $this->passle_net_base_url . 'Style/PublishedPassleCSS?passleid=' . trim( $atts['key'] ) );
			
			wp_enqueue_style( 'passle-embedded-posts-plugin-passle-shortcode-google-fonts', '//fonts.googleapis.com/css?family=Goudy+Bookletter+1911|Open+Sans:300,400,600,700|Sansita+One:400,600,700|Satisfy:400,600,700' );
			
			wp_enqueue_style( 'passle-embedded-posts-plugin-passle-shortcode-wordpress-plugin', $this->passle_net_staging_cdn_url . 'Wordpress/css/WordPressPlugin.css' );
			
			wp_enqueue_style( 'passle-embedded-posts-plugin-passle-shortcode-front-end', PASSLE_EMBEDDED_POSTS_PLUGIN_URL . 'css/front-end.css' );
			
			// load JS files for this shortcode
			
			wp_enqueue_script( 'passle-embedded-posts-plugin-passle-shortcode-wpwall', $this->passle_net_staging_cdn_url . 'Wordpress/js/wordpressplugin.js', array(), false, true );
			
			// show the result
			
			require_once( PASSLE_EMBEDDED_POSTS_PLUGIN_PATH . '/html/passle_shortcode.php' );
		}
		
		return '';
	}
	
	/*
	 * Get passle.net XML feed url
	*/
	
	public function get_passle_net_xml_feed_url( $options )
	{
		return $this->passle_net_xml_feed_url_base . $options['passle_key'] . '/1/' . ( int ) $options['number_of_posts'];
	}
	
	/*
	 * Get passle.net XML feed DomDocument object for this request
	*/
	
	public function get_passle_net_xfdd_object_for_this_request( $options )
	{
		if
		(
			( $this->passle_net_xfdd_object_for_this_request == null )
		)
		{
			$this->passle_net_xfdd_object_for_this_request = new DOMDocument();
		
			if
			(
				!$this->passle_net_xfdd_object_for_this_request->loadXML( $this->get_raw_xml( $this->get_passle_net_xml_feed_url( $options ) ) )
			)
			{
				$this->passle_net_xfdd_object_for_this_request = null;
			}
		}
		
		return $this->passle_net_xfdd_object_for_this_request;
	}
	
	/*
	 * Get RAW XML content using cURL library
	*/
	
	private function get_raw_xml( $url )
	{
		$timeout = 5;
		
		$ch = curl_init();
		
		curl_setopt( $ch, CURLOPT_URL, $url );
		
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
		
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		
		$data = curl_exec( $ch );
		
		curl_close( $ch );
		
		return $data;
	}
}

// turn on the core

$passle_core = new PassleCore();