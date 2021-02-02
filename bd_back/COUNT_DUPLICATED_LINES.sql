SELECT pdms_linenumber, COUNT(*)
FROM epipes
GROUP BY pdms_linenumber
HAVING COUNT(*) > 1