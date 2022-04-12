<?php

declare(strict_types=1);

namespace Tests\Chargemap\InsiderSdk\Users;

use Chargemap\InsiderSdk\Users\EventParams;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\InsiderSdk\Users\EventParams
 */
class EventParamsTest extends TestCase
{
    public function testConstructorAndGetters(): void
    {
        $params = new EventParams();
        $this->assertNull($params->getCustom());
        $this->assertNull($params->getEventGroupId());
        $this->assertNull($params->getProductId());
        $this->assertNull($params->getName());
        $this->assertNull($params->getTaxonomy());
        $this->assertNull($params->getCurrency());
        $this->assertNull($params->getUnitPrice());
        $this->assertNull($params->getUnitSalePrice());
        $this->assertNull($params->getColor());
        $this->assertNull($params->getSize());
        $this->assertNull($params->getShippingCost());
        $this->assertNull($params->getPromotionName());
        $this->assertNull($params->getPromotionDiscount());
        $custom = [
            'key' => 'value'
        ];
        $eventGroupId = 'event group id';
        $productId = 'productId';
        $name = 'name';
        $taxonomy = ['one', 'two', 'three'];
        $currency = 'USD';
        $unitPrice = 1.23;
        $unitSalePrice = 2.34;
        $color = 'black';
        $size = 'big';
        $shippingCost = '1.2345';
        $promotionName = 'promotion';
        $promotionDiscount = 0.99;
        $params = new EventParams(
            $eventGroupId,
            $productId,
            $name,
            $currency,
            $unitPrice,
            $unitSalePrice,
            $color,
            $size,
            $shippingCost,
            $promotionName,
            $promotionDiscount,
        );
        foreach ($taxonomy as $value) {
            $params = $params->withTaxonomy($value);
        }
        foreach ($custom as $key => $value) {
            $params = $params->withCustomEventParameter($key, $value);
        }
        $this->assertSame($eventGroupId, $params->getEventGroupId());
        $this->assertSame($productId, $params->getProductId());
        $this->assertSame($name, $params->getName());
        $this->assertSame($currency, $params->getCurrency());
        $this->assertSame($unitPrice, $params->getUnitPrice());
        $this->assertSame($unitSalePrice, $params->getUnitSalePrice());
        $this->assertSame($color, $params->getColor());
        $this->assertSame($size, $params->getSize());
        $this->assertSame($shippingCost, $params->getShippingCost());
        $this->assertSame($promotionName, $params->getPromotionName());
        $this->assertSame($promotionDiscount, $params->getPromotionDiscount());
        $this->assertSame($custom, $params->getCustom());
        $this->assertSame($taxonomy, $params->getTaxonomy());
    }

    public function testJsonSerializeWithoutParameters(): void
    {
        $params = new EventParams();
        $this->assertSame(json_encode([
            'event_group_id' => null,
            'product_id' => null,
            'name' => null,
            'currency' => null,
            'unit_price' => null,
            'unit_sale_price' => null,
            'color' => null,
            'size' => null,
            'shipping_cost' => null,
            'promotion_name' => null,
            'promotion_discount' => null,
        ]), json_encode($params));
    }

    public function testJsonSerializeWithAllParameters(): void
    {
        $custom = [
            'key' => 'value'
        ];
        $eventGroupId = 'event group id';
        $productId = 'productId';
        $name = 'name';
        $taxonomy = ['one', 'two', 'three'];
        $currency = 'USD';
        $unitPrice = 1.23;
        $unitSalePrice = 2.34;
        $color = 'black';
        $size = 'big';
        $shippingCost = '1.2345';
        $promotionName = 'promotion';
        $promotionDiscount = 0.99;
        $params = new EventParams(
            $eventGroupId,
            $productId,
            $name,
            $currency,
            $unitPrice,
            $unitSalePrice,
            $color,
            $size,
            $shippingCost,
            $promotionName,
            $promotionDiscount,
        );
        foreach ($taxonomy as $value) {
            $params = $params->withTaxonomy($value);
        }
        foreach ($custom as $key => $value) {
            $params = $params->withCustomEventParameter($key, $value);
        }
        $this->assertSame(json_encode([
            'event_group_id' => $eventGroupId,
            'product_id' => $productId,
            'name' => $name,
            'currency' => $currency,
            'unit_price' => $unitPrice,
            'unit_sale_price' => $unitSalePrice,
            'color' => $color,
            'size' => $size,
            'shipping_cost' => $shippingCost,
            'promotion_name' => $promotionName,
            'promotion_discount' => $promotionDiscount,
            'custom' => $custom,
            'taxonomy' => $taxonomy,
        ]), json_encode($params));
    }

    public function testPartialJsonSerialize(): void
    {
        $custom = [
            'key' => 'value'
        ];
        $productId = 'productId';
        $unitPrice = 1.23;
        $color = 'black';
        $shippingCost = '1.2345';
        $promotionDiscount = 0.99;
        $params = new EventParams(
            null,
            $productId,
            null,
            null,
            $unitPrice,
            null,
            $color,
            null,
            $shippingCost,
            null,
            $promotionDiscount,
        );
        foreach ($custom as $key => $value) {
            $params = $params->withCustomEventParameter($key, $value);
        }
        $this->assertSame(json_encode([
            'event_group_id' => null,
            'product_id' => $productId,
            'name' => null,
            'currency' => null,
            'unit_price' => $unitPrice,
            'unit_sale_price' => null,
            'color' => $color,
            'size' => null,
            'shipping_cost' => $shippingCost,
            'promotion_name' => null,
            'promotion_discount' => $promotionDiscount,
            'custom' => $custom,
        ]), json_encode($params));
    }
}
