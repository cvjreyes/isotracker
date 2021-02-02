<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Epipeldl extends Model
{
    public $fillable = ['id','pdestination','units_id','section','diameters_id','fluids_id','line_number','tag','sec_number','specs_id','loc_from','loc_to','flu_name','flu_pha','density','oco_pressbar','oco_tempc','dco_pressbar','dco_tempc','oocoa_pressbar','oocoa_tempc','odcoa_pressbar','odcoa_tempc','oocob_pressbar','oocob_tempc','odcob_pressbar','odcob_tempc','dco_tflexc','wth_sch','wth_cormm','ins_com','ins_lim','ins_thkmm','tra_size','tra_num','tmainc','pca_tpset','pca_method','pca_altfg','pca_man','paint_a','paint_b','tpr_typ','tpr_minbarg','tpr_maxbarg','aut_pha','aut_grp','aut_cat','cancelled','rev','pid','notes','pdms_linenumber','soumis','modification','pwht','nacerequir','constcate','priority','sftyacces','source','calc_notes'];


    


}