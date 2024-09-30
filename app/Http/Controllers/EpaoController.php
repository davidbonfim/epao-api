<?php

namespace App\Http\Controllers;

use App\Models\Epao;
use Illuminate\Http\Request;

class EpaoController extends Controller
{
    public function create(){
        
        $epao = Epao::create([    
        'title' => 'Primeiro Epao',
        'verse' => 'Jo 15:12',
        'observation' => 'Love',
        'application' => 'Love your brothers',
        'pray' => 'Lord, help me',    
    ]);
    dd($epao);
    }
}
