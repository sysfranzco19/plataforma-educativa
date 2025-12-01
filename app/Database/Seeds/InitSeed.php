<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitSeed extends Seeder
{
    public function run()
    {
        //Primer usuario Administrador
		$data = [
			'nombre'    => 'Admin',
			'apellido' 	=> 'Tiquipaya',
            'email' 	=> 'admin@mail.com',
			'admin'		=> 1,
			'password'  => password_hash('1234', PASSWORD_DEFAULT), //Contraseña por defecto 1234 RECUERDE CAMBIAR
			'created_at' => date("Y-m-d H:i:s")
		];
		$this->db->table('admin')->insert($data);

        //Primer usuario Docente
		$data = [
			'nombre'    => 'Docente',
			'apellido' 	=> 'Tiquipaya',
            'email' 	=> 'docente@mail.com',
			'admin'		=> 1,
			'password'  => password_hash('1234', PASSWORD_DEFAULT), //Contraseña por defecto 1234 RECUERDE CAMBIAR
			'created_at' => date("Y-m-d H:i:s")
		];
		$this->db->table('docente')->insert($data);
    }
}
