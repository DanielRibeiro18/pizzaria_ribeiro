<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horarios';

    protected static $dia_sem = [
        'Domingo'=>\Illuminate\Support\Carbon::SUNDAY,
        'Segunda-feira'=>\Illuminate\Support\Carbon::MONDAY,
        'Terça-feira'=>\Illuminate\Support\Carbon::TUESDAY,
        'Quarta-feira'=>\Illuminate\Support\Carbon::WEDNESDAY,
        'Quinta-feira'=>\Illuminate\Support\Carbon::THURSDAY,
        'Sexta-feira'=>\Illuminate\Support\Carbon::FRIDAY,
        'Sábado'=>\Illuminate\Support\Carbon::SATURDAY
    ];

    public static function hoje()
    {
        $semana = array_flip(self::$dia_sem);

        $hoje = $semana[now()->weekday()];

        return $hoje;
    }

    public function estaAberto(){
        $data = now()->toImmutable();

        [$hora_abertura, $minuto_abertura] = explode(':', $this->hora_abertura);
        [$hora_fechamento, $minuto_fechamento] = explode(':', $this->hora_fechamento);

        $data = $data->weekday(self::$dia_sem[$this->dia_semana]);

        $data_abertura = $data->setHour($hora_abertura)->setMinute($minuto_abertura);
        $data_fechamento = $data->setHour($hora_fechamento)->setMinute($minuto_fechamento);

        return $data_abertura <= now() && now() <= $data_fechamento;
    }

}
