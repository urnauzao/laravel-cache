<?php

namespace App\Http\Controllers;

use App\Services\CacheTestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CacheTestController extends Controller
{
    public function index():JsonResponse{
        $result = [];
        // $result = CacheTestService::all();
        // $result = CacheTestService::consulta_chave();
        // $result = CacheTestService::alternando_entre_conexoes();
        // $result = CacheTestService::checar_se_chave_existe();
        // $result = CacheTestService::aumentar_diminuir_chave();
        // $result = CacheTestService::salvar_tabela_cache_temporario();
        // $result = CacheTestService::salvar_tabela_cache();
        // $result = CacheTestService::consultar_e_remover();
        // $result = CacheTestService::salvar_valor();
        // $result = CacheTestService::usando_helper();
        // $result = CacheTestService::travar_chave();
        // $result = CacheTestService::trava_alternativa(); 
        // $result = CacheTestService::tags();
        return response()->json($result ? $result : ['erro' => 'nenhuma mensagem disponível'], 200);
    }
}
