SELECT 
    pp.id AS package_id,
    pp.title,
    SUM(ph.price * ppc.quantity) AS total_price
FROM 
    product_packages pp
JOIN 
    product_package_contents ppc ON pp.id = ppc.product_package_id
JOIN 
    products p ON p.id = ppc.product_id
JOIN 
    price_history ph ON ph.product_id = p.id
WHERE 
    pp.id = 1
    AND ph.updated_at <= '2024-01-10'
GROUP BY 
    pp.id, pp.title;
