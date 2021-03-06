<?php

namespace App\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\MaxDepth;


use App\Controller\ComponentController;
use App\Controller\Add;


/**
 * A Component
 *
 * @category   	Entity
 *
 * @author     	Ruben van der Linde <ruben@conduction.nl>
 * @license    	EUPL 1.2 https://opensource.org/licenses/EUPL-1.2 
 * @version    	1.0
 *
 * @link   		http//:www.conduction.nl
 * @package		Common Ground Component
 * @subpackage  Commonground Registratie Component (CGRC)
 *  
 * @ApiResource(
 *  normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *  denormalizationContext={"groups"={"write"}, "enable_max_depth"=true},
 *  collectionOperations={
 *  	"get",
 *      "add" ={
 *         "method"="POST",
 *         "path"="/add",    
 *         "controller"=Add::class,
 *         "read"=false,
 *         "output"=false
 *     }
 *  },
 * 	itemOperations={
 *     "refresh" ={
 *         "method"="POST",
 *         "path"="/components/{id}/refresh",    
 *         "controller"=ComponentRefresh::class
 *     },
 *     "get"
 *  }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ComponentRepository")
 */
class Component
{
    /**
     * @var \Ramsey\Uuid\UuidInterface $id The UUID identifier of this object
     * @example e2984465-190a-4562-829e-a8cca81aa35d
     *
     * @ApiProperty(
     * 	   identifier=true,
     *     attributes={
     *         "swagger_context"={
     *         	   "description" = "The UUID identifier of this object",
     *             "type"="string",
     *             "format"="uuid",
     *             "example"="e2984465-190a-4562-829e-a8cca81aa35d"
     *         }
     *     }
     * )
     *
     * @Assert\Uuid
     * @Groups({"read"})
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
	 * @var string $name The name of this component
     * @example My component
	 *
	 * @ApiProperty(
     * 	   iri="http://schema.org/name",
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The name of this component",
	 *             "type"="string",
	 *             "example"="My component",
	 *             "maxLength"=255,
	 *             "required" = true
	 *         }
	 *     }
	 * )
	 * 
     * @Assert\NotNull
     * @Assert\Length(
     *      max = 255
     * )
	 * @Groups({"read"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
	 * @var string $description An short description of this component
     * @example This is the best component ever
	 *
	 * @ApiProperty(
     * 	   iri="https://schema.org/description",
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "An short description of this component",
	 *             "type"="string",
	 *             "example"="This is the best component ever",
	 *             "maxLength"=2550
	 *         }
	 *     }
	 * )
	 * 
     * @Assert\Length(
     *      max = 2550
     * )
	 * @Groups({"read"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
	 * @var string $logo The logo for this component
     * @example https://www.my-organisation.com/logo.png
	 *
	 * @ApiProperty(
     * 	   iri="https://schema.org/logo",
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The logo for this component",
	 *             "type"="string",
     *             "format"="url",
	 *             "example"="https://www.my-organisation.com/logo.png",
	 *             "maxLength"=255
	 *         }
	 *     }
	 * )
	 * 
     * @Assert\Url
     * @Assert\Length(
     *      max = 255
     * )
	 * @Groups({"read"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
	 * @var string $version The current production version of this component
     * @example v0.1.2.3-beta
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The current production version of this component",
	 *             "type"="string",
     *             "format"="url",
	 *             "example"="v0.1.2.3-beta",
	 *             "maxLength"=255
	 *         }
	 *     }
	 * )
	 * 
     * @Assert\Length(
     *      max = 255
     * )
	 * @Groups({"read"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $version;

    /**
	 * @var string $slug The slug for this component
     * @example my-organisation
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The slug for this component",
	 *             "type"="string",
	 *             "example"="my-organisation",
	 *             "maxLength"=255
	 *         }
	 *     }
	 * )
	 * 
     * @Gedmo\Slug(fields={"name"})
     * @Assert\Length(
     *      max = 255
     * )
	 * @Groups({"read"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
	 * @var string $git The link to the git repository for this component
     * @example https://www.github.com/my-organisation/my-component.git
	 *
	 * @ApiProperty(
     * 	   iri="https://schema.org/url",
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The link to the git repository for this component",
	 *             "type"="string",
     *             "format"="url",
	 *             "example"="https://www.github.com/my-organisation/my-component.git",
	 *             "maxLength"=255,
	 *             "required" = true
	 *         }
	 *     }
	 * )
	 * 
     * @Assert\NotNull
     * @Assert\Url
     * @Assert\Length(
     *      max = 255
     * )
	 * @Groups({"read"})
     * @ORM\Column(type="string", length=255)
     */
    private $git;

