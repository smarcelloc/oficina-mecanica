<?php

namespace App\Http\Controllers;

use CB;
use CRUDBooster;
use DB;
use Request;
use Schema;


class CBController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function postAddSave()
    {
        $this->cbLoader();
        if (!CRUDBooster::isCreate() && $this->global_privilege == false) {
            CRUDBooster::insertLog(trans('crudbooster.log_try_add_save', [
                'name' => Request::input($this->title_field),
                'module' => CRUDBooster::getCurrentModule()->name,
            ]));
            CRUDBooster::redirect(CRUDBooster::adminPath(), trans("crudbooster.denied_access"));
        }

        $this->validation();
        $this->input_assignment();

        if (Schema::hasColumn($this->table, 'created_at')) {
            $this->arr['created_at'] = date('Y-m-d H:i:s');
        }

        $this->hook_before_add($this->arr);

        //         $this->arr[$this->primary_key] = $id = CRUDBooster::newId($this->table); //error on sql server
        $lastInsertId = $id = DB::table($this->table)->insertGetId($this->arr);

        //fix bug if primary key is uuid
        if ($this->arr[$this->primary_key] != $id)
            $id = $this->arr[$this->primary_key];

        //Looping Data Input Again After Insert
        foreach ($this->data_inputan as $ro) {
            $name = $ro['name'];
            if (!$name) {
                continue;
            }

            $inputdata = Request::get($name);

            //Insert Data Checkbox if Type Datatable
            if ($ro['type'] == 'checkbox') {
                if ($ro['relationship_table']) {
                    $datatable = explode(",", $ro['datatable'])[0];
                    $foreignKey2 = CRUDBooster::getForeignKey($datatable, $ro['relationship_table']);
                    $foreignKey = CRUDBooster::getForeignKey($this->table, $ro['relationship_table']);
                    DB::table($ro['relationship_table'])->where($foreignKey, $id)->delete();

                    if ($inputdata) {
                        $relationship_table_pk = CB::pk($ro['relationship_table']);
                        foreach ($inputdata as $input_id) {
                            DB::table($ro['relationship_table'])->insert([
                                //                                 $relationship_table_pk => CRUDBooster::newId($ro['relationship_table']),
                                $foreignKey => $id,
                                $foreignKey2 => $input_id,
                            ]);
                        }
                    }
                }
            }

            if ($ro['type'] == 'select2') {
                if ($ro['relationship_table']) {
                    $datatable = explode(",", $ro['datatable'])[0];
                    $foreignKey2 = CRUDBooster::getForeignKey($datatable, $ro['relationship_table']);
                    $foreignKey = CRUDBooster::getForeignKey($this->table, $ro['relationship_table']);
                    DB::table($ro['relationship_table'])->where($foreignKey, $id)->delete();

                    if ($inputdata) {
                        foreach ($inputdata as $input_id) {
                            $relationship_table_pk = CB::pk($ro['relationship_table']);
                            DB::table($ro['relationship_table'])->insert([
                                //                                 $relationship_table_pk => CRUDBooster::newId($ro['relationship_table']),
                                $foreignKey => $id,
                                $foreignKey2 => $input_id,
                            ]);
                        }
                    }
                }
            }

            if ($ro['type'] == 'child') {
                $name = str_slug($ro['label'], '');
                $columns = $ro['columns'];
                $getColName = Request::get($name . '-' . $columns[0]['name']);
                $count_input_data = ($getColName) ? (count($getColName) - 1) : 0;
                $child_array = [];
                $fk = $ro['foreign_key'];

                for ($i = 0; $i <= $count_input_data; $i++) {
                    $column_data = [];
                    foreach ($columns as $col) {
                        $colname = $col['name'];
                        $colvalue = Request::get($name . '-' . $colname)[$i];
                        if (!empty($colvalue)) $column_data[$colname] = $colvalue;
                    }
                    if (!empty($column_data)) {
                        $column_data[$fk] = $lastInsertId;
                        $child_array[] = $column_data;
                    }
                }

                $childtable = CRUDBooster::parseSqlTable($ro['table'])['table'];
                DB::table($childtable)->insert($child_array);
            }
        }

        $this->hook_after_add($lastInsertId);

        $this->return_url = ($this->return_url) ? $this->return_url : Request::get('return_url');

        //insert log
        CRUDBooster::insertLog(trans("crudbooster.log_add", ['name' => $this->arr[$this->title_field], 'module' => CRUDBooster::getCurrentModule()->name]));

        if ($this->return_url) {
            if (Request::get('submit') == trans('crudbooster.button_save_more')) {
                CRUDBooster::redirect(Request::server('HTTP_REFERER'), trans("crudbooster.alert_add_data_success"), 'success');
            } else {
                CRUDBooster::redirect($this->return_url, trans("crudbooster.alert_add_data_success"), 'success');
            }
        } else {
            if (Request::get('submit') == trans('crudbooster.button_save_more')) {
                CRUDBooster::redirect(CRUDBooster::mainpath('add'), trans("crudbooster.alert_add_data_success"), 'success');
            } else {
                CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_add_data_success"), 'success');
            }
        }
    }
}
