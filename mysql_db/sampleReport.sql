-- Daily Report Breakdown by Service Category (Across All Dates)
SELECT
    DATE(cs.createdAt) AS report_date,
    sc.category,
    COUNT(CASE WHEN DATE(cs.createdAt) = DATE(cs.updatedAt) THEN cs.id END) AS new_services,
    COUNT(CASE WHEN DATE(cs.createdAt) < DATE(cs.updatedAt) THEN cs.id END) AS updated_services,
    SUM(cs.numViews) AS total_views,
    SUM(cs.numShortlists) AS total_shortlists
FROM
    CleanerService cs
JOIN
    ServiceCategory sc ON cs.serviceCategoryID = sc.id
GROUP BY
    report_date, sc.category
ORDER BY
    report_date, sc.category;


-- Weekly Report Breakdown by Service Category (Across All Weeks)
SELECT
    CONCAT(YEAR(cs.createdAt), '-W', WEEK(cs.createdAt, 3)) AS report_week,
    sc.category,
    COUNT(CASE WHEN YEAR(cs.createdAt) = YEAR(cs.updatedAt) AND WEEK(cs.createdAt, 3) = WEEK(cs.updatedAt, 3) THEN cs.id END) AS new_services,
    COUNT(CASE WHEN (YEAR(cs.createdAt) < YEAR(cs.updatedAt)) OR (YEAR(cs.createdAt) = YEAR(cs.updatedAt) AND WEEK(cs.createdAt, 3) < WEEK(cs.updatedAt, 3)) THEN cs.id END) AS updated_services,
    SUM(cs.numViews) AS total_views,
    SUM(cs.numShortlists) AS total_shortlists
FROM
    CleanerService cs
JOIN
    ServiceCategory sc ON cs.serviceCategoryID = sc.id
GROUP BY
    report_week, sc.category
ORDER BY
    report_week, sc.category;


-- Monthly Report Breakdown by Service Category (Across All Months)
SELECT
    DATE_FORMAT(cs.createdAt, '%Y-%m') AS report_month,
    sc.category,
    COUNT(CASE WHEN YEAR(cs.createdAt) = YEAR(cs.updatedAt) AND MONTH(cs.createdAt) = MONTH(cs.updatedAt) THEN cs.id END) AS new_services,
    COUNT(CASE WHEN (YEAR(cs.createdAt) < YEAR(cs.updatedAt)) OR (YEAR(cs.createdAt) = YEAR(cs.updatedAt) AND MONTH(cs.createdAt) < MONTH(cs.updatedAt)) THEN cs.id END) AS updated_services,
    SUM(cs.numViews) AS total_views,
    SUM(cs.numShortlists) AS total_shortlists
FROM
    CleanerService cs
JOIN
    ServiceCategory sc ON cs.serviceCategoryID = sc.id
GROUP BY
    report_month, sc.category
ORDER BY
    report_month, sc.category;