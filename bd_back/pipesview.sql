SELECT 
        `epipes`.`id` AS `id`,
        `epipes`.`pdestination` AS `pdestination`,
        `epipes`.`section` AS `section`,
        `epipes`.`loc_from` AS `loc_from`,
        `epipes`.`loc_to` AS `loc_to`,
        `epipes`.`flu_name` AS `flu_name`,
        `epipes`.`flu_pha` AS `flu_pha`,
        `epipes`.`density` AS `density`,
        `epipes`.`oco_pressbar` AS `oco_pressbar`,
        `epipes`.`oco_tempc` AS `oco_tempc`,
        `epipes`.`dco_pressbar` AS `dco_pressbar`,
        `epipes`.`dco_tempc` AS `dco_tempc`,
        `epipes`.`oocoa_pressbar` AS `oocoa_pressbar`,
        `epipes`.`oocoa_tempc` AS `oocoa_tempc`,
        `epipes`.`odcoa_pressbar` AS `odcoa_pressbar`,
        `epipes`.`odcoa_tempc` AS `odcoa_tempc`,
        `epipes`.`oocob_pressbar` AS `oocob_pressbar`,
        `epipes`.`oocob_tempc` AS `oocob_tempc`,
        `epipes`.`odcob_pressbar` AS `odcob_pressbar`,
        `epipes`.`odcob_tempc` AS `odcob_tempc`,
        `epipes`.`dco_tflexc` AS `dco_tflexc`,
        `epipes`.`wth_sch` AS `wth_sch`,
        `epipes`.`wth_cormm` AS `wth_cormm`,
        `epipes`.`ins_com` AS `ins_com`,
        `epipes`.`ins_lim` AS `ins_lim`,
        `epipes`.`ins_thkmm` AS `ins_thkmm`,
        `epipes`.`tra_size` AS `tra_size`,
        `epipes`.`tra_num` AS `tra_num`,
        `epipes`.`tmainc` AS `tmainc`,
        `epipes`.`pca_tpset` AS `pca_tpset`,
        `epipes`.`pca_method` AS `pca_method`,
        `epipes`.`pca_altfg` AS `pca_altfg`,
        `epipes`.`pca_man` AS `pca_man`,
        `epipes`.`paint_a` AS `paint_a`,
        `epipes`.`paint_b` AS `paint_b`,
        `epipes`.`tpr_typ` AS `tpr_typ`,
        `epipes`.`tpr_minbarg` AS `tpr_minbarg`,
        `epipes`.`tpr_maxbarg` AS `tpr_maxbarg`,
        `epipes`.`aut_pha` AS `aut_pha`,
        `epipes`.`aut_grp` AS `aut_grp`,
        `epipes`.`aut_cat` AS `aut_cat`,
        `epipes`.`cancelled` AS `cancelled`,
        `epipes`.`rev` AS `rev`,
        `epipes`.`pid` AS `pid`,
        `epipes`.`notes` AS `notes`,
        `epipes`.`sftyacces` AS `sftyacces`,
        `epipes`.`units_id` AS `units_id`,
        (SELECT `units`.`name` FROM `units` WHERE (`units`.`id` = `epipes`.`units_id`)) AS `area`,
        (SELECT `diameters`.`dn` FROM `diameters` WHERE (`diameters`.`id` = `epipes`.`diameters_id`)) AS `diameter`,
		(SELECT `fluids`.`code` FROM `fluids` WHERE (`fluids`.`id` = `epipes`.`fluids_id`)) AS `fluid`,
        `tpfmc_db`.`epipes`.`calc_notes` AS `calc_notes`,
        `tpfmc_db`.`epipes`.`line_number` AS `line_number`,
        `tpfmc_db`.`epipes`.`sec_number` AS `sec_number`,
        `tpfmc_db`.`epipes`.`pdms_linenumber` AS `pdms_linenumber`,
        (SELECT `specs`.`name` FROM `specs` WHERE (`specs`.`id` = `epipes`.`specs_id`)) AS `spec`,
        (CASE
            WHEN (`tpfmc_db`.`epipes`.`calc_notes` IS NOT NULL) THEN 2
            WHEN (ISNULL(`tpfmc_db`.`epipes`.`calc_notes`) AND ((SELECT `diameters`.`dn` FROM `diameters` WHERE (`diameters`.`id` = `epipes`.`diameters_id`)) >= 50)) THEN 1
            ELSE 0
        END) AS `tpipes_id`,
        (CASE
            WHEN (`tpfmc_db`.`epipes`.`calc_notes` IS NOT NULL) THEN (SELECT `tpipes`.`code` FROM `tpipes` WHERE `tpipes`.`id`=2)
            WHEN (ISNULL(`tpfmc_db`.`epipes`.`calc_notes`) AND ((SELECT `diameters`.`dn` FROM `diameters` WHERE (`diameters`.`id` = `epipes`.`diameters_id`)) >= 50)) THEN (SELECT `tpipes`.`code` FROM `tpipes` WHERE `tpipes`.`id`=1)
            ELSE (SELECT `tpipes`.`code` FROM `tpipes` WHERE `tpipes`.`id`=0)
        END) AS `type_line`,

        (CASE
            WHEN (`tpfmc_db`.`epipes`.`calc_notes` IS NOT NULL) THEN (SELECT `tpipes`.`hours` FROM `tpipes` WHERE `tpipes`.`id`=2)
            WHEN
                (ISNULL(`tpfmc_db`.`epipes`.`calc_notes`)
                    AND ((SELECT `diameters`.`dn` FROM `diameters` WHERE (`diameters`.`id` = `epipes`.`diameters_id`)) >= 50))
            THEN
                (SELECT `tpipes`.`hours` FROM `tpipes` WHERE `tpipes`.`id`=1)
            ELSE (SELECT `tpipes`.`hours` FROM `tpipes` WHERE `tpipes`.`id`=0)
        END) AS `hours`,
        `tpfmc_db`.`epipes`.`created_at` AS `created_at`,
        `tpfmc_db`.`epipes`.`updated_at` AS `updated_at`
    FROM
        `epipes`