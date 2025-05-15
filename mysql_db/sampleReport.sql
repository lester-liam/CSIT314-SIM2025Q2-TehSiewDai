

--  Querying the Views (Example)
-- You can now query these views like regular tables:
SELECT * FROM DailyReportView
ORDER BY date DESC, category;
SELECT * FROM WeeklyReportView ORDER BY  CASE
        WHEN date IS NOT NULL THEN SUBSTRING(date, 1, 4) + 0
        ELSE NULL
     END DESC,
     CASE
        WHEN date IS NOT NULL THEN SUBSTRING(date, 7) + 0
        ELSE NULL
     END, category;
SELECT * FROM MonthlyReportView
ORDER BY date DESC, category;
