namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LivestreamClassPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'livestream_id', 'allow_voice', 'allow_video', 'allow_screen_share', 'allow_chat'
    ];
}
