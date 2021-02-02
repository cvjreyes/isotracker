SELECT * FROM hisoctrls WHERE id IN 
(SELECT MAX(id) FROM hisoctrls GROUP BY filename) 
ORDER BY id DESC