<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoMeta extends Model
{
    protected $table = 'autometas';

    public function generateDescription() 
    {
    	$var1 = explode('#', $this->var1);
    	$var2 = explode('#', $this->var2);
    	$var3 = explode('#', $this->var3);
    	$var4 = explode('#', $this->var4);
    	$var5 = explode('#', $this->var5);

    	$description = $this->description;

    	$description = str_replace('{{1}}', $var1[array_rand($var1)], $description);
    	$description = str_replace('{{2}}', $var2[array_rand($var2)], $description);
    	$description = str_replace('{{3}}', $var3[array_rand($var3)], $description);
    	$description = str_replace('{{4}}', $var4[array_rand($var4)], $description);
    	$description = str_replace('{{5}}', $var5[array_rand($var5)], $description);
    	$description = str_replace('{{', '', $description);
    	$description = str_replace('}}', '', $description);
    	$description = trim($description);

    	return $description;
    }

    public function generateTitle()
    {
    	preg_match('/{{[A-Za-z0-9]+}}/', $this->title, $match);

    	$var = trim(strtolower($match[0]), '{{}}');
    	$random = explode('#', $this->$var);

    	return str_replace($match[0], $random[array_rand($random)], $this->title);

    }
}
