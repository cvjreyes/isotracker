<?php 

                              $modelisos = DB::select("SELECT count(*) as qty FROM dpipesnews");

                              $isostatus_qry1 ="SELECT isostatus.name, count(isostatus.name) as qty FROM disoctrls JOIN isostatus WHERE disoctrls.isostatus_id=isostatus.id AND disoctrls.deleted<>1 AND ";

                              $isostatus_qry2 =" GROUP BY isostatus.name";

                              

                              $isostatus_new = DB::select($isostatus_qry1."isostatus.name='New'".$isostatus_qry2);
                              $isostatus_design = DB::select($isostatus_qry1."isostatus.name='Design'".$isostatus_qry2);
                              $isostatus_stress = DB::select($isostatus_qry1."isostatus.name='Stress'".$isostatus_qry2);
                              $isostatus_supports = DB::select($isostatus_qry1."isostatus.name='Supports'".$isostatus_qry2);
                              $isostatus_ldgdesign = DB::select($isostatus_qry1."isostatus.name='LDG Design'".$isostatus_qry2);
                              $isostatus_ldgstress = DB::select($isostatus_qry1."isostatus.name='LDG Stress'".$isostatus_qry2);
                              $isostatus_ldgsupports = DB::select($isostatus_qry1."isostatus.name='LDG Supports'".$isostatus_qry2);
                              $isostatus_materials = DB::select($isostatus_qry1."isostatus.name='Materials'".$isostatus_qry2);
                              $isostatus_lead = DB::select($isostatus_qry1."isostatus.name='Issuer'".$isostatus_qry2);
                              $isostatus_toissue = DB::select($isostatus_qry1."isostatus.name='To Issue'".$isostatus_qry2);
                              $isostatus_issued = DB::select($isostatus_qry1."isostatus.name='Issued'".$isostatus_qry2);
                              $isostatus_issued_R0 = DB::select($isostatus_qry1."isostatus.name='Issued' AND disoctrls.filename LIKE '%-0.pdf'".$isostatus_qry2);
                              $isostatus_issued_R1 = DB::select($isostatus_qry1."isostatus.name='Issued'  AND disoctrls.filename LIKE '%-1.pdf'".$isostatus_qry2);
                              $isostatus_issued_R2 = DB::select($isostatus_qry1."isostatus.name='Issued'  AND disoctrls.filename LIKE '%-2.pdf'".$isostatus_qry2);
                             // $isostatus_total = DB::select("SELECT COUNT(*) AS qty FROM disoctrls");


                              $per_new = (($isostatus_new[0]->qty)*100)/$isostatus_total[0]->qty;
                              $per_design = (($isostatus_design[0]->qty)*100)/$isostatus_total[0]->qty;
                              $per_stress = (($isostatus_stress[0]->qty)*100)/$isostatus_total[0]->qty;
                              $per_supports = (($isostatus_supports[0]->qty)*100)/$isostatus_total[0]->qty;
                              $per_ldgdesign = (($isostatus_ldgdesign[0]->qty)*100)/$isostatus_total[0]->qty;
                              $per_ldgstress = (($isostatus_ldgstress[0]->qty)*100)/$isostatus_total[0]->qty;
                              $per_ldgsupports = (($isostatus_ldgsupports[0]->qty)*100)/$isostatus_total[0]->qty;
                              $per_materials = (($isostatus_materials[0]->qty)*100)/$isostatus_total[0]->qty;
                              $per_lead = (($isostatus_lead[0]->qty)*100)/$isostatus_total[0]->qty;
                              $per_toissue = (($isostatus_toissue[0]->qty)*100)/$isostatus_total[0]->qty;
                              $per_issued = (($isostatus_issued[0]->qty)*100)/$isostatus_total[0]->qty;

                              // SUMA DE ISO DE BANDEJA MAS RESPECTIVO LDG
                                                            
                              $new_qty = $isostatus_new[0]->qty + 0;
                              $design_qty = $isostatus_design[0]->qty + $isostatus_ldgdesign[0]->qty + 0;
                              $stress_qty = $isostatus_stress[0]->qty + $isostatus_ldgstress[0]->qty + 0;
                              $supports_qty = $isostatus_supports[0]->qty + $isostatus_ldgsupports[0]->qty + 0;
                              $materials_qty = $isostatus_materials[0]->qty + 0;
                              $lead_qty = $isostatus_lead[0]->qty + 0;
                              $toissue_qty = $isostatus_toissue[0]->qty + 0;
                              $isostatus_total = $new_qty + $design_qty + $stress_qty + $supports_qty + $materials_qty + $lead_qty + $toissue_qty + $isostatus_issued_R0[0]->qty+ 0; 

                                                            
                  echo "<table border style='width: 100%'>";
                    echo "<tr><td style='text-align: center;width: 11.11%;font-size:13px;font-weight:normal;background: #6B9DBB;color: white'>Modelled</td>
                    <td colspan='2' style='text-align: center;width: 11.11%;font-size:13px;font-weight:normal;background: #6B9DBB;color: white'>Design</td>
                    <td style='text-align: center;width: 11.11%;font-size:13px;font-weight:normal;background: #6B9DBB;color: white'>Stress</td>
                    <td style='text-align: center;width: 11.11%;font-size:13px;font-weight:normal;background: #6B9DBB;color: white'>Supports</td>
                    <td style='text-align: center;width: 11.11%;font-size:13px;font-weight:normal;background: #6B9DBB;color: white'>Materials</td>
                    <td style='text-align: center;width: 11.11%;font-size:13px;font-weight:normal;background: #6B9DBB;color: white'>Issuer</td>
                    <td colspan='4' style='text-align: center;width: 11.11%;font-size:13px;font-weight:normal;background: #6B9DBB;color: white'>Isocontrol</td>
                    <td colspan='2' style='text-align: center;width: 11.11%;font-size:13px;font-weight:normal;background: #6B9DBB;color: white'> Total </td>
                    </tr>";
                    echo "<tr>";

                          echo "<td style='text-align: center;width: 11.11%;font-size:13px;font-weight:normal'>-</td>";
                      
                          echo "<td style='text-align: center;width: 11.11%;font-size:13px;font-weight:normal'>Uploaded</td>";
                          echo "<td style='text-align: center;width: 11.11%;font-size:13px;font-weight:normal'>In Progress</td>";


                          echo "<td style='text-align: center;width: 11.11%;font-size:13px;font-weight:normal'>-</td>";
                          echo "<td style='text-align: center;width: 11.11%;font-size:13px;font-weight:normal'>-</td>";
                          echo "<td style='text-align: center;width: 11.11%;font-size:13px;font-weight:normal'>-</td>";
                          echo "<td style='text-align: center;width: 11.11%;font-size:13px;font-weight:normal'>-</td>";
                          echo "<td style='text-align: center;width: 11.11%;font-size:13px;font-weight:normal'>To Issue</td>";
                          //echo "<td style='text-align: center;width: 11.11%;font-size:13px;font-weight:normal'>Issued</td>";
                          echo "<td style='text-align: center;width: 3.7%;font-size:13px;font-weight:normal'>R0</td>";
                          echo "<td style='text-align: center;width: 3.7%;font-size:13px;font-weight:normal'>R1</td>";
                          echo "<td style='text-align: center;width: 3.7%;font-size:13px;font-weight:normal'>R2</td>";
                          echo "<td style='text-align: center;width: 11.11%;font-size:13px;font-weight:normal'>-</td>";

                    echo "</tr>";
                    echo "<tr>";
            
                        echo "<td style='font-size:13px;font-weight:normal;text-align: center;background: #FFFFFF';width: 11.11%'>".$modelisos[0]->qty."</td>";
                        echo "<td style='font-size:13px;font-weight:normal;text-align: center;background: #FFFFFF';width: 11.11%'>".$new_qty."</td>";
                        echo "<td style='font-size:13px;font-weight:normal;text-align: center;background: #FFFFFF';width: 11.11%'>".$design_qty."</td>";
                        echo "<td style='font-size:13px;font-weight:normal;text-align: center;background: #FFFFFF';width: 11.11%'>".$stress_qty."</td>";
                        echo "<td style='font-size:13px;font-weight:normal;text-align: center;background: #FFFFFF';width: 11.11%'>".$supports_qty."</td>";
                        echo "<td style='font-size:13px;font-weight:normal;text-align: center;background: #FFFFFF';width: 11.11%'>".$materials_qty."</td>";
                        echo "<td style='font-size:13px;font-weight:normal;text-align: center;background: #FFFFFF';width: 11.11%'>".$lead_qty."</td>";
                        echo "<td style='font-size:13px;font-weight:normal;text-align: center;background: #FFFFFF';width: 11.11%'>".$toissue_qty."</td>";
                        echo "<td style='font-size:13px;font-weight:normal;text-align: center;background: #FFFFFF';width: 3.7%'>".$isostatus_issued_R0[0]->qty."</td>";
                        echo "<td style='font-size:13px;font-weight:normal;text-align: center;background: #FFFFFF';width: 3.7%'>".$isostatus_issued_R1[0]->qty."</td>";
                        echo "<td style='font-size:13px;font-weight:normal;text-align: center;background: #FFFFFF';width: 3.7%'>".$isostatus_issued_R2[0]->qty."</td>";
                        echo "<td style='font-size:13px;font-weight:normal;text-align: center;background: #FFFFFF';width: 11.11%'>".$isostatus_total."</td>";
                      
                    echo "</tr>";  
                  echo "</table>";

                    ?>


       <!-- FIN TABLA DE TOTALES SEGUN STATUS -->  