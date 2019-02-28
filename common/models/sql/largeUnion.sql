SELECT
  COUNT(*)
FROM
  (
    SELECT
      *
    FROM
      (
        (
          SELECT
            `name_ru`,
            `SC_categories`.`categoryID` AS `objectID`,
            `SC_categories`.`categoryID`,
            `picture`,
            CONCAT("category", "") AS type
          FROM
            `SC_categories`
          WHERE
            `parent` IN (
              111712,
              111714,
              111715,
              111716,
              111717,
              111718,
              111743,
              111745,
              111773,
              111774,
              111776,
              111778,
              111779,
              111780,
              111781,
              111783,
              111784,
              111790,
              111791,
              111792,
              111795,
              111796,
              111797,
              111798,
              111799,
              111860,
              111861,
              111713
            )
        )
        UNION
        (
          SELECT
            `name_ru`,
            `SC_categories`.`categoryID` AS `objectID`,
            `SC_categories`.`categoryID`,
            `picture`,
            CONCAT("category", "") AS type
          FROM
            `SC_categories`
          WHERE
            `categoryID` IN (
              SELECT
                `categoryID`
              FROM
                `SC_parental_connections`
              WHERE
                `parent` = 111713
            )
        )
        UNION
        (
          SELECT
            `name_ru`,
            `SC_products`.`productID` AS `objectID`,
            `SC_products`.`categoryID`,
            `SC_product_pictures`.`enlarged` AS `picture`,
            CONCAT("product", "product") AS type
          FROM
            `SC_products`
            LEFT JOIN `SC_product_pictures` ON SC_products.productID = SC_product_pictures.productID
          WHERE
            `categoryID` IN (
              111712,
              111714,
              111715,
              111716,
              111717,
              111718,
              111743,
              111745,
              111773,
              111774,
              111776,
              111778,
              111779,
              111780,
              111781,
              111783,
              111784,
              111790,
              111791,
              111792,
              111795,
              111796,
              111797,
              111798,
              111799,
              111860,
              111861,
              111713
            )
        )
        UNION
        (
          SELECT
            `name_ru`,
            `SC_products`.`productID` AS `objectID`,
            `SC_products`.`categoryID`,
            `SC_product_pictures`.`enlarged` AS `picture`,
            CONCAT("product", "product") AS type
          FROM
            `SC_products`
            LEFT JOIN `SC_product_pictures` ON SC_products.productID = SC_product_pictures.productID
          WHERE
            `categoryID` IN (
              SELECT
                `categoryID`
              FROM
                `SC_parental_connections`
              WHERE
                `parent` = 111713
            )
        )
      ) `0`
      LEFT JOIN `SC_category_meta` ON SC_category_meta.categoryID = SC_categories.categoryID
    WHERE
      `name_ru` LIKE '%Alora%'
    GROUP BY
      `objectID`,
      `type`
  ) `c`