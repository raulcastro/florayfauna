<?php

$root = $_SERVER['DOCUMENT_ROOT'];

/**
 * Includes the file /models/Layout_Model.php 
 * in order to interact with the database
 */
require_once $root.'/models/Layout_Model.php';


/**
 * Contains the classes for access to the basic app info without log-in
 *
 * @package    Reservation System
 * @subpackage Tropical Casa Blanca Hotel
 * @license    http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author     Raul Castro <rd.castro.silva@gmail.com>
 */
class generalFrontBackend
{
	protected  $model;
	
	/**
	 * Initialize a class, the model one
	 */
	public function __construct()
	{
		$this->model = new Layout_Model();
	}
	
	/**
	 * Based on the section it returns the right info that could be propagated along the application
	 * 
	 * @param string $section
	 * @return array Array with the asked info of the application 
	 */
	public function loadBackend($section = '')
	{
		$data 		= array();
		
// 		Info of the Application
		
		$appInfoRow = $this->model->getGeneralAppInfo();
		
		$appInfo = array( 
				'title' 		=> $appInfoRow['title'],
				'siteName' 		=> $appInfoRow['site_name'],
				'url' 			=> $appInfoRow['url'],
				'content' 		=> $appInfoRow['content'],
				'description'	=> $appInfoRow['description'],
				'keywords' 		=> $appInfoRow['keywords'],
				'location'		=> $appInfoRow['location'],
				'creator' 		=> $appInfoRow['creator'],
				'creatorUrl' 	=> $appInfoRow['creator_url'],
				'twitter' 		=> $appInfoRow['twitter'],
				'facebook' 		=> $appInfoRow['facebook'],
				'googleplus' 	=> $appInfoRow['googleplus'],
				'pinterest' 	=> $appInfoRow['pinterest'],
				'linkedin' 		=> $appInfoRow['linkedin'],
				'youtube' 		=> $appInfoRow['youtube'],
				'instagram'		=> $appInfoRow['instagram'],
				'email'			=> $appInfoRow['email'],
				'lang'			=> $appInfoRow['lang']
		);
		
		$data['appInfo'] = $appInfo;
		
		$espaciosArray 		= $this->model->getEspacios();
		$data['espacios'] 	= $espaciosArray;

		switch ($section)
		{
			case 'index':
				$bannerArray 		= $this->model->getBanner();
				$data['banner'] 	= $bannerArray;
				
				$aliadosArray 		= $this->model->getAliados();
				$data['aliados'] 	= $aliadosArray;
				
				$topArray			= $this->model->getCausas();
				$data['causas']		= $topArray;
				
				$linksArray			= $this->model->getLinks();
				$data['links']		= $linksArray;
				
				$noticiasArray		= $this->model->getLastTwoNews();
				$data['noticias'] 	= $noticiasArray;
				
			break;
			
			case 'causas':
				$sectionRow = $this->model->getSingleCausas($_GET['sectionId']);
				$data['section'] = $sectionRow;
				
				switch ($_GET['sectionId'])
				{
					case 100:
						$newsArray 		= $this->model->getLastConservacionTwoNews();
						$data['news'] 	= $newsArray;
					break;
					
					case 101:
						$newsArray 		= $this->model->getLastBienestarTwoNews();
						$data['news'] 	= $newsArray;
					break;
					
					case 102:
						$newsArray 		= $this->model->getLastEducacionTwoNews();
						$data['news'] 	= $newsArray;
					break;
				}
			break;
			
			case 'all-causas':
				$topArray			= $this->model->getCausas();
				$data['causas']		= $topArray;
			break;
			
			case 'espacios':
				$sectionRow = $this->model->getEspaciosByEspacioId($_GET['sectionId']);
				$data['section'] = $sectionRow;
				
				$bloquesArray = $this->model->getEspaciosBloques($_GET['sectionId']);
				$data['bloques'] = $bloquesArray;
			break;
			
			case 'noticia':
				$sectionRow = $this->model->getNewsById($_GET['sectionId']);
				$data['section'] = $sectionRow;
				
				$galleryArray = $this->model->getNewsGallery($_GET['sectionId']);
				$data['gallery'] = $galleryArray;
				
				$videosArray = $this->model->getNewsVideo($_GET['sectionId']);
				$data['videos'] = $videosArray;
			break;
			
			case 'directorio':
				$directorioArray = $this->model->getDirectorio();
				$data['directorio'] = $directorioArray;
			break;
			
			case 'aliados':
				$slidersArray 		= $this->model->getAliados();
				$data['aliados'] 	= $slidersArray;
			break;
			
			case 'que-hacemos':
				$topArray			= $this->model->getCausas();
				$data['causas']		= $topArray;
			break;
			
			default:
			break;
		}
		
		return $data;
	}
}

$backend = new generalFrontBackend();

