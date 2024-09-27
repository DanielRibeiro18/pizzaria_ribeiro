<?php

use Illuminate\Database\Seeder;
use App\Horario;

class HorarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $horario = new Horario();
        $horario->dia_semana = 'Domingo';
        $horario->hora_abertura = '19:00';
        $horario->hora_fechamento = '23:00';
        $horario->save();

        $horario = new Horario();
        $horario->dia_semana = 'Segunda-feira';
        $horario->hora_abertura = '19:00';
        $horario->hora_fechamento = '23:00';
        $horario->save();

        $horario = new Horario();
        $horario->dia_semana = 'Terça-feira';
        $horario->hora_abertura = '19:00';
        $horario->hora_fechamento = '23:00';
        $horario->save();

        $horario = new Horario();
        $horario->dia_semana = 'Quarta-feira';
        $horario->hora_abertura = '19:00';
        $horario->hora_fechamento = '23:00';
        $horario->save();

        $horario = new Horario();
        $horario->dia_semana = 'Quinta-feira';
        $horario->hora_abertura = '19:00';
        $horario->hora_fechamento = '23:00';
        $horario->save();

        $horario = new Horario();
        $horario->dia_semana = 'Sexta-feira';
        $horario->hora_abertura = '19:00';
        $horario->hora_fechamento = '23:00';
        $horario->save();

        $horario = new Horario();
        $horario->dia_semana = 'Sábado';
        $horario->hora_abertura = '19:00';
        $horario->hora_fechamento = '23:00';
        $horario->save();

    }
}
