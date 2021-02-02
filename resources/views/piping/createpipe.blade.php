@if (Auth::guest())

@else

@extends('layouts.onlyldl')

@section('content')
                                        <center><h3 style="margin-top: 3%">Create Line Panel</h3>
                                           
                                        </center>

                <div class="panel-body">

                   <form class="form-horizontal" role="form" method="POST" action="{{ url('/ldlpipes') }}">
                        {!! csrf_field() !!}
                    
                       
                            <br>

                    <table border class="table table-striped">
                          
                                <tr style="background-color: #F5F8FA;text-align: center">
                                    
                                    <th style="text-align: center;" rowspan="2">Unit</th>
                                    <th style="text-align: center;" rowspan="2">Section</th>
                                    <th style="text-align: center;">Diameter</th>
                                    <th style="text-align: center;">Fluid</th>
                                    <th style="text-align: center;">Line</th>
                                    <th style="text-align: center;">Piping</th>
                                    <th style="text-align: center;" colspan="2">Location</th>
                                    <th style="text-align: center;" colspan="2">Fluid</th>
                        
                                </tr>
                                <tr>
                                    <th style="text-align: center;font-weight: normal">DN</th>
                                    <th style="text-align: center;font-weight: normal">Code</th>
                                    <th style="text-align: center;font-weight: normal">Number</th>
                                    <th style="text-align: center;font-weight: normal">Spec</th>
                                    <th style="text-align: center;font-weight: normal">From</th>
                                    <th style="text-align: center;font-weight: normal">To</th>
                                    <th style="text-align: center;font-weight: normal">Description</th>
                                    <th style="text-align: center;font-weight: normal">PHA</th>
                                <tr>
                                <tr>
                                    <td>
                                       <select id=units_id class="form-control m-bot15" name="units_id">
                                                <option value="NULL">Select Unit...</option>
                                                @foreach($units as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>    
                                                @endforeach
                                       </select>
                                    </td>
                                    <td>
                                        {!! Form::text('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        <select id=diameters_id class="form-control m-bot15" name="diameters_id">
                                                <option value="NULL">Select Diameter...</option>
                                                @foreach($diameters as $diameter)
                                                <option value="{{ $unit->id }}">{{ $diameter->dn }}</option>    
                                                @endforeach
                                       </select>
                                    </td>
                                    <td>
                                         <select id=fluids_id class="form-control m-bot15" name="fluids_id">
                                                <option value="NULL">Select Fluid...</option>
                                                @foreach($fluids as $fluid)
                                                <option value="{{ $fluid->id }}">{{ $fluid->code }}</option>    
                                                @endforeach
                                       </select>
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        <select id=specs_id class="form-control m-bot15" name="specs_id">
                                                <option value="NULL">Select Specification...</option>
                                                @foreach($specs as $spec)
                                                <option value="{{ $spec->id }}">{{ $spec->name }}</option>    
                                                @endforeach
                                       </select>
                                    </td>
                                    <td>
                                      
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        <select id=flu_descs_id class="form-control m-bot15" name="flu_descs_id">
                                                <option value="NULL">Select Description...</option>
                                                @foreach($flu_descs as $flu_desc)
                                                <option value="{{ $flu_desc->id }}">{{ $flu_desc->name }}</option>    
                                                @endforeach
                                       </select>
                                    </td>
                                    <td>
                                        <select id=flu_phas_id class="form-control m-bot15" name="flu_phas_id">
                                                <option value="NULL">Select PHA...</option>
                                                @foreach($flu_phas as $flu_pha)
                                                <option value="{{ $flu_pha->id }}">{{ $flu_pha->name }}</option>    
                                                @endforeach
                                       </select>
                                    </td>

                                <tr>

                                <tr>
                                    <td colspan="10">
                                </tr>

                                <tr style="background-color: #F5F8FA">
                                    
                                    <th style="text-align: center;">Density</th>
                                    <th style="text-align: center;" colspan="2">Operation Conditions</th>
                                    <th style="text-align: center;" colspan="2">Design Conditions</th>
                                    <th style="text-align: center;" colspan="2">ALT 1 - Operation Conditions</th>
                                    <th style="text-align: center;" colspan="2">ALT 1 - Design Conditions</th>

                                </tr>

                                <tr>
                                    <th style="text-align: center;font-weight: normal">KG/M3</th>
                                    <th style="text-align: center;font-weight: normal">Press Bar G</th>
                                    <th style="text-align: center;font-weight: normal">Temp ºC</th>
                                    <th style="text-align: center;font-weight: normal">Press Bar G</th>
                                    <th style="text-align: center;font-weight: normal">Temp ºC</th>
                                    <th style="text-align: center;font-weight: normal">Press Bar G</th>
                                    <th style="text-align: center;font-weight: normal">Temp ºC</th>
                                    <th style="text-align: center;font-weight: normal">Press Bar G</th>
                                    <th style="text-align: center;font-weight: normal">Temp ºC</th>
                
                                <tr>

                                <tr>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    
                                <tr>

                                <tr>
                                    <td colspan="10">
                                </tr>

                                <tr style="background-color: #F5F8FA">
                                    
                                    <th style="text-align: center;" colspan="2">ALT 2 - Operation Conditions</th>
                                    <th style="text-align: center;" colspan="2">ALT 2 - Design Conditions</th>
                                    <th style="text-align: center;">Design Condition</th>
                                    <th style="text-align: center;" colspan="2">Wall Thickness</th>
                                    <th style="text-align: center;" colspan="3">Insulation</th>
                        
                                </tr>
                                <tr>
                                    <th style="text-align: center;font-weight: normal">Press Bar G</th>
                                    <th style="text-align: center;font-weight: normal">Temp ºC</th>
                                    <th style="text-align: center;font-weight: normal">Press Bar G</th>
                                    <th style="text-align: center;font-weight: normal">Temp ºC</th>
                                    <th style="text-align: center;font-weight: normal">Tº Flex ºC</th>
                                    <th style="text-align: center;font-weight: normal">SCH</th>
                                    <th style="text-align: center;font-weight: normal">COR MM</th>
                                    <th style="text-align: center;font-weight: normal">Code</th>
                                    <th style="text-align: center;font-weight: normal">Lim</th>
                                    <th style="text-align: center;font-weight: normal">THX MM</th>
                                <tr>
                                <tr>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        <select id=ins_codes_id class="form-control m-bot15" name="flu_phas_id">
                                                <option value="NULL">Select Code...</option>
                                                @foreach($ins_codes as $ins_code)
                                                <option value="{{ $ins_code->id }}">{{ $ins_code->code }}</option>    
                                                @endforeach
                                       </select>
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>

                                </tr>

                                <tr>
                                    <td colspan="10">
                                </tr>

                                <tr style="background-color: #F5F8FA">
                                    
                                    <th style="text-align: center;" colspan="2">Tracing</th>
                                    <th style="text-align: center;" rowspan="2">Tº Main ºC</th>
                                    <th style="text-align: center;" colspan="2">Paint</th>
                                    <th style="text-align: center;" colspan="3">Test Pressure</th>
                        
                                </tr>
                                <tr>
                                    <th style="text-align: center;font-weight: normal">Size</th>
                                    <th style="text-align: center;font-weight: normal">Nº</th>
                                    <th style="text-align: center;font-weight: normal">1</th>
                                    <th style="text-align: center;font-weight: normal">2</th>
                                    <th style="text-align: center;font-weight: normal">TYP</th>
                                    <th style="text-align: center;font-weight: normal">Min Bar G</th>
                                    <th style="text-align: center;font-weight: normal">Max Bar G</th>

                                <tr>
                                <tr>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>


                                </tr>

                                    <tr>
                                    <td colspan="10">
                                </tr>

                                <tr style="background-color: #F5F8FA">
                                    
                                    <th style="text-align: center;" colspan="3">Authority Control</th>
                                    <th style="text-align: center;" rowspan="2">Cancelled</th>
                                    <th style="text-align: center;" rowspan="2">Review</th>
                                    <th style="text-align: center;" rowspan="2">PID</th>
                                    <th style="text-align: center;" rowspan="2">Notes</th>
                                    <th style="text-align: center;" colspan="3">Safety Accesories</th>
                        
                                </tr>
                                <tr>
                                    <th style="text-align: center;">PHA</th>
                                    <th style="text-align: center;">Group</th>
                                    <th style="text-align: center;">Category</th>


                                    <th style="text-align: center;font-weight: normal">Requirement</th>
                                    <th style="text-align: center;font-weight: normal">Accesory</th>
                                    <th style="text-align: center;font-weight: normal">Notes</th>
                                <tr>
                                <tr>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('class' => 'form-control','required')) !!}
                                    </td>

                                <tr>

                                <tr>
                                    <td colspan="10">
                                </tr>


                    </table>  

                    <br><br>
                        <center><input id="add_btn" type="button" class="btn btn-lg btn-info add" value="Add New (+)">  
                        <input type="submit" class="btn btn-lg btn-primary" value="Create and Close">
                        <input onclick="self.close();" type="submit" class="btn btn-lg btn-default" data-dismiss="modal" value="Close">

                        <!--  /* Evento que se ejecuta cada vez que se selecciona un elemento en el 
                                                select del área */ -->
                                     

                        </center>

                        
                        </form>
                </div>
            
@endsection            
@endif