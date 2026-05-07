<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    protected $fillable = [
        'company_name', 'about_us', 'vision', 'mission', 'address', 'email', 'phone', 'logo'
    ];
}
