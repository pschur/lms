<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'user.view-any',
            'user.view',
            'user.create',
            'user.update',
            'user.delete',
            'user.restore',
            'user.force-delete',

            'class.view-any',
            'class.view',
            'class.create',
            'class.update',
            'class.delete',
            'class.restore',
            'class.force-delete',

            'subject.view-any',
            'subject.view',
            'subject.create',
            'subject.update',
            'subject.delete',
            'subject.restore',
            'subject.force-delete',

            'class.subject.view-any',
            'class.subject.view',
            'class.subject.create',
            'class.subject.update',
            'class.subject.delete',
            'class.subject.restore',
            'class.subject.force-delete',

            'subject.member.view-any',
            'subject.member.view',
            'subject.member.create',
            'subject.member.update',
            'subject.member.delete',
            'subject.member.restore',
            'subject.member.force-delete',

            'season.view-any',
            'season.view',
            'season.create',
            'season.update',
            'season.delete',
            'season.restore',
            'season.force-delete',
        ];

        foreach ($permissions as $permission) {
            $permissions[$permission] = Permission::create([
                'name' => $permission
            ]);
        }

        $student = Role::create(['name' => 'student']);
        $parent = Role::create(['name' => 'parent']);
        $teacher = Role::create(['name' => 'teacher']);
        $admin = Role::create(['name' => 'admin']);

        $admin->givePermissionTo($permissions);
    }
}
