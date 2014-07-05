<?php
/**
 * Asset Manager Class. Handles loading image MIME types, returning a php
 * header for the required resource.
 * 
 * Supported MIME types are:
 * - image/png
 * - image/jpg
 * - image/gif
 * - image/bmp
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.1 2014-07-02
 */
class AssetManager{
	
	/** 
	 * Associative array of Mime types based on file suffix 
	 * @var mixed 
	 */
	
	private static $MIME_TYPES = array("png" => "image/png",
			"jpg" => "image/jpg", "jpeg" => "image/jpg", 
			"gif" => "image/gif", "bmp" => "image/bmp",
			"mp3" => "audio/mp3", ""=>"");
	
	/** 
	 * The directory (specified from root of installation)
	 * 
	 * @var string directory path 
	 */
	private $directory  = "";
	
	/**
	 * The thumbnail sizes for images
	 * 
	 * @var mixed array of (key=>array(int,int)) pairs
	 */
	private $thumb_size = array();

	/**
	 * Constructs an instance of AssetManager that handles assets
	 * relative to the specified directory.
	 * The $asset_directory should not end in file separator.
	 * 
	 * @param string $asset_directory directory of assets (Relative to root)
	 */
	public function __construct( $asset_directory ){
		//register_shutdown_function( array( $this, '__destruct' ) );
		//$this->directory = ROOT . $asset_directory . DIRECTORY_SEPARATOR;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function __destruct(){
		return true;
	}
	
	// -----------------------------------------------------------------------
	
	/**
	 * Gets and returns the specified asset based on its
	 * MIME type. Image types are returned as PHP headers,
	 * videos/music are returned as corresponding 
	 * 
	 * @param string $asset_name name of the asset
	 * @param string $mime_type MIME type of the asset
	 */
	public function get_asset($asset_name, $mime_type=null){
		if(!isset($mime_type))
			$mime_type = AssetManager::_get_mime_type($asset_name);
		$file = "";
		if( !file_exists($file) ) 
			throw new Exception("Asset '" . $asset_name . "' not found.");
		$content['type'] = $mime_type;
		$content['length'] = filesize($file);
		$content['disposition'] = 'attachment; filename="' . $asset_name .'"';
		
		return $content;
		/*
		header('Content-Type:' . $mime_type);
		header('Content-Length: ' . filesize($file));
		header('Content-Disposition: attachment; filename="' . $asset_name .'"');
		readfile($file);*/
	}
	
	/**
	 * Add thumbnail size to the asset manager. Setting width or height to 0
	 * causes the height or width to scale respectively.
	 * Setting both to 0 will throw an exception
	 * 
	 * @param string $identifier Unique identifier of the thumbnail size
	 * @param int $width width of the thumbnail
	 * @param int $height height of the thumbnail
	 */
	public function add_thumb_size($identifier, $width, $height){
		if($width==$height && $height==0)
			throw new Exception("Invalid thumbnail size specified");
		$this->thumb_size[$identifier] = array($width, $height);
	}
	
	/**
	 * Gets the MIME type of the file
	 * 
	 * @param string $file filename
	 * @return string mime type of file
	 */
	private static function _get_mime_type($file){
		$path_info = pathinfo($file);
		$extension = strtolower($path_info['extension']);
		return "image/png";
	}
	
	/**
	 * 
	 * 
	 * @param string $file path to file to resize
	 */
	private function _generate_thumbnails($file){
		
	}
} 
?>