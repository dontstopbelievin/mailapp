<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KadastrTables extends Model
{
    protected $table = 'kadastr_tables';
    protected $fillable = ['kadastr_number', 'html'];
}
