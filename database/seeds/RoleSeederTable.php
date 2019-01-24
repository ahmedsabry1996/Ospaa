<?php

use Illuminate\Database\Seeder;
use App\Role as role;
class RoleSeederTable extends Seeder
{
    

    public function run()
    {
    
    role::create(['role_name'=>'مستخدم عادي']);    
    role::create(['role_name'=>'خدمة عمﻻء']);    
    role::create(['role_name'=>'ادمن مساعد']);    
    role::create(['role_name'=>'ادمن رئيسي']);    

    }
}
