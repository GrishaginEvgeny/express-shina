<?php

namespace App\Entity;

use App\Repository\ManufacturerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ManufacturerRepository::class)]
class Manufacturer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    /**
     * @var Collection<int, ProductModel>
     */
    #[ORM\OneToMany(targetEntity: ProductModel::class, mappedBy: 'manufacturer')]
    private Collection $productModels;

    public function __construct()
    {
        $this->productModels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, ProductModel>
     */
    public function getProductModels(): Collection
    {
        return $this->productModels;
    }

    public function addProductModel(ProductModel $productModel): static
    {
        if (!$this->productModels->contains($productModel)) {
            $this->productModels->add($productModel);
            $productModel->setManufacturer($this);
        }

        return $this;
    }

    public function removeProductModel(ProductModel $productModel): static
    {
        if ($this->productModels->removeElement($productModel)) {
            // set the owning side to null (unless already changed)
            if ($productModel->getManufacturer() === $this) {
                $productModel->setManufacturer(null);
            }
        }

        return $this;
    }
}
