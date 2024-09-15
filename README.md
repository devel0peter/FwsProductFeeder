# FWS test exercise

## First part

### 1. Import products from a CSV file

Import products from a CSV file. The file must have the following columns:

- "Megnevezés"
- "Ár"
- "Kategória 1"
- "Kategória 2"
- "Kategória 3"

### XML feed generation
All products are served through an XML feed at
`[your-base-url]/products/feed`.

## Second part

### SQL query to get product package price on a given day
```sqlSELECT SUM(ph.price * ppc.quantity) AS package_price
FROM product_packages pp
JOIN product_package_contents ppc ON pp.id = ppc.product_package_id
JOIN products p ON ppc.product_id = p.id
JOIN (
    SELECT ph1.product_id, ph1.price
    FROM price_history ph1
    JOIN (
        SELECT product_id, MAX(updated_at) AS max_date
        FROM price_history
        WHERE updated_at <= '[date-to-get-price-for]'
        GROUP BY product_id
    ) ph2 ON ph1.product_id = ph2.product_id AND ph1.updated_at = ph2.max_date
) ph ON p.id = ph.product_id
WHERE pp.id = [product-package-id-to-get-price-for];
