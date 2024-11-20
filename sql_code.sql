SELECT checking_date,DATE_ADD(checking_date, INTERVAL 90 DAY) AS Due_checking_date FROM `fire_extinguishers` WHERE DATE_ADD(checking_date, INTERVAL 90 DAY)<=CURRENT_DATE() 
ORDER BY `Due_checking_date` ASC;


SELECT 
    CASE 
        WHEN checking_date != '0000-00-00' THEN DATE_ADD(checking_date, INTERVAL 90 DAY)
        ELSE DATE_ADD(build_date, INTERVAL 90 DAY)
    END AS next_checking_date,
    CASE 
        WHEN refilling_date != '0000-00-00' THEN DATE_ADD(refilling_date, INTERVAL 365 DAY)
        ELSE DATE_ADD(build_date, INTERVAL 90 DAY)
    END AS next_refilling_date,
    CASE 
        WHEN hydraulic_test_date != '0000-00-00' THEN DATE_ADD(hydraulic_test_date, INTERVAL 1095 DAY)
        ELSE DATE_ADD(build_date, INTERVAL 1095 DAY)
    END AS next_hydraulic_test_date
FROM `fire_extinguishers`
WHERE 
    (CASE 
        WHEN checking_date != '0000-00-00' THEN DATE_ADD(checking_date, INTERVAL 90 DAY)
        ELSE DATE_ADD(build_date, INTERVAL 90 DAY)
    END) <= CURDATE()
    OR 
    (CASE 
        WHEN refilling_date != '0000-00-00' THEN DATE_ADD(refilling_date, INTERVAL 365 DAY)
        ELSE DATE_ADD(build_date, INTERVAL 90 DAY)
    END) <= CURDATE()
    OR 
    (CASE 
        WHEN hydraulic_test_date != '0000-00-00' THEN DATE_ADD(hydraulic_test_date, INTERVAL 1095 DAY)
        ELSE DATE_ADD(build_date, INTERVAL 1095 DAY)
    END) <= CURDATE();


SELECT 
    CASE 
        WHEN hydraulic_test_date != '0000-00-00' THEN DATE_ADD(hydraulic_test_date, INTERVAL 1095 DAY)
        ELSE DATE_ADD(build_date, INTERVAL 1095 DAY)
    END AS next_hydraulic_test_date
FROM `fire_extinguishers`
WHERE 
    (CASE 
        WHEN hydraulic_test_date != '0000-00-00' THEN DATE_ADD(hydraulic_test_date, INTERVAL 1095 DAY)
        ELSE DATE_ADD(build_date, INTERVAL 1095 DAY)
    END) <= CURDATE();
