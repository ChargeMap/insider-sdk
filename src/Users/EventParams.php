<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk\Users;

use JsonSerializable;

class EventParams implements JsonSerializable
{
    /** @var array<string, mixed>|null */
    private ?array $custom = null;
    private ?string $eventGroupId;
    private ?string $productId;
    private ?string $name;
    /** @var string[] */
    private ?array $taxonomy = null;
    private ?string $currency;
    private ?float $unitPrice;
    private ?float $unitSalePrice;
    private ?string $color;
    private ?string $size;
    private ?string $shippingCost;
    private ?string $promotionName;
    private ?float $promotionDiscount;

    public function __construct(
        ?string $eventGroupId = null,
        ?string $productId = null,
        ?string $name = null,
        ?string $currency = null,
        ?float  $unitPrice = null,
        ?float  $unitSalePrice = null,
        ?string $color = null,
        ?string $size = null,
        ?string $shippingCost = null,
        ?string $promotionName = null,
        ?float  $promotionDiscount = null
    )
    {
        $this->eventGroupId = $eventGroupId;
        $this->productId = $productId;
        $this->name = $name;
        $this->currency = $currency;
        $this->unitPrice = $unitPrice;
        $this->unitSalePrice = $unitSalePrice;
        $this->color = $color;
        $this->size = $size;
        $this->shippingCost = $shippingCost;
        $this->promotionName = $promotionName;
        $this->promotionDiscount = $promotionDiscount;
    }

    public function withCustomEventParameter(string $key, $value): self
    {
        if (empty($this->custom)) {
            $this->custom = [];
        }
        $this->custom[$key] = $value;
        return $this;
    }

    public function withTaxonomy(string $taxonomy): self
    {
        if (empty($this->taxonomy)) {
            $this->taxonomy = [];
        }
        $this->taxonomy[] = $taxonomy;
        return $this;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getCustom(): ?array
    {
        return $this->custom;
    }

    public function getEventGroupId(): ?string
    {
        return $this->eventGroupId;
    }

    public function getProductId(): ?string
    {
        return $this->productId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string[]|null
     */
    public function getTaxonomy(): ?array
    {
        return $this->taxonomy;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    public function getUnitSalePrice(): ?float
    {
        return $this->unitSalePrice;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function getShippingCost(): ?string
    {
        return $this->shippingCost;
    }

    public function getPromotionName(): ?string
    {
        return $this->promotionName;
    }

    public function getPromotionDiscount(): ?float
    {
        return $this->promotionDiscount;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'event_group_id' => $this->eventGroupId,
            'product_id' => $this->productId,
            'name' => $this->name,
            'currency' => $this->currency,
            'unit_price' => $this->unitPrice,
            'unit_sale_price' => $this->unitSalePrice,
            'color' => $this->color,
            'size' => $this->size,
            'shipping_cost' => $this->shippingCost,
            'promotion_name' => $this->promotionName,
            'promotion_discount' => $this->promotionDiscount
        ];
        if (!empty($this->custom)) {
            $return['custom'] = $this->custom;
        }
        if (!empty($this->taxonomy)) {
            $return['taxonomy'] = $this->taxonomy;
        }

        return $return;
    }
}
