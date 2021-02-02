<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpipesLdlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('epipes_ldl', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pdestination')->nullable();
            $table->integer('units_id')->nullable();
            $table->string('section')->nullable();
            $table->integer('diameters_id')->nullable();
            $table->string('fluids_id')->nullable();
            $table->string('line_number')->nullable();
            $table->string('sec_number')->nullable();
            $table->string('specs_id');
            $table->string('loc_from')->nullable();
            $table->string('loc_to')->nullable();
            $table->string('flu_name')->nullable();
            $table->string('flu_pha')->nullable();
            $table->string('density')->nullable();
            $table->string('oco_pressbar')->nullable();
            $table->string('oco_tempc')->nullable();
            $table->string('dco_pressbar')->nullable();
            $table->string('dco_tempc')->nullable();
            $table->string('oocoa_pressbar')->nullable();
            $table->string('oocoa_tempc')->nullable();
            $table->string('odcoa_pressbar')->nullable();
            $table->string('odcoa_tempc')->nullable();
            $table->string('oocob_pressbar')->nullable();
            $table->string('oocob_tempc')->nullable();
            $table->string('odcob_pressbar')->nullable();
            $table->string('odcob_tempc')->nullable();
            $table->string('dco_tflexc')->nullable();
            $table->string('wth_sch')->nullable();
            $table->string('wth_cormm')->nullable();
            $table->string('ins_com')->nullable();
            $table->string('ins_lim')->nullable();
            $table->string('ins_thkmm')->nullable();
            $table->string('tra_size')->nullable();
            $table->string('tra_num')->nullable();
            $table->string('tmainc')->nullable();
            $table->string('pca_tpset')->nullable();
            $table->string('pca_method')->nullable();
            $table->string('pca_altfg')->nullable();
            $table->string('pca_man')->nullable();
            $table->string('paint_a')->nullable();
            $table->string('paint_b')->nullable();
            $table->string('tpr_typ')->nullable();
            $table->string('tpr_minbarg')->nullable();
            $table->string('tpr_maxbarg')->nullable();
            $table->string('aut_pha')->nullable();
            $table->string('aut_grp')->nullable();
            $table->string('aut_cat')->nullable();
            $table->string('cancelled')->nullable();
            $table->string('rev')->nullable();
            $table->string('pid')->nullable();
            $table->string('notes')->nullable();
            $table->string('pdms_linenumber')->nullable();
            $table->string('soumis')->nullable();
            $table->string('modification')->nullable();
            $table->string('pwht')->nullable();
            $table->string('nacerequir')->nullable();
            $table->string('constcate')->nullable();
            $table->string('priority')->nullable();
            $table->string('sftyacces')->nullable();
            $table->string('source')->nullable();
            $table->string('calc_notes')->nullable();
            $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
