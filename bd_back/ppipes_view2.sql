
    SELECT 
        `dpipes`.`zone_name` AS `zone_name`,
        `dpipes`.`pipe_name` AS `pipe_name`,
        `dpipes`.`pid` AS `pid`,
        `dpipes`.`iso` AS `iso`,
        `dpipes`.`stress` AS `stress`,
        `dpipes`.`support` AS `support`,
        `dpipes`.`pdms_linenumber` AS `pdms_linenumber`,
        `ppipe_isos`.`name` AS `isospname`,
        `ppipe_pids`.`name` AS `pidpname`,
        `ppipe_stresses`.`name` AS `stressespname`,
        `ppipe_supports`.`name` AS `supportspname`,
        (SELECT `pipesview`.`hours` FROM `pipesview` WHERE `pipesview`.`pdms_linenumber`=`dpipes`.`pdms_linenumber`) AS hours,
        (SELECT SUM(hours) FROM pipesview) AS est_hours,


          (((((((`dpipes`.`pid`) * (SELECT 
                `tpipes`.`pid`
            FROM
                `tpipes`
            WHERE
                (`tpipes`.`hours` = (SELECT `pipesview`.`hours` FROM `pipesview` WHERE (`pipesview`.`pdms_linenumber` = `dpipes`.`pdms_linenumber`))))) + ((`dpipes`.`iso`) * (SELECT 
                `tpipes`.`iso`
            FROM
                `tpipes`
            WHERE
                (`tpipes`.`hours` = (SELECT 
                        `pipesview`.`hours`
                    FROM
                        `pipesview`
                    WHERE
                        (`pipesview`.`pdms_linenumber` = `dpipes`.`pdms_linenumber`)))))) + ((`dpipes`.`stress`) * (SELECT 
                `tpipes`.`stress`
            FROM
                `tpipes`
            WHERE
                (`tpipes`.`hours` = (SELECT 
                        `pipesview`.`hours`
                    FROM
                        `pipesview`
                    WHERE
                        (`pipesview`.`pdms_linenumber` = `dpipes`.`pdms_linenumber`)))))) + ((`dpipes`.`support`) * (SELECT 
                `tpipes`.`support`
            FROM
                `tpipes`
            WHERE
                (`tpipes`.`hours` = (SELECT 
                        `pipesview`.`hours`
                    FROM
                        `pipesview`
                    WHERE
                        (`pipesview`.`pdms_linenumber` = `dpipes`.`pdms_linenumber`)))))) / (SELECT 
                `pipesview`.`hours`
            FROM
                `pipesview`
            WHERE
                (`pipesview`.`pdms_linenumber` = `dpipes`.`pdms_linenumber`)))) AS `total_progress`
    FROM
        ((((`dpipes`
        JOIN `ppipe_isos`)
        JOIN `ppipe_pids`)
        JOIN `ppipe_stresses`)
        JOIN `ppipe_supports`)
    WHERE
        ((`dpipes`.`pid` = `ppipe_pids`.`percentage`)
            AND (`dpipes`.`iso` = `ppipe_isos`.`percentage`)
            AND (`dpipes`.`stress` = `ppipe_stresses`.`percentage`)
            AND (`dpipes`.`support` = `ppipe_supports`.`percentage`))