    /**
	 * @var string $gitId The git id for the repository for this component
     * @example my-component
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The git id for the repository for this component",
	 *             "type"="string",
	 *             "example"="my-component",
	 *             "maxLength"=255
	 *         }
	 *     }
	 * )
	 * 
     * @Assert\Length(
     *      max = 255
     * )
	 * @Groups({"read"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gitId;

    /**
	 * @var string $gitType The git type for the repository for this component
     * @example({"Github", "Gitlab", "Bitbucket"})
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The git type for the repository for this component",
	 *             "type"="string",
	 *             "example"="github",
	 *             "maxLength"=255,
	 *             "enum"={"Github", "Gitlab", "Bitbucket"}
	 *         }
	 *     }
	 * )
	 * 
     * @Assert\Length(
     *      max = 255
     * )
	 * @Groups({"read"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gitType;
    
    /**
     * @var Organisation $owner The organisation that ownes this component (or better said it's repository) 
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Organisation",cascade={"persist"})
     */
    private $owner;

    /**     
	 * @var ArrayCollection $apis The APIs provided by this component
	 * 
	 * @maxDepth(1)
	 * @Groups({"read"})
     * @ORM\OneToMany(targetEntity="App\Entity\API", mappedBy="component",cascade={"persist"})
     */
    private $apis;

    /**
	 * @var ArrayCollection $organisations The organisations that provide this component
	 * 
	 * @maxDepth(1)
	 * @Groups({"read"})
     * @ORM\ManyToMany(targetEntity="App\Entity\Organisation", mappedBy="components",cascade={"persist"})
     */
    private $organisations;

    public function __construct()
    {
        $this->apis = new ArrayCollection();
        $this->organisations = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(?string $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getGit(): ?string
    {
        return $this->git;
    }

    public function setGit(string $git): self
    {
        $this->git = $git;

        return $this;
    }

    public function getGitId(): ?string
    {
        return $this->gitId;
    }

    public function setGitId(?string $gitId): self
    {
        $this->gitId = $gitId;

        return $this;
    }

    public function getGitType(): ?string
    {
        return $this->gitType;
    }

    public function setGitType(?string $gitType): self
    {
        $this->gitType = $gitType;

        return $this;
    }
    
    public function getOwner(): ?Organisation
    {
        return $this->owner;
    }
    
    public function setOwner(?Organisation $owner): self
    {
        $this->owner = $owner;
        
        return $this;
    }

    /**
     * @return Collection|API[]
     */
    public function getApis(): Collection
    {
        return $this->apis;
    }

    public function addApi(API $api): self
    {
        if (!$this->apis->contains($api)) {
            $this->apis[] = $api;
            $api->setComponent($this);
        }

        return $this;
    }

    public function removeApi(API $api): self
    {
        if ($this->apis->contains($api)) {
            $this->apis->removeElement($api);
            // set the owning side to null (unless already changed)
            if ($api->getComponent() === $this) {
                $api->setComponent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Organisation[]
     */
    public function getOrganisations(): Collection
    {
        return $this->organisations;
    }

    public function addOrganisation(Organisation $organisation): self
    {
        if (!$this->organisations->contains($organisation)) {
            $this->organisations[] = $organisation;
            $organisation->addComponent($this);
        }

        return $this;
    }

    public function removeOrganisation(Organisation $organisation): self
    {
        if ($this->organisations->contains($organisation)) {
            $this->organisations->removeElement($organisation);
            $organisation->removeComponent($this);
        }

        return $this;
    }
}
