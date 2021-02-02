SET @wpipe=(SELECT SUM(weight*qty) FROM epipesfullview);
SET @wequi=(SELECT SUM(weight*qty) FROM eequisfullview);
SET @wcivil=(SELECT SUM(weight*qty) FROM ecivilsfullview);
SET @winst=(SELECT SUM(weight*qty) FROM einstsfullview);
SET @welec=(SELECT SUM(weight*qty) FROM eelecsfullview);
SET @wtotal=@wpipe+@wequi+@wcivil+@winst+@welec;
SET @fpipe=@wpipe/@wtotal;
SET @fequi=@wequi/@wtotal;
SET @fcivil=@wcivil/@wtotal;
SET @finst=@winst/@wtotal;
SET @felec=@welec/@wtotal;
SELECT hpipes.week,
IFNULL(hpipes.progress,0) AS ppipe,
IFNULL(hequis.progress,0) AS pequi,
IFNULL(hcivils.progress,0) AS pcivil,
IFNULL(hinsts.progress,0) AS pinst,
IFNULL(helecs.progress,0) AS pelec,
IFNULL(milestones.estimated,0) AS estimated,
TRUNCATE(((IFNULL(hpipes.progress,0)*@fpipe)+(IFNULL(hequis.progress,0)*@fequi)+(IFNULL(hcivils.progress,0)*@fcivil)+
(IFNULL(hinsts.progress,0)*@finst)+(IFNULL(helecs.progress,0)*@felec)),2) as progress
FROM hpipes 
LEFT JOIN hequis ON hequis.week=hpipes.week
LEFT JOIN hcivils ON hcivils.week=hpipes.week
LEFT JOIN hinsts ON hinsts.week=hpipes.week
LEFT JOIN helecs ON helecs.week=hpipes.week
LEFT JOIN milestones ON milestones.week=hpipes.week
