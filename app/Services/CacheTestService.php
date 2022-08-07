<?php

namespace App\Services;

use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class CacheTestService
{
    /** "apc", "array", "database", "file", "memcached", "redis", "dynamodb", "octane", "null" */
    const NOME_CONEXAO_CACHE_ALTERNATIVO = "file";

    public static function all():array{

        $nome_da_chave = 'dev tech tips';
        Cache::get($nome_da_chave, "like_no_vídeo"); //valor padrão caso a chave não exista irá retonar o valor "like_no_vídeo".

        $nome_da_conexao = 'cache';
        Cache::store($nome_da_conexao)->get($nome_da_chave);// trocando a conexão do driver de cache

        $nome_da_conexao = 'redis';
        $tempo_de_vida_em_segundos = 60;// 1 minuto
        $valor = "muito top";
        $nome_da_chave = $nome_da_chave;
        Cache::store($nome_da_conexao)->put($nome_da_chave, $valor, $tempo_de_vida_em_segundos);

        $nome_da_chave = $nome_da_chave;
        Cache::has($nome_da_chave);

        $nome_da_chave = $nome_da_chave;
        $valor_de_incrementacao = 1;
        Cache::increment($nome_da_chave, $valor_de_incrementacao);

        $nome_da_chave = $nome_da_chave;
        $valor_de_decrementacao = 1;
        Cache::decrement($nome_da_chave, $valor_de_decrementacao);
        
        $nome_tabela = 'estados_brasil';
        Cache::remember($nome_tabela, 120, function () use ($nome_tabela) { // 2 minutos
            return DB::table($nome_tabela)->get();
        });

        $nome_tabela = 'estados_brasil';
        Cache::rememberForever($nome_tabela, function () use ($nome_tabela) {
            return DB::table($nome_tabela)->get();
        });

        $nome_da_chave = $nome_da_chave;
        Cache::pull($nome_da_chave); // pega e deleta
        
        $nome_da_chave = $nome_da_chave;
        $valor = $valor;
        Cache::put($nome_da_chave, $valor, 30); // 30 segundos

        $nome_da_chave = $nome_da_chave;
        $valor = $valor;
        Cache::put($nome_da_chave, $valor);

        $nome_da_chave = $nome_da_chave;
        $valor = $valor;
        Cache::put($nome_da_chave, $valor, now()->addMinutes(5));

        
        $nome_da_chave = $nome_da_chave;
        $valor = $valor;
        $tempo_de_vida_em_segundos = $tempo_de_vida_em_segundos;
        Cache::add($nome_da_chave, $valor, $tempo_de_vida_em_segundos); // se ñ existe, cria

        $nome_da_chave = $nome_da_chave;
        $valor = $valor;
        $tempo_de_vida_em_segundos = $tempo_de_vida_em_segundos;
        Cache::forever($nome_da_chave, $valor);

        $nome_da_chave = $nome_da_chave;
        Cache::forget($nome_da_chave);

        $nome_da_chave = $nome_da_chave;
        $valor = $valor;
        $tempo_de_vida_em_segundos = -1;
        Cache::put($nome_da_chave, $valor, $tempo_de_vida_em_segundos); // se tempo ≤ 0, então apaga

        Cache::flush();

        return [];
    }

    public static function consulta_chave($nome_da_chave = null, $valor = null):array{
        $resultado = [];
        $nome_da_chave ??= 'dev tech tips';
        $valor ??= 'conteúdo 2 vezes por semana.';
        $resultado['cache_limpo'] = self::limpar_cache();

        // sem valor padrão (default)
        $resultado['consulta_1'] = Cache::get($nome_da_chave);
        
        // com valor padrão
        $resultado['consulta_2'] = Cache::get($nome_da_chave, 'Se aparecer essa mensagem então dê like no vídeo!');

        Cache::put($nome_da_chave, $valor);
        
        $resultado['consulta_3'] = Cache::get($nome_da_chave, "sem default");

        return $resultado;
    }

    public static function alternando_entre_conexoes($nome_da_chave = null, $nome_conexao = null ):array{
        $resultado = [];
        $nome_da_chave ??= 'dev tech tips';
        $nome_conexao ??= env('CACHE_DRIVER','redis');
        $nome_conexao2 = self::NOME_CONEXAO_CACHE_ALTERNATIVO;
        $valor ??= 'conteúdo 2 vezes por semana.';
        $valor2 ??= 'Se inscreva ne canal.';
        $resultado['cache_limpo'] = self::limpar_cache();
        $resultado['cache_alternativo_limpo'] = self::limpar_cache($nome_conexao2);

        /** CONEXAO 1 */
        $resultado['consulta_1'] = Cache::store($nome_conexao)->get($nome_da_chave);
        
        Cache::put($nome_da_chave, $valor);
        $resultado['consulta_2'] = Cache::store($nome_conexao)->get($nome_da_chave);

        
        /** CONEXAO 2 */
        $resultado['consulta_3'] = Cache::store($nome_conexao2)->get($nome_da_chave);
        Cache::store($nome_conexao2)->put($nome_da_chave, $valor);
        $resultado['consulta_4'] = Cache::store($nome_conexao2)->get($nome_da_chave);

        return $resultado;
    }

    public static function checar_se_chave_existe($nome_da_chave = null):array{
        $resultado = [];
        $nome_da_chave ??= 'dev tech tips';
        $valor ??= 'Momento: '.now()->toDateTimeString();
        $resultado['cache_limpo'] = self::limpar_cache();

        $resultado['consulta_1'] = Cache::get($nome_da_chave) ? true : false;
        $resultado['consulta_2'] = Cache::has($nome_da_chave);

        Cache::put($nome_da_chave, $valor);
        $resultado['consulta_3'] = Cache::get($nome_da_chave) ? true : false;
        $resultado['consulta_4'] = Cache::has($nome_da_chave);
        
        $valor = false;
        Cache::put($nome_da_chave, $valor);
        $resultado['consulta_5'] = "chave existe e é falsa, ". ( Cache::get($nome_da_chave) ? "existe" : "nao existe");
        $resultado['consulta_6'] = "chave existe e é falsa, ". (Cache::has($nome_da_chave) ? "existe" : "nao existe");
        return $resultado;
    }

    public static function aumentar_diminuir_chave():array{
        $resultado = [];
        $nome_da_chave_positiva ??= 'likes';
        $nome_da_chave_negativa ??= 'deslikes';
        $valor_de_incrementacao = rand(1,15);
        $valor_de_decrementacao = rand(1,3);
        //$resultado['cache_limpo'] = self::limpar_cache();

        $resultado[$nome_da_chave_positiva] = Cache::increment($nome_da_chave_positiva, $valor_de_incrementacao);
        $resultado[$nome_da_chave_negativa] = Cache::decrement($nome_da_chave_negativa, $valor_de_decrementacao);

        return $resultado;
    }

    public static function salvar_tabela_cache_temporario():array{
        $nome_tabela = 'estados_brasil';
        $tempo_de_vida_em_segundos = 10; //10 segundos
        // return ['valores_tabela' => Cache::get($nome_tabela)];
        Cache::remember($nome_tabela, $tempo_de_vida_em_segundos, function () use ($nome_tabela) { // 2 minutos
            return DB::table($nome_tabela)->get();
        });
        
        return ['valores_tabela' => Cache::get($nome_tabela)];
    }

    public static function salvar_tabela_cache():array{
        $nome_tabela = 'estados_brasil';
        return ['valores_tabela' => Cache::get($nome_tabela)];
        Cache::rememberForever($nome_tabela,  function () use ($nome_tabela) { // 2 minutos
            return DB::table($nome_tabela)->get();
        });

        return ['valores_tabela' => Cache::get($nome_tabela)];
    }

    public static function consultar_e_remover():array{
        $resultado = [];
        $nome_da_chave ??= 'dev tech tips';
        $resultado['cache_limpo'] = self::limpar_cache();
        $valor ??= 'conteúdo 2 vezes por semana.';
        $resultado['consulta_1'] = Cache::pull($nome_da_chave, 'valor padrão'); // pega e deleta
        Cache::put($nome_da_chave, $valor);
        $resultado['consulta_2'] = Cache::pull($nome_da_chave, 'valor padrão'); // pega e deleta
        $resultado['consulta_3'] = Cache::pull($nome_da_chave); // pega e deleta

        return $resultado;
    }

    public static function salvar_valor():array{
        $resultado = [];
        // return Cache::get(["put_com_ttl","put_sem_ttl","put_com_ttl_agendado","add_com_ttl","forever"]);
        $resultado['cache_limpo'] = self::limpar_cache();

        $tempo_de_vida_em_segundos = 10; //10 segundos
        $chaves[] = $chave = "put_com_ttl"; //ttl = time to life
        $valor = 1;
        Cache::put($chave, $valor, $tempo_de_vida_em_segundos);

        $chaves[] = $chave = "put_sem_ttl";
        $valor = 2;
        Cache::put($chave, $valor);

        $chaves[] = $chave = "put_com_ttl_agendado";
        $valor = 3;
        Cache::put($chave, $valor, now()->addMinutes(5));
        
        $chaves[] = $chave = "add_com_ttl";
        $tempo_de_vida_em_segundos = 20; //20 segundos
        $valor = 4;
        Cache::add($chave, $valor, $tempo_de_vida_em_segundos); // se ñ existe, cria. Se já existe não faz nada

        $chaves[] = $chave = "forever";
        $valor = 5;
        Cache::forever($chave, $valor); // substitui e tira o ttl

        return Cache::get($chaves);
    }

    public static function usando_helper():array{
        $tempo_de_vida_em_segundos = 10;
        cache(['teste' => 'usando helper'], $tempo_de_vida_em_segundos);
        $resultado = cache()->getMultiple([
            "put_com_ttl","put_sem_ttl","put_com_ttl_agendado","add_com_ttl","forever",'teste','dev tech tips'
        ]); // retorna um Iterable
        return (array) $resultado;
    }

    public static function travar_chave(){
        $donos = ['urnau', 'outros'];
        $dono = $donos[rand(0,1)];
        $tempo_de_vida_em_segundos = 30;
        // self::limpar_cache();// não funciona para lock
        $lock = Cache::lock('qualquer_coisa', $tempo_de_vida_em_segundos, $dono);
        $resultado = null;
        if ($lock->get()) {
            $resultado = 'destravado';
            $lock->release(); // remove a trava
        }

        $resultado2 = [];
        $times = [];
        $times[] = now()->toDateTimeString();
        try {
            $lock->block(5);
            $resultado2[] = 'block';
            $times[] = now()->toDateTimeString();
            // Lock acquired after waiting a maximum of 5 seconds...
        } catch (LockTimeoutException $e) {
            $resultado2[] = 'LockTimeoutException';
            $times[] = now()->toDateTimeString();
            // Unable to acquire lock...    
        } finally {
            $resultado2[] = 'optional';
            optional($lock)->release();
            $times[] = now()->toDateTimeString();
        }
        $times[] = now()->toDateTimeString();
        
        return ['resultado' => $resultado, 'dono' => $dono, 'r2' => $resultado2, 'momentos' => $times, 'owner' => $lock->owner()];

    }

    /** @deprecated Não funcionou adequadamente */
    public static function trava_alternativa(){
        // não funcionou
        $resultado = null;
        $lock = Cache::lock('alfa', 10)->block(5, function (){
            $resultado = true;
            return 'ok';
        });
        return ['resultado' => $resultado, 'x' => $lock];
    }

    public static function tags():array{
        $resultados = [];

        $tempo_de_vida_em_segundos = 30;
        Cache::tags(['pessoa', 'modelos'])->put('Alberto', "homem", $tempo_de_vida_em_segundos);
        Cache::tags(['pessoa', 'humoristas'])->put('Karina', "mulher", $tempo_de_vida_em_segundos);
        Cache::tags(['pessoa'])->put('Jandira', "mulher", $tempo_de_vida_em_segundos);

        $resultados['consulta_1'] = Cache::tags(['pessoa', 'humoristas'])->get('Alberto');
        $resultados['consulta_2'] = Cache::tags(['pessoa'])->get('Alberto');
        $resultados['consulta_3'] = Cache::tags([ 'humoristas'])->get('Karina');
        $resultados['consulta_4'] = Cache::tags('humoristas')->get('Karina');
        $resultados['consulta_5'] = Cache::tags(['pessoa'])->get('Jandira');
        $resultados['consulta_6'] = Cache::tags([ 'humoristas', 'pessoa'])->get('Karina');
        $resultados['consulta_7'] = Cache::tags([ 'pessoa', 'humoristas' ])->get('Karina');
        return $resultados;
    }

    public static function limpar_cache($conexao = 'redis'):bool{
        Cache::store($conexao)->flush();
        return true;
    }

}
