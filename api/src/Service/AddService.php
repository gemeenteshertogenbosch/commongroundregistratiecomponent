<?php
// src/Service/AmbtenaarService.php
namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use GuzzleHttp\Client;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Cache\Adapter\AdapterInterface as CacheInterface;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

use App\Entity\Organisation; 


use App\Service\GithubService; 
use App\Service\GitlabService; 
use App\Service\BitbucketService;
use App\Service\ApiService; 

class AddService
{
	private $params;
	private $cash;
	private $markdown;
	private $em;
	
	private $gitlab;
	private $github;
	private $bitbucket;
	private $api;
	
	public function __construct(
			ParameterBagInterface $params, 
			MarkdownParserInterface $markdown, 
			CacheInterface $cache, 
			EntityManagerInterface $em, 
	    
			GithubService $github, 
			GitlabService $gitlab, 
			BitbucketService $bitbucket,
	        ApiService $api)
	{
		$this->params = $params;
		$this->cash = $cache;
		$this->markdown = $markdown;
		$this->em = $em;
		
		$this->gitlab= $gitlab;
		$this->github= $github;
		$this->bitbucket= $bitbucket;
		$this->api = $api;;
	}
		
	public function add($url)
	{
	    /*@todo this should have an error catch mechanism */
	    $parse = parse_url($url);
	    $host = $parse['host'];
	    
	    switch ($host) {
	        case 'github.com':
	            $responce = $this->github->get($url);
	            break;
	        case 'gitlab.com':
	            $responce = $this->gitlab->get($url);
	            break;
	        case 'bitbucket.com':
	            $responce = $this->bitbucket->get($url);
	            break;
	        default:
	            $responce = $this->api->get($url);
	    }
	    
	    // If we have a valid reponce we presumably want to save it to the database
	    if($responce){
	        $this->em->persist($responce);
	        $this->em->flush();
	    }	    
	    
	    return $responce;
	}	
	
}
