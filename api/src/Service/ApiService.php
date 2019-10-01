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

class ApiService
{
	private $params;
	private $cash;
	private $markdown;
	private $em;
	private $gitlab;
	private $github;
	private $bitbucket;
	private $user;
	
	public function __construct(
			ParameterBagInterface $params, 
			MarkdownParserInterface $markdown, 
			CacheInterface $cache, 
			EntityManagerInterface $em, 
			GithubService $github, 
			GitlabService $gitlab, 
			BitbucketService $bitbucket,
			Security $security)
	{
		$this->params = $params;
		$this->cash = $cache;
		$this->markdown = $markdown;
		$this->em = $em;
		$this->gitlab= $gitlab;
		$this->github= $github;
		$this->bitbucket= $bitbucket;
		$this->user = $security->getUser();;
	}	
	
	public function get($url)
	{
	    
	}
	
}
