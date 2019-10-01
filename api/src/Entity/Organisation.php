<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * An Organisation
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
 *  normalizationContext={"groups"={"read"}},
 *  denormalizationContext={"groups"={"write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\OrganisationRepository")
 */
class Organisation
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
	 * @var string $name The name of this organisation
     * @example My Organisation
	 *
	 * @ApiProperty(
     * 	   iri="https://schema.org/name",
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The name of this organisation",
	 *             "type"="string",
	 *             "example"="My Organisation",
	 *             "maxLength"="255",
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
	 * @var string $description An short description of this organisation
     * @example This is the best organisation ever
	 *
	 * @ApiProperty(
     * 	   iri="https://schema.org/description",
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "An short description of this organisation",
	 *             "type"="string",
	 *             "example"="This is the best organisation ever",
	 *             "maxLength"="2550,
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
	 * @var string $logo The logo for this organisation
     * @example https://www.my-organisation.com/logo.png
	 *
	 * @ApiProperty(
     * 	   iri="https://schema.org/logo",
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The logo for this organisation",
	 *             "type"="string",
	 *             "format"="url",
	 *             "example"="https://www.my-organisation.com/logo.png",
	 *             "maxLength"="255,
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
	 * @var string $slug The slug for this organisation
     * @example my-organisation
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The slug for this organisation",
	 *             "type"="string",
	 *             "example"="my-organisation",
	 *             "maxLength"="255,
	 *         }
	 *     }
	 * )
	 * 
     * @Groups({"read"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
	 * @var ArrayCollection $components  The apis provided by this organisation
	 * 
     * @Groups({"read"})
     * @ORM\ManyToMany(targetEntity="App\Entity\Component", inversedBy="organisations")
     */
    private $components;

    /**
	 * @var ArrayCollection $apis The components provided by this organisation
	 * 
     * @Groups({"read"})
     * @ORM\ManyToMany(targetEntity="App\Entity\API", inversedBy="organisations")
     */
    private $apis;

    public function __construct()
    {
        $this->components = new ArrayCollection();
        $this->apis = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Component[]
     */
    public function getComponents(): Collection
    {
        return $this->components;
    }

    public function addComponent(Component $component): self
    {
        if (!$this->components->contains($component)) {
            $this->components[] = $component;
        }

        return $this;
    }

    public function removeComponent(Component $component): self
    {
        if ($this->components->contains($component)) {
            $this->components->removeElement($component);
        }

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
        }

        return $this;
    }

    public function removeApi(API $api): self
    {
        if ($this->apis->contains($api)) {
            $this->apis->removeElement($api);
        }

        return $this;
    }
}